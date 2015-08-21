<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Workflows extends Controller_Admin_Template {
 
	public $auth_required		= array('login','admin'); //Auth is required to access this controller
 	
	/*
	public $secure_actions     	= array(
										'create' => array('login', 'coordenador'),
										'edit' => array('login', 'coordenador'),
										'delete' => array('login', 'coordenador'),
                                  );
	*/
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/workflow/list')
			->bind('message', $message);
		
		if($ajax == null){
			return $view;
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
        
	public function action_edit($id, $ajax = null)
    {    
		$this->auto_render = false;  
		$view = View::factory('admin/workflow/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$workflow = ORM::factory('workflow', $id);
		$view->workflowVO = $this->setVO('workflow', $workflow);

		
		$workflow_status = DB::select('status_id')->from('workflows_status')->where('workflow_id', '=', $id)->execute()->as_array();
		$workflow_status = (count($workflow_status) == 0) ? array('0') : $workflow_status;

		/*
		$workflow_tags = DB::select('tag_id')->from('workflows_status_tags')->where('workflow_id', '=', $id)->execute()->as_array();
		$workflow_tags = (count($workflow_tags) == 0) ? array('0') : $workflow_tags;
		*/

		$view->tagsList = ORM::factory('tag')->where('type', '=', 'task')->order_by('tag', 'ASC')->find_all();
		$view->tagsList_sub = ORM::factory('tag')->where('type', '=', 'task')->order_by('tag', 'ASC')->find_all();

		$view->workflowTagsList = ORM::factory('workflows_status_tag')
									->join('tags')->on('tags.id', '=', 'tag_id')
									->where('workflow_id', '=', $id)
									->order_by('order', 'ASC')->find_all();

		$view->statusList = ORM::factory('statu')->where('type', '=', 'object')->where('id', 'NOT IN', $workflow_status)->find_all();
		$view->workflowStatusList = ORM::factory('workflows_statu')->where('type', '=', 'object')
									->join('status')->on('status.id', '=', 'status_id')
									->where('workflow_id', '=', $id)
									->order_by('order', 'ASC')->find_all();
		
		if($ajax != null){
			return $view;
		}else{
			$this->auto_render = false;
			/*
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
			*/
			echo $view;
	        return false;
		}   			
	}

	public function action_salvar($id = null)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();

        $w_id = $id;
        $msg_type = 'normal';

		try 
		{            
			$workflow = ORM::factory('workflow', $id)->values($this->request->post(), array(
				'name',
			));
			                
			$workflow->save();
			$w_id = $workflow->id;

			DB::delete('workflows_status')->where('workflow_id', '=', $workflow->id)->execute();
			DB::delete('workflows_status_tags')->where('workflow_id', '=', $workflow->id)->execute();

			if($this->request->post('item') != ""){
				$i = '0';
				parse_str($this->request->post('item'),$itens); 			
				foreach($itens['item'] as $status_id){
					$x = '0';
					$days_cycle = 0;
					if($this->request->post('tasks_status'.$status_id) != ''){
						
						$days = $this->request->post('days_'.$status_id);
						$sync = $this->request->post('sync_'.$status_id);
						$next_tag_id = $this->request->post('next_tag_id_'.$status_id);
						$to = $this->request->post('to_'.$status_id);
						
						parse_str($this->request->post('tasks_status'.$status_id), $tasks);					
						foreach($tasks['task'] as $key => $tag_id){
							/**rever para passar days via post?**/
							
							//$tag = ORM::factory('tag', $tag_id);

							if($sync[$key] == '0'){
								$days_cycle += $days[$key];
							}
							
							/****/

							$workflow_tags = ORM::factory('workflows_status_tag');
							$workflow_tags->status_id = $status_id;
							$workflow_tags->workflow_id = $workflow->id;
							$workflow_tags->tag_id = $tag_id;				
							$workflow_tags->order = $x;

							$workflow_tags->days = $days[$key];
							$workflow_tags->sync = $sync[$key];
							$workflow_tags->next_tag_id = $next_tag_id[$key];
							$workflow_tags->to = $to[$key];
							
							$workflow_tags->save();

							$x++;
						}
					}	

					$workflow_status = ORM::factory('workflows_statu');
					$workflow_status->status_id = $status_id;
					$workflow_status->workflow_id = $workflow->id;				
					$workflow_status->order = $i;
					$workflow_status->days = $days_cycle;
					$workflow_status->save();

					$i++;
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
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getList(true)->render())),
				//array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_edit($w_id, true)->render())),
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
			$objeto = ORM::factory('workflow', $id);
			$objeto->delete();
			$msg = "workflow excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$msg = "houveram alguns erros na exclusão dos dados.";
			$errors = $e->errors('models');
		}
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getList(true)->render())),
				array('container' => '#direita', 'type'=>'html', 'content'=> json_encode("")),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}

	public function action_getList($ajax = null){
		$this->auto_render = false;
        $view = View::factory('admin/workflow/table');

        $view->workflowList = ORM::factory('workflow')->order_by('name','ASC')->find_all();
        
        // $this->endProfilling();
        if($ajax != null){
            return $view;
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
                    array('container' => '#direita', 'type'=>'html', 'content'=> json_encode("")),
                )                       
            );
           
            return false;
        }
	}

}