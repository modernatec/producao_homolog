<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Status extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'admin'); //Auth is required to access this controller
 					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
    
	public function action_getListStatus($ajax = null){
		$this->auto_render = false;
		$table_view = View::factory('admin/status/table');

		$table_view->statusList = ORM::factory('statu')->where('type', '=', 'workflow')->order_by('order','ASC')->find_all();

		if($ajax != null){
       		return $table_view;
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($table_view->render())),
                    array('container' => '#direita', 'type'=>'html', 'content'=> json_encode("")),
                )                       
            );
           
            return false;
        }
	}

	/**
	**Reordena as tarefas por drag. 	
	**/
	public function action_reorder(){
		$this->auto_render = false;
		if (HTTP_Request::POST == $this->request->method()) 
		{
			$i = '0';
			foreach($this->request->post('item') as $status_id){
				$task = ORM::factory('statu', $status_id);
				$task->order = $i;
				$task->save();

				$i++;
			}
		}
	}

	public function action_edit($id, $ajax = null)
    {    
		$this->auto_render = false;
		$view = View::factory('admin/status/create')
			->bind('errors', $errors)
			->bind('message', $message);
			
		$status = ORM::factory('statu', $id);
		$view->statusVO = $this->setVO('statu', $status); 

		$view->teamList = ORM::factory('team')->find_all();  

		$view->teamsArray = ORM::factory('status_team')->where('status_id', '=', $id)->find_all();

		$teamsArray = array();
		$teams = ORM::factory('status_team')->where('status_id', '=', $id)->find_all();
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
					array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
		}
        return false;		
	}

	public function action_salvar($id = null)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$objeto = ORM::factory('statu', $id)->values($this->request->post(), array(
				'status',
				'color',
				'team_id'
			));
			$objeto->type = 'workflow';
			                
			$objeto->save();

			if($this->request->post('team') != ""){
				DB::delete('status_teams')->where('status_id','=', $objeto->id)->execute();			
				foreach ($this->request->post('team') as $team) {
					$new_team = ORM::factory('status_team');
					$new_team->status_id = $objeto->id;
					$new_team->team_id = $team;
					$new_team->save();
				}
			}


			$db->commit();
			
			$msg = "tudo certo!";
			$msg_type = 'normal';

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = $erroList;
            $msg_type = 'error';

            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            $msg_type = 'error';

            $db->rollback();
        }

		header('Content-Type: application/json');
		echo json_encode(
			array(	
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getListStatus(true)->render())),
				array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_edit($id, true)->render())),
				array('container' => $msg_type, 'type'=>'msg', 'content'=> $msg),
			)						
		);
		
		return false;	
	}
	
	public function action_delete($id)
	{	
		$this->auto_render = false;
		try 
		{            
			$objeto = ORM::factory('statu', $id);
			$objeto->delete();
			$msg = "status excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$errors = $e->errors('models');
			$msg = "houveram alguns erros na exclusão dos dados.";
		}
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getListStatus(true)->render())),
				array('container' => '#direita', 'type'=>'html', 'content'=> json_encode("")),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}
}