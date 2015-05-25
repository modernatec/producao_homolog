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
		
		$view->workflowList = ORM::factory('workflow')->order_by('id','DESC')->find_all();
		
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
		$view = View::factory('admin/workflow/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$workflow = ORM::factory('workflow', $id);
		$view->workflowVO = $this->setVO('workflow', $workflow);
		$workflow_status = DB::select('status_id')->from('workflows_status')
							->where('workflow_id', '=', $id)->execute()->as_array();

		if(count($workflow_status) == 0){
			$workflow_status = array('0');
		}

		$view->statusList = ORM::factory('statu')->where('type', '=', 'object')->where('id', 'NOT IN', $workflow_status)->find_all();
		$view->workflowStatusList = ORM::factory('statu')->where('type', '=', 'object')
									->join('workflows_status')->on('status.id', '=', 'status_id')
									->where('workflow_id', '=', $id)
									->order_by('order', 'ASC')->find_all();
		

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
			$workflow = ORM::factory('workflow', $id)->values($this->request->post(), array(
				'name',
			));
			                
			$workflow->save();

			$i = '0';
			DB::delete('workflows_status')->where('workflow_id', '=', $workflow->id)->execute();
			parse_str($this->request->post('item'),$itens); 
			
			foreach($itens['item'] as $status_id){
				$workflow_status = ORM::factory('workflows_statu');
				$workflow_status->status_id = $status_id;
				$workflow_status->workflow_id = $workflow->id;
				
				$workflow_status->order = $i;
				$workflow_status->save();

				$i++;
			}

			$db->commit();
			$msg = "workflow salvo com sucesso.";		

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'houveram alguns erros na validação <br/><br/>'.$erroList;
		    ///Utils_Helper::mensagens('add',$message);    
            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            //Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/workflows/index/ajax'),
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
			$objeto = ORM::factory('workflow', $id);
			$objeto->delete();
			//Utils_Helper::mensagens('add',''); 
			$msg = "workflow excluído com sucesso";
		} catch (ORM_Validation_Exception $e) {
			//Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$msg = "houveram alguns erros na exclusão dos dados.";
			$errors = $e->errors('models');
		}
		
		//Request::current()->redirect('admin/materias');
		header('Content-Type: application/json');

		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/workflows/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}

}