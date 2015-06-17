<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Objects_Status extends Controller_Admin_Template {
 
	public $auth_required = array('login'); //Auth is required to access this controller
 	
	public $secure_actions = array(
                                    'create' => array('login', 'assistente 2'),
                                    'edit' => array('login', 'assistente 2'),
                                    'delete' => array('login', 'coordenador'),
                                 );
                                 
    const ITENS_POR_PAGINA = 20;
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
	}
	              	
	public function action_update($id){
		$this->auto_render = false;
		$view = View::factory('admin/objects_status/edit');

		$view->bind('errors', $errors)
			->bind('message', $message);

		$objStatus = ORM::factory('objects_statu', $id);
		$arr_objstatus = $this->setVO('objects_statu', $objStatus);

		$object_id = $objStatus->object_id;
		if($id == ""){
			$object_id = $this->request->query('object_id');
			$arr_objstatus['object_id'] = $object_id;
		}	

		$object = ORM::factory('object', $object_id);

		$query = ORM::factory('statu')
		->join('status_teams', 'INNER')->on('status.id', '=', 'status_teams.status_id')
		->join('workflows_status', 'INNER')->on('status.id', '=', 'workflows_status.status_id');

		if($this->current_auth != 'admin'){
			$query->where('status_teams.team_id', '=', $this->current_user->userInfos->team_id);
		}

		$view->statusList = $query->where('workflows_status.workflow_id', '=', $object->workflow_id)->where('type', '=', 'object')->group_by('status')->order_by('status', 'ASC')->find_all();
		
		$view->obj = $object;			

		$view->objVO = $arr_objstatus;

		echo $view;
	}

	public function action_updateStatus($id = null){
		$this->auto_render = false;
		if (HTTP_Request::POST == $this->request->method()) 
		{ 

			$db = Database::instance();
	        $db->begin();

			$object = ORM::factory('objects_statu', $id);
			try 
			{ 
				$object->values($this->request->post(), array( 
		                    'object_id', 
		                    'status_id',
		                    'prova',
		                    'description',
		                    'crono_date',
							));

				
				$object->userInfo_id = (empty($id)) ? $this->current_user->userInfos->id : $object->userInfo_id;	
				
				$object->save();				
				$db->commit();
				$msg = 'status salvo com sucesso.';
			} catch (ORM_Validation_Exception $e) {
	            $errors = $e->errors('models');
				$erroList = '';
				foreach($errors as $erro){
					$erroList.= $erro.'<br/>';	
				}
	            $db->rollback();
	            $msg = 'houveram alguns erros na validação <br/><br/>'.$erroList;
	        } catch (Database_Exception $e) {
	            $db->rollback();
	            $msg = 'houveram alguns erros na base <br/><br/>'.$e->getMessage();
	        }

	        $from = strpos($this->request->post('from'), 'objects');
	        header('Content-Type: application/json');
	        
	        if($from !== false){
				echo json_encode(
					array(
						array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_view($object->object_id, true)->render())),
						array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getObjects($object->object->project_id, true)->render())),
						array('type'=>'msg', 'content'=> $msg),
					)						
				);	
	        }else{
				echo json_encode(
					array(
						array('container' => '#direita', 'type'=>'html', 'content'=>  json_encode($this->action_view($object->object_id, true)->render())),
						array('type'=>'msg', 'content'=> $msg),
					)						
				);		       
	        }

	        return false;	
	    }
	}


	public function action_deleteStatus($id){   
		$this->auto_render = false; 
		$db = Database::instance();
        $db->begin();
		
		$object_status = ORM::factory('objects_statu', $id);
		$object_id = $object_status->object_id;
		$project_id = $object_status->object->project_id;

		try {  
			$tasks = ORM::factory('task')->where('object_status_id', '=', $id)->find_all();
			foreach($tasks as $task){
				$task_status = ORM::factory('tasks_statu')->where('task_id', '=', $task->id)->find_all();
				foreach($task_status as $status){
					$status->delete();
				}

				$task->delete();
			}

			$object_status->delete();

            $db->commit();

            $msg = "Status excluído com sucesso."; 
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
				array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_view($object_id, true)->render())),
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getObjects($project_id, true)->render())),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);	

        return false;		        
	}
}