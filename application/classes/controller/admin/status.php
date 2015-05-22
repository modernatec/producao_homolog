<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Status extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'admin'); //Auth is required to access this controller
 					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/status/list')
			->bind('message', $message);
		
		$view->statusList = ORM::factory('statu')->where('type', '=', 'object')->order_by('status','ASC')->find_all();
		
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

	public function action_edit($id)
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
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
			)						
		);
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
			));
			$objeto->type = 'object';
			                
			$objeto->save();

			$teams = ORM::factory('status_team')->where('status_id', '=', $objeto->id)->find_all();
			foreach ($teams as $team) {
				$team->delete();
			}


			foreach ($this->request->post('team') as $team) {
				$new_team = ORM::factory('status_team');
				$new_team->status_id = $objeto->id;
				$new_team->team_id = $team;
				$new_team->save();
			}


			$db->commit();
			
			$msg = "cadastro efetuado com sucesso.";
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
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/status/index/ajax'),
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
			$objeto = ORM::factory('statu', $id);
			$objeto->delete();
			$msg = "tipo de objeto excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$errors = $e->errors('models');
			$msg = "houveram alguns erros na exclusão dos dados.";
		}
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/status/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}
}