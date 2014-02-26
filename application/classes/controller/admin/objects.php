<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Objects extends Controller_Admin_Template {
 
	public $auth_required = array('login'); //Auth is required to access this controller
 
	public $secure_actions = array(
                                    'create' => array('login', 'coordenador'),
                                    'edit' => array('login', 'coordenador'),
                                    'delete' => array('login', 'coordenador'),
                                 );
    const ITENS_POR_PAGINA = 20;
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	public function action_index()
	{	
		$view = View::factory('admin/objects/list')
			->bind('message', $message);
		
		$view->filter_tipo = ($this->request->post('tipo') != "") ? json_encode($this->request->post('tipo')) : json_encode(array());
		$view->filter_status = ($this->request->post('status') != "") ? json_encode($this->request->post('status')) : json_encode(array());
		$view->filter_collection = ($this->request->post('collection') != "") ? json_encode($this->request->post('collection')) : json_encode(array());
		$view->filter_supplier = ($this->request->post('supplier') != "") ? json_encode($this->request->post('supplier')) : json_encode(array());
		
		
		//$query = ORM::factory('object');						
		//$count = $query->count_all();
		//$pag = new Pagination( array( 'total_items' => $count, 'items_per_page' => self::ITENS_POR_PAGINA, 'auto_hide' => true ) );
		//$view->page_links = $pag->render();
        $view->projectList = ORM::factory('project')->find_all(); 


		//$view->objectsList = $query->order_by('id','DESC')->limit($pag->items_per_page)->offset($pag->offset)->find_all();
		//$view->linkPage = ($this->assistente)?('view'):('edit');
		//$view->styleExclusao = ($this->assistente)?('style="display:none"'):('');
		$this->template->content = $view;             
	} 
    
	public function action_create(){ 		
        $view = View::factory('admin/objects/create')
			->bind('errors', $errors)
			->bind('message', $message);
		
		$view->isUpdate = false; 
		$this->addValidateJs('public/js/admin/validateObjects.js');
		$view->objVO = $this->setVO('object');
        
        $view->typeObjects = ORM::factory('typeobject')->find_all();
        $view->countries = ORM::factory('country')->find_all();
        $view->suppliers = ORM::factory('supplier')->find_all();        
        $view->collections = ORM::factory('collection')->order_by('name', 'ASC')->find_all();
		
		       
        if (HTTP_Request::POST == $this->request->method()) 
		{           
            $this->salvar();
        }    
        
        $this->template->content = $view;                     
	}
      
	public function action_delete($id)
	{
		/*
		$view = View::factory('admin/objects/list')
			->bind('errors', $errors)
			->bind('message', $message);
		
		try 
		{            
			$objeto = ORM::factory('object', $id);
			$objeto->delete();
			Utils_Helper::mensagens('add','Objeto excluído com sucesso.'); 
		} catch (ORM_Validation_Exception $e) {
			Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$errors = $e->errors('models');
		}
		
		Request::current()->redirect('admin/objects');
		*/
	}

	public function action_edit($id)
    {           
		$view = View::factory('admin/objects/create')
			->bind('errors', $errors)
			->bind('message', $message)
			->set('values', $this->request->post());
                
        //$this->addPlupload();
		$this->addValidateJs();

		$objeto = ORM::factory('object', $id);
        $view->objVO = $this->setVO('object', $objeto);
		$view->isUpdate = true;                             
                
		$view->typeObjects = ORM::factory('typeobject')->find_all();
        $view->countries = ORM::factory('country')->find_all();
        $view->suppliers = ORM::factory('supplier')->find_all();        
        $view->collections = ORM::factory('collection')->order_by('name', 'ASC')->find_all();   
                
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
            $this->salvar($id);
        }

        $this->template->content = $view;
	}
        
    public function action_view($id, $task_id = null)
    {           
        $view = View::factory('admin/objects/view')
            ->bind('errors', $errors)
            ->bind('message', $message);

		$this->addValidateJs();

		$objeto = ORM::factory('object', $id);
        $view->obj = $objeto;   
        $view->user = $this->current_user->userInfos;                          
		        
        $view->taskflows = ORM::factory('objectshistory')->where('object_id', '=', $id)->order_by('created_at', 'DESC')->find_all();

        $obj_history = ORM::factory('objects_statu')->where('object_id', '=', $id)->find_all();

        $view->assign_form = View::factory('admin/tasks/assign_form');
        $view->assign_form->obj = $objeto;  

        $view->form_status = View::factory('admin/objects/form_status');
        $view->form_status->statusList = ORM::factory('statu')->where('type', '=', 'object')->find_all();
        $view->form_status->obj = $objeto; 
 		$view->current_auth = $this->current_auth;
        
        $this->template->content = $view;

	}

	public function action_updateStatus(){
		if (HTTP_Request::POST == $this->request->method()) 
		{ 

			$db = Database::instance();
	        $db->begin();
			
			try 
			{ 
				$object = ORM::factory('objects_statu')->values($this->request->post(), array( 
		                    'object_id', 
		                    'status_id',
		                    'description',
		                    'crono_date',
							));
				$object->userInfo_id = $this->current_user->userInfos->id;	
				$object->save();

				Utils_Helper::mensagens('add','Objeto salvo com sucesso.');
				$db->commit();
				Request::current()->redirect('admin/objects/view/'.$object->object_id);

			} catch (ORM_Validation_Exception $e) {
	            $errors = $e->errors('models');
				$erroList = '';
				foreach($errors as $erro){
					$erroList.= $erro.'<br/>';	
				}
	            $message = 'Houveram alguns erros na validação <br/><br/>'.$erroList;

			    Utils_Helper::mensagens('add',$message);    
	            $db->rollback();
	        } catch (Database_Exception $e) {
	            $message = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
	            Utils_Helper::mensagens('add',$message);
	            $db->rollback();
	        }

	        return false;	
	    }
	}
    

	protected function salvar($id = null)
	{
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$object = ORM::factory('object', $id)->values($this->request->post(), array( 
                    'title', 
                    'taxonomia', 
                    'typeobject_id', 
                    'collection_id', 
                    'supplier_id', 
                    'country_id',
                    'reaproveitamento', 
                    'interatividade',
                    'fase', 
                    'crono_date', 
                    'obs', 
                    'uni', 
                    'cap', 
                    'status', ));
			
			$object->save();

			if(is_null($id)){
				$objectStatus = ORM::factory('objects_statu');
		        $objectStatus->object_id = $object->id;
		        $objectStatus->status_id = '1';
		        $objectStatus->crono_date = date("Y-m-d"); 
				$objectStatus->userInfo_id = $this->current_user->userInfos->id;	
				$objectStatus->save();
			}

			Utils_Helper::mensagens('add','Objeto salvo com sucesso.');
			$db->commit();
			Request::current()->redirect('admin/objects');

		}  catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $message = 'Houveram alguns erros na validação <br/><br/>'.$erroList;

		    Utils_Helper::mensagens('add',$message);    
            $db->rollback();
        } catch (Database_Exception $e) {
            $message = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

        return false;
	}

    /********************************/
    public function action_getCollections($project_id){
		$this->auto_render = false;
		$view = View::factory('admin/objects/table');
		$view->project_id = $project_id;

		//$this->startProfilling();

		$view->filter_tipo = json_decode($this->request->query('tipo'));
		$view->filter_status = json_decode($this->request->query('status'));
		$view->filter_collection  = json_decode($this->request->query('collection'));
		$view->filter_supplier  = json_decode($this->request->query('supplier'));		

		$view->typeObjectsjsList = ORM::factory('objectStatu')->where('typeobject_id', 'IN', DB::Select('id')->from('typeobjects'))->where('project_id', '=', $project_id)->find_all();
		$view->statusList = ORM::factory('objectStatu')->where('status_id', 'IN', DB::Select('id')->from('status'))->where('project_id', '=', $project_id)->group_by('status_id')->find_all();
		
		$view->collectionList = ORM::factory('objectStatu')->where('collection_id', 'IN', DB::Select('collection_id')->from('collections_projects'))->where('project_id', '=', $project_id)->group_by('collection_id')->find_all();
		$view->suppliersList = ORM::factory('objectStatu')->where('supplier_id', 'IN', DB::Select('id')->from('suppliers'))->where('project_id', '=', $project_id)->group_by('supplier_id')->find_all();

		$query = ORM::factory('objectStatu')->where('fase', '=', '1')->where('project_id', '=', $project_id);

		/***Filtros***/
		(count($view->filter_tipo) > 0) ? $query->where('typeobject_id', 'IN', $view->filter_tipo) : '';
		(count($view->filter_status ) > 0) ? $query->where('status_id', 'IN', $view->filter_status)->group_by('status_id') : '';
		(count($view->filter_collection ) > 0) ? $query->where('collection_id', 'IN', $view->filter_collection ) : '';
		(count($view->filter_supplier) > 0) ? $query->where('supplier_id', 'IN', $view->filter_supplier) : '';

		$view->objectsList = $query->order_by('crono_date','ASC')->find_all();
		
		// $this->endProfilling();
		echo $view;
	}    
}