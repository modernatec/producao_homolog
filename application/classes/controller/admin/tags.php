<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tags extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'admin'); //Auth is required to access this controller
 					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/tags/list')
			->bind('message', $message);
		
		$view->table = $this->getListTags();
		
		if($ajax == null){
			$this->template->content = $view;             
		}else{
			$this->auto_render = false;
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
	        return false;
		}           
	} 

	public function getListTags(){
		$this->auto_render = false;
		$table_view = View::factory('admin/tags/table');
		$table_view->list = ORM::factory('tag')->where('type', '=', 'task')->order_by('order','ASC')->find_all();

		return $table_view;
	}

	/**
	**Reordena as tarefas por drag. 	
	**/
	public function action_reorder(){
		$this->auto_render = false;
		if (HTTP_Request::POST == $this->request->method()) 
		{
			$i = '0';
			foreach($this->request->post('item') as $tag_id){
				$task = ORM::factory('tag', $tag_id);
				$task->order = $i;
				$task->save();

				$i++;
			}
		}
	}

	public function action_edit($id, $ajax = null)
    {    
		$this->auto_render = false;
		$view = View::factory('admin/tags/create')
			->bind('errors', $errors)
			->bind('message', $message);
			
		$tag = ORM::factory('tag', $id);
		$view->statusVO = $this->setVO('tag', $tag); 

		$view->teamList = ORM::factory('team')->find_all();  
		$view->tagsList = ORM::factory('tag')->order_by('order', 'ASC')->find_all();  
		$view->teamsArray = ORM::factory('tags_team')->where('tag_id', '=', $id)->find_all();

		$teamsArray = array();
		$teams = ORM::factory('tags_team')->where('tag_id', '=', $id)->find_all();
		foreach ($teams as $team) {
			array_push($teamsArray, $team->team_id);
		}
		$view->teamsArray = $teamsArray;
		
		if($ajax != null){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
	        return false;		
	    }
	}

	public function action_salvar($id = null)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$tag = ORM::factory('tag', $id)->values($this->request->post(), array(
				'tag',
				'color',
				'days',
				'sync',
				'next_tag_id',
				'to',
			));
			$tag->type = 'task';
			$tag->save();

			DB::delete('tags_teams')->where('tag_id', '=', $tag->id)->execute();

			if($this->request->post('team') != ""){
				foreach ($this->request->post('team') as $team) {
					$new_team = ORM::factory('tags_team');
					$new_team->tag_id = $tag->id;
					$new_team->team_id = $team;
					$new_team->save();
				}
			}

			$db->commit();
			
			$msg = "tudo certo!";
		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'Houveram alguns erros na validação <br/><br/>'.$erroList;

            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            $db->rollback();
        }

		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->getListTags()->render())),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
		
		return false;	
	}
	
	public function action_delete($id)
	{	
		$this->auto_render = false;
		try 
		{            
			DB::delete('workflows_status_tags')->where('tag_id','=', $id)->execute();

			$objeto = ORM::factory('tag', $id);
			$objeto->delete();
			$msg = "tarefa excluída com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$errors = $e->errors('models');
			$msg = "houveram alguns erros na exclusão dos dados.";
		}
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/tags/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}
}