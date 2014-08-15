<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Objects extends Controller_Admin_Template {
 
	//public $auth_required = array('login'); //Auth is required to access this controller
 	/*
	public $secure_actions = array(
                                    'create' => array('login', 'assistente 2'),
                                    'edit' => array('login', 'assistente 2'),
                                    'delete' => array('login', 'coordenador'),
                                 );
    */                             
    const ITENS_POR_PAGINA = 20;
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->check_login();	
	}
	        
	public function action_index($fase = null)
	{	
		$view = View::factory('admin/objects/list')
			->bind('message', $message);
		
		$view->filter_tipo = ($this->request->post('tipo') != "") ? json_encode($this->request->post('tipo')) : json_encode(array());

		$status_init = ORM::factory('statu')->where('type', '=', 'object')->where('status', '!=', 'finalizado')->find_all(); 
		$status_arr = array();
		foreach ($status_init as $status) {
			array_push($status_arr, $status->id);
		}

		$view->filter_status = ($this->request->post('status') != "") ? json_encode($this->request->post('status')) : json_encode($status_arr);
		$view->filter_collection = ($this->request->post('collection') != "") ? json_encode($this->request->post('collection')) : json_encode(array());
		$view->filter_supplier = ($this->request->post('supplier') != "") ? json_encode($this->request->post('supplier')) : json_encode(array());

		$view->filter_origem = ($this->request->post('origem') != "") ? json_encode($this->request->post('origem')) : json_encode(array());		
		$view->filter_materia = ($this->request->post('materia') != "") ? json_encode($this->request->post('materia')) : json_encode(array());

		$view->filter_taxonomia = ($this->request->post('taxonomia') != "") ? $this->request->post('taxonomia') : "";
		$view->fase = (empty($fase)) ? 1 : $fase;
		
		//$query = ORM::factory('object');						
		//$count = $query->count_all();
		//$pag = new Pagination( array( 'total_items' => $count, 'items_per_page' => self::ITENS_POR_PAGINA, 'auto_hide' => true ) );
		//$view->page_links = $pag->render();
        $view->projectList = ORM::factory('project')->where('status', '=', '1')->order_by('name', 'ASC')->find_all(); 


		//$view->objectsList = $query->order_by('id','DESC')->limit($pag->items_per_page)->offset($pag->offset)->find_all();
		//$view->linkPage = ($this->assistente)?('view'):('edit');
		//$view->styleExclusao = ($this->assistente)?('style="display:none"'):('');

		$this->template->content = $view;             
	} 

	public function action_redirect(){
		$this->auto_render = false;
		$view = View::factory('admin/objects/redirect');

		$view->bind('errors', $errors)
			->bind('message', $message);
			
		echo $view;
	}

	public function action_acervo()
	{	
		$this->action_index(2);           
	} 	
    
	public function action_create(){ 		
        $view = View::factory('admin/objects/create')
			->bind('errors', $errors)
			->bind('message', $message);
		
		$view->isUpdate = false; 
		$this->addValidateJs('public/js/admin/validateObjects.js');
		$view->objVO = $this->setVO('object');
        
        $view->typeObjects = ORM::factory('typeobject')->order_by('name', 'ASC')->find_all();
        $view->countries = ORM::factory('country')->find_all();
        $view->suppliers = ORM::factory('supplier')->order_by('order', 'ASC')->order_by('empresa', 'ASC')->find_all();
        $view->collections = ORM::factory('collection')->order_by('name', 'ASC')->find_all();
        $view->formats = ORM::factory('format')->order_by('name', 'ASC')->find_all();
        $view->projectList = ORM::factory('project')->where('status', '=', '1')->order_by('name', 'ASC')->find_all(); 
		
		       
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
                
        $this->addValidateJs('public/js/admin/validateObjects.js');

		$objeto = ORM::factory('object', $id);
        $view->objVO = $this->setVO('object', $objeto);
		$view->isUpdate = true;                             
                
		$view->typeObjects = ORM::factory('typeobject')->order_by('name', 'ASC')->find_all();
        $view->countries = ORM::factory('country')->find_all();
        $view->suppliers = ORM::factory('supplier')->order_by('order', 'ASC')->order_by('empresa', 'ASC')->find_all();        
        $view->collections = ORM::factory('collection')->order_by('name', 'ASC')->find_all();  
        $view->formats = ORM::factory('format')->order_by('name', 'ASC')->find_all(); 
        $view->projectList = ORM::factory('project')->where('status', '=', '1')->order_by('name', 'ASC')->find_all(); 
                
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
            $this->salvar($id);
        }

        $this->template->content = $view;
	}

	public function action_view($id, $task_id = null)
    {       
    	$this->auto_render = false;
        
        $view = View::factory('admin/objects/view')
            ->bind('errors', $errors)
            ->bind('message', $message);


		$this->addValidateJs('public/js/admin/validateTasks.js');

		$objeto = ORM::factory('object', $id);
        $view->obj = $objeto;   
        $view->user = $this->current_user->userInfos;                          
		

        //$view->taskflows = ORM::factory('objectshistory')->where('object_id', '=', $id)->order_by('created_at', 'DESC')->find_all();
        //$last_status = ORM::factory('objectshistory')->where('object_id', '=', $id)->where('type', '=', 'status')->order_by('id', 'DESC')->find(); 

        //ALTERAR APOS INCLUSAO DAS TASKS NO STATUS
        $view->taskflows = ORM::factory('objects_statu')->where('object_id', '=', $id)->order_by('created_at', 'DESC')->find_all();
        $last_status = $view->taskflows[0];

        $view->assign_form = View::factory('admin/tasks/form_assign');
        $view->assign_form->teamList = ORM::factory('userInfo')->where('status', '=', '1')->order_by('nome', 'ASC')->find_all();  
        $view->assign_form->tagList = ORM::factory('tag')->where('type', '=', 'task')->order_by('tag', 'ASC')->find_all();  
        $view->assign_form->obj = $objeto; 
        $view->assign_form->object_status = $last_status;

        $view->anotacoes_form = View::factory('admin/anotacoes/form_anotacoes');
        $view->anotacoes_form->obj = $objeto; 
        $view->anotacoes_form->object_status = $last_status;

        $view->form_status = View::factory('admin/objects/form_status');
        $view->form_status->statusList = ORM::factory('statu')->where('type', '=', 'object')->order_by('status', 'ASC')->find_all();
        $view->form_status->obj = $objeto; 
 		$view->current_auth = $this->current_auth;
        
        //$this->template->content = $view;
        echo $view;
        //$this->endProfilling();
        return true;
	}
    
    /*    
    public function action_view($id, $task_id = null)
    {       
    	//$this->startProfilling();
        
        $view = View::factory('admin/objects/view')
            ->bind('errors', $errors)
            ->bind('message', $message);


		$this->addValidateJs('public/js/admin/validateTasks.js');

		$objeto = ORM::factory('object', $id);
        $view->obj = $objeto;   
        $view->user = $this->current_user->userInfos;                          
		

        //$view->taskflows = ORM::factory('objectshistory')->where('object_id', '=', $id)->order_by('created_at', 'DESC')->find_all();
        //$last_status = ORM::factory('objectshistory')->where('object_id', '=', $id)->where('type', '=', 'status')->order_by('id', 'DESC')->find(); 

        //ALTERAR APOS INCLUSAO DAS TASKS NO STATUS
        $view->taskflows = ORM::factory('objects_statu')->where('object_id', '=', $id)->order_by('created_at', 'DESC')->find_all();
        $last_status = $view->taskflows[0];

        $view->assign_form = View::factory('admin/tasks/form_assign');
        $view->assign_form->teamList = ORM::factory('userInfo')->where('status', '=', '1')->order_by('nome', 'ASC')->find_all();  
        $view->assign_form->tagList = ORM::factory('tag')->where('type', '=', 'task')->order_by('tag', 'ASC')->find_all();  
        $view->assign_form->obj = $objeto; 
        $view->assign_form->object_status = $last_status;

        $view->anotacoes_form = View::factory('admin/anotacoes/form_anotacoes');
        $view->anotacoes_form->obj = $objeto; 
        $view->anotacoes_form->object_status = $last_status;

        $view->form_status = View::factory('admin/objects/form_status');
        $view->form_status->statusList = ORM::factory('statu')->where('type', '=', 'object')->order_by('status', 'ASC')->find_all();
        $view->form_status->obj = $objeto; 
 		$view->current_auth = $this->current_auth;
        
        $this->template->content = $view;
        
        //$this->endProfilling();
        return true;
	}
	*/

	public function action_update($id){
		$this->auto_render = false;
		$view = View::factory('admin/objects/edit');

		$view->bind('errors', $errors)
			->bind('message', $message);

		$view->statusList = ORM::factory('statu')->where('type', '=', 'object')->order_by('status', 'ASC')->find_all();
		
		$objStatus = ORM::factory('objects_statu', $id);
		$view->objVO = $this->setVO('objects_statu', $objStatus);

		echo $view;
	}

	public function action_updateStatus($id = null){
		if (HTTP_Request::POST == $this->request->method()) 
		{ 

			$db = Database::instance();
	        $db->begin();
			
			try 
			{ 
				$object = ORM::factory('objects_statu', $id)->values($this->request->post(), array( 
		                    'object_id', 
		                    'status_id',
		                    'prova',
		                    'description',
		                    'crono_date',
							));

				
				$object->userInfo_id = (empty($id)) ? $this->current_user->userInfos->id : $object->userInfo_id;	
				//$object->userInfo_id = $this->current_user->userInfos->id;
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


	public function action_deleteStatus($id){    
		$db = Database::instance();
        $db->begin();
		
		try {  
			
			$object_status = ORM::factory('objects_statu', $id);
			$object_id = $object_status->object_id;
			
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

            $message = "Status excluído com sucesso."; 
			
			Utils_Helper::mensagens('add',$message);
            Request::current()->redirect('admin/objects/view/'.$object_id);
            
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
                    'project_id',
                    'collection_id', 
                    'supplier_id', 
                    'audiosupplier_id',
                    'country_id',
                    'format_id',
                    'reaproveitamento', 
                    'interatividade',
                    'fase', 
                    'obs', 
                    'uni', 
                    'cap', 
                    'pagina',
                    'status',
                    'tamanho',
                    'duracao',
                    'cessao',
                    'sinopse',
                    'taxonomia_reap',
                    'arq_aberto',
                    'speaker',

                     ));

			
			if($this->request->post('taxonomia_reap') != ""){
				$object_source = ORM::factory('object')->where('taxonomia', '=', $this->request->post('taxonomia_reap'))->find();
				
				$object->object_id = $object_source->id;	
			}else{
				$object->object_id = null;
			}
			
			$object->save();

			if(is_null($id)){
				$objectStatus = ORM::factory('objects_statu');
		        $objectStatus->object_id = $object->id;
		        $objectStatus->status_id = '1';
		        $objectStatus->crono_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->request->post('ini_date'))));
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
    	$query = ORM::factory('Collections_Project')->where('project_id', '=', $project_id)->find_all();

    	$result = array('dados' => array());
    	foreach ($query as $collection) {
    		array_push($result['dados'], array('id' => $collection->collection_id, 'display' => $collection->collection->name));
    	}

    	print json_encode($result);
    }


    public function action_getObjects($project_id){
		$this->auto_render = false;
		$view = View::factory('admin/objects/table');
		$view->project_id = $project_id;

		//$this->startProfilling();
		/*
		$filter = "?fase=".$this->request->query('fase');
		$filter.= "&tipo=".$this->request->query('tipo');
		$filter.= "&collection=".$this->request->query('collection');
		$filter.= "&status=".$this->request->query('status');
		$filter.= "&supplier=".$this->request->query('supplier');
		$filter.= "&taxonomia=".$this->request->query('taxonomia');
		$filter.= "&origem=".$this->request->query('origem');
		$filter.= "&materia=".$this->request->query('materia');

		$view->filter = $filter;
		*/

		
		$view->filter_tipo = json_decode($this->request->query('tipo'));
		$view->filter_status = json_decode($this->request->query('status'));
		$view->filter_collection  = json_decode($this->request->query('collection'));
		$view->filter_supplier  = json_decode($this->request->query('supplier'));
		$view->filter_origem  = json_decode($this->request->query('origem'));
		$view->filter_materia  = json_decode($this->request->query('materia'));					
		$view->filter_taxonomia = $this->request->query('taxonomia');

		$status_init = ORM::factory('statu')->where('type', '=', 'object')->where('status', '!=', 'finalizado')->find_all(); 
		$status_arr = array();
		foreach ($status_init as $status) {
			array_push($status_arr, $status->id);
		}
		$view->reset_filter_status = json_encode($status_arr);

		//$query = DB::select('*')->from('objectStatus')->where('fase', '=', $this->request->query('fase'));
		$query = ORM::factory('objectStatu')->where('fase', '=', $this->request->query('fase'));


		/***Filtros***/
		(count($view->filter_tipo) > 0) ? $query->where('typeobject_id', 'IN', $view->filter_tipo) : '';
		(count($view->filter_status ) > 0) ? $query->where('objectStatus.status_id', 'IN', $view->filter_status) : '';
		(count($view->filter_collection ) > 0) ? $query->where('collection_id', 'IN', $view->filter_collection ) : '';
		(count($view->filter_supplier) > 0) ? $query->where('supplier_id', 'IN', $view->filter_supplier) : '';
		(count($view->filter_origem) > 0) ? $query->where('reaproveitamento', 'IN', $view->filter_origem) : '';
		(count($view->filter_materia) > 0) ? $query->where('materia_id', 'IN', $view->filter_materia) : '';
		(!empty($view->filter_taxonomia)) ? $query->where_open()->where('taxonomia', 'LIKE', '%'.$view->filter_taxonomia.'%')->or_where('title', 'LIKE', '%'.$view->filter_taxonomia.'%')->where_close() : '';


		$view->objectsList = $query->where('project_id', '=', $project_id)->where('collection_id', 'IN', DB::select('collection_id')->from('collections_projects')
			->where('project_id', '=', $project_id))
			->order_by('retorno','ASC')->order_by('taxonomia', 'ASC')->find_all();
		

		/****Filtros*****/

		$typeObjectsList = array();
		$typeObjectsList_arr = array();
		$typeObjectsList_index = array();

		$statusList = array();
		$statusList_arr = array();
		$statusList_index = array();

		$collectionList = array();
		$collectionList_arr = array();
		$collectionList_index = array();

		$suppliersList = array();
		$suppliersList_arr = array();
		$suppliersList_index = array();

		$materiasList = array();
		$materiasList_arr = array();
		$materiasList_index = array();

		$query_filters = DB::select('*')->from('objectStatus')->where('fase', '=', $this->request->query('fase'))
						->where('project_id', '=', $project_id)->where('collection_id', 'IN', DB::select('collection_id')->from('collections_projects')->where('project_id', '=', $project_id))->execute();

		foreach ($query_filters as $object) {
			array_push($typeObjectsList_arr, array('typeobject_id' => $object['typeobject_id'], 'typeobject_name' => $object['typeobject_name']));
			array_push($typeObjectsList_index, $object['typeobject_name']);

			array_push($statusList_arr, array('status_id' => $object['status_id'], 'statu_status' => $object['statu_status']));
			array_push($statusList_index, $object['statu_status']);

			array_push($collectionList_arr, array('collection_id' => $object['collection_id'], 'collection_name' => $object['collection_name']));
			array_push($collectionList_index, $object['collection_name']);

			array_push($suppliersList_arr, array('supplier_id' => $object['supplier_id'], 'supplier_empresa' => $object['supplier_empresa']));
			array_push($suppliersList_index, $object['supplier_empresa']);

			array_push($materiasList_arr, array('materia_id' => $object['materia_id'], 'materia_name' => $object['materia_name']));
			array_push($materiasList_index, $object['materia_name']);
		}

		array_multisort($typeObjectsList_index, SORT_ASC, SORT_STRING, $typeObjectsList_arr);
		array_multisort($statusList_index, SORT_ASC, SORT_STRING, $statusList_arr);
		array_multisort($collectionList_index, SORT_ASC, SORT_STRING, $collectionList_arr);
		array_multisort($suppliersList_index, SORT_ASC, SORT_STRING, $suppliersList_arr);
		array_multisort($materiasList_index, SORT_ASC, SORT_STRING, $materiasList_arr);

		foreach ($typeObjectsList_arr as $typeObject) {
			array_push($typeObjectsList, json_encode($typeObject));
		}

		foreach ($statusList_arr as $status) {
			array_push($statusList, json_encode($status));
		}

		foreach ($collectionList_arr as $collection) {
			array_push($collectionList, json_encode($collection));
		}

		foreach ($suppliersList_arr as $supplier) {
			array_push($suppliersList, json_encode($supplier));
		}

		foreach ($materiasList_arr as $materia) {
			array_push($materiasList, json_encode($materia));
		}

		$view->typeObjectsList = array_unique($typeObjectsList);
		$view->statusList = array_unique($statusList);
		$view->collectionList = array_unique($collectionList);
		$view->suppliersList = array_unique($suppliersList);
		$view->materiasList = array_unique($materiasList);

		//$this->endProfilling();
		echo $view;
	}    
}