<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Acervo extends Controller_Admin_Template {
 
	public $auth_required = array('login'); //Auth is required to access this controller
 	
	public $secure_actions = array(
                                    'create' => array('login', 'assistente 2'),
                                    'edit' => array('login', 'assistente 2'),
                                    'delete' => array('login', 'coordenador'),
                                 );
                                 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
	}
	        
	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/acervo/list')
			->bind('message', $message);

		$view->filter_segmento = array();
		$view->filter_collection = array();
		$view->filter_project = array();
		$view->filter_typeobject = array();

		$view->segmentoList = ORM::factory('segmento')->order_by('name', 'ASC')->find_all();
		$view->collectionList = ORM::factory('collection')->order_by('name', 'ASC')->find_all();
		$view->projectList = ORM::factory('project')->order_by('name', 'ASC')->find_all();
		$view->typeList = ORM::factory('typeobject')->order_by('name', 'ASC')->find_all();
		//$view->projectList = ORM::factory('project')->where('status', '=', '1')->order_by('name', 'ASC')->find_all(); 

		if($ajax == null){
			$this->template->content = $view;             
		}else{
			$this->auto_render = false;
			echo $view;
		}           
	} 
     
	public function action_view($id, $task_id = null)
    {       
    	$this->auto_render = false;
        echo $this->action_window($id, true);
        return true;
	}

	public function action_window($id, $ajax = false){
		$view = View::factory('admin/objects/view')
            ->bind('errors', $errors)
            ->bind('message', $message);

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
        
        if($ajax){
        	return $view;
        }else{
	        $this->template->content = '<div class="content"><div id="esquerda"></div><div id="direita">'.$view.'</div></div>';
	    }
	}
    
	public function action_update($id){
		$this->auto_render = false;
		$view = View::factory('admin/objects/edit');

		$view->bind('errors', $errors)
			->bind('message', $message);

		$view->statusList = ORM::factory('statu')->where('type', '=', 'object')->order_by('status', 'ASC')->find_all();
		
		$objStatus = ORM::factory('objects_statu', $id);	
		$arr_objstatus = $this->setVO('objects_statu', $objStatus);

		if($id == ""){
			$arr_objstatus['object_id'] = $this->request->query('object_id');
		}

		$view->obj = ORM::factory('object', $arr_objstatus['object_id']);

		$view->objVO = $arr_objstatus;

		echo $view;
	}

    /********************************/
    public function action_getProjects($segmento_id){
    	$this->auto_render = false;
    	$query = ORM::factory('project')->where('segmento_id', '=', $segmento_id)->find_all();

    	$result = array('dados' => array());
    	foreach ($query as $project) {
    		array_push($result['dados'], array('id' => $project->id, 'display' => $project->name));
    	}

    	print json_encode($result);
    }

    public function action_getCollections($project_id){
    	$this->auto_render = false;
    	$query = ORM::factory('Collections_Project')->where('project_id', '=', $project_id)->find_all();

    	$result = array('dados' => array());
    	foreach ($query as $collection) {
    		array_push($result['dados'], array('id' => $collection->collection_id, 'display' => $collection->collection->name));
    	}

    	print json_encode($result);
    }

    public function action_getObjects($page){
    	//$this->startProfilling();

    	$project_id = "";//($project_id != "") ? $project_id : Session::instance()->get('kaizen')['parameters'];

		$this->auto_render = false;
		$view = View::factory('admin/acervo/table');
		
		$view->project_id = $project_id;
		$view->fase = (empty($fase)) ? '1' : $this->request->query('fase');

		$status_arr = array();
		//diferente de "finalizado" e "nao iniciado"
		/*
		$status_init = ORM::factory('statu')
			->where('type', '=', 'object')
			->where('id', 'NOT IN', array('1', '8'))->find_all(); 
		
		
		$status_arr = array();
		foreach ($status_init as $status) {
			array_push($status_arr, $status->id);
		}
		*/
		

		if($this->request->post('reset_form') != "" || Session::instance()->get('kaizen')['model'] != "acervo"){		
			$kaizen_arr = array(
				"filtros" => array(
					"filter_tipo" => json_encode(array()),
					"filter_collection" => json_encode(array()),
					"filter_status" => json_encode($status_arr),
					"filter_supplier" => json_encode(array()),
					"filter_taxonomia" => "",
					"filter_origem" => json_encode(array()),
					"filter_materia" => json_encode(array()),
				),
				"parameters" => '',
				"model" => "acervo",
			);

		}else{
			/*filtros*/
			$kaizen_arr = array(
				"filtros" => array(
					"filter_tipo" => ($this->request->post('tipo') != "") ? json_encode($this->request->post('tipo')) : Session::instance()->get('kaizen')['filtros']["filter_tipo"],
					"filter_collection" => ($this->request->post('collection') != "") ? json_encode($this->request->post('collection')) : Session::instance()->get('kaizen')['filtros']["filter_collection"],
					"filter_status" => ($this->request->post('status') != "") ? json_encode($this->request->post('status')) : Session::instance()->get('kaizen')['filtros']["filter_status"],
					"filter_supplier" => ($this->request->post('supplier') != "") ? json_encode($this->request->post('supplier')) : Session::instance()->get('kaizen')['filtros']["filter_supplier"],
					"filter_taxonomia" => ($this->request->post('taxonomia') != "") ? $this->request->post('taxonomia') : Session::instance()->get('kaizen')['filtros']["filter_taxonomia"],
					"filter_origem" => ($this->request->post('origem') != "") ? json_encode($this->request->post('origem')) : Session::instance()->get('kaizen')['filtros']["filter_origem"],	
					"filter_materia" => ($this->request->post('materia') != "") ? json_encode($this->request->post('materia')) : Session::instance()->get('kaizen')['filtros']["filter_materia"],
				),
				"parameters" => '',
				"model" => "acervo",
			);
		}

  		Session::instance()->set('kaizen', $kaizen_arr);
  		//var_dump( Session::instance()->get('kaizen'));

		$filter_tipo = Session::instance()->get('kaizen')['filtros']["filter_tipo"];
		$filter_collection = Session::instance()->get('kaizen')['filtros']["filter_collection"];
		$filter_status = Session::instance()->get('kaizen')['filtros']["filter_status"];
		$filter_supplier = Session::instance()->get('kaizen')['filtros']["filter_supplier"];
		$filter_taxonomia = Session::instance()->get('kaizen')['filtros']["filter_taxonomia"];		
		$filter_origem = Session::instance()->get('kaizen')['filtros']["filter_origem"];
		$filter_materia = Session::instance()->get('kaizen')['filtros']["filter_materia"];

		/*
		$view->action = $project_id.'?fase='.$view->fase
						.'&tipo='.$filter_tipo
						.'&collection='.$filter_collection
						.'&status='.$filter_status
						.'&supplier='.$filter_supplier
						.'&taxonomia='.$filter_taxonomia
						.'&origem='.$filter_origem
						.'&materia='.$filter_materia;	
		
		$view->reset = 	$project_id.'?fase='.$view->fase;
		*/

		//$this->startProfilling();
		/*
		$filter = "?fase=".$this->request->query('fase');
		$filter.= "&tipo=".$this->request->query('tipo');
		$filter.= "&collection=".$this->request->query('collectionstion');
		$filter.= "&status=".$this->request->query('status');
		$filter.= "&supplier=".$this->request->query('supplier');
		$filter.= "&taxonomia=".$this->request->query('taxonomia');
		$filter.= "&origem=".$this->request->query('origem');
		$filter.= "&materia=".$this->request->query('materia');

		$view->filter = $filter;
		*/

		$view->filter_tipo = json_decode($filter_tipo);
		$view->filter_status = json_decode($filter_status);
		$view->filter_collection  = json_decode($filter_collection);
		$view->filter_supplier  = json_decode($filter_supplier);
		$view->filter_origem  = json_decode($filter_origem);
		$view->filter_materia  = json_decode($filter_materia);					
		$view->filter_taxonomia = $filter_taxonomia;

		
		
		//$status_init = ORM::factory('statu')->where('type', '=', 'object')->where('status', '!=', 'finalizado')->find_all(); 
		
		//$status_arr = array();
		//foreach ($status_init as $status) {
		//	array_push($status_arr, $status->id);
		//}
		

		$view->reset_filter_status = json_encode($status_arr);

		$query = ORM::factory('objectStatu')->where('fase', '=', $view->fase);
		/************************/

		// count number of users
		$total_objects = $query->count_all();
		$view->total_objects = $total_objects;

		// set-up the pagination
		$pagination = Pagination::factory(array(
		    'total_items' => $total_objects,
		    'items_per_page' => 50, // this will override the default set in your config
		));

		// get users using the pagination limit/offset
		//$users = ORM::factory('User')->offset($pagination->offset)->limit($pagination->items_per_page)->find_all();

		// pass the users & pagination to the view
		//$this->view->bind('pagination', $pagination);
		//$this->view->bind('users', $users);


		


		/***Filtros***/
		/*
		(count($view->filter_tipo) > 0) ? $query->where('typeobject_id', 'IN', $view->filter_tipo) : '';
		(count($view->filter_status ) > 0) ? $query->where('objectStatus.status_id', 'IN', $view->filter_status) : '';
		(count($view->filter_collection ) > 0) ? $query->where('collection_id', 'IN', $view->filter_collection ) : '';
		(count($view->filter_supplier) > 0) ? $query->where('supplier_id', 'IN', $view->filter_supplier) : '';
		(count($view->filter_origem) > 0) ? $query->where('reaproveitamento', 'IN', $view->filter_origem) : '';
		(count($view->filter_materia) > 0) ? $query->where('materia_id', 'IN', $view->filter_materia) : '';
		(!empty($view->filter_taxonomia)) ? $query->where_open()->where('taxonomia', 'LIKE', '%'.$view->filter_taxonomia.'%')->or_where('title', 'LIKE', '%'.$view->filter_taxonomia.'%')->where_close() : '';
		*/

		/*
		$view->objectsList = $query->where('project_id', '=', $project_id)->where('collection_id', 'IN', DB::select('collection_id')->from('collections_projects')
			->where('project_id', '=', $project_id))
			->order_by('retorno','ASC')->order_by('taxonomia', 'ASC')->find_all();
		*/
		$view->objectsList = $query->order_by('taxonomia', 'ASC')->offset($pagination->offset)->limit($pagination->items_per_page)->find_all();
		$view->pagination = $pagination;

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

		$query_filters = DB::select('*')->from('objectStatus')
							->where('fase', '=', $view->fase)
							->where('project_id', '=', $project_id)
							->where('collection_id', 'IN', DB::select('collection_id')->from('collections_projects')
							->where('project_id', '=', $project_id))
							->execute();

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