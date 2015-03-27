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
			
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
	        return false;
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

    	$page = ($page != "") ? $page : Session::instance()->get('kaizen')['parameters'];

		$this->auto_render = false;
		$view = View::factory('admin/acervo/table');

		if(count($this->request->post()) > '0' || Session::instance()->get('kaizen')['model'] != 'acervo'){
			$kaizen_arr = Utils_Helper::setFilters($this->request->post(), $page, "acervo");
		}else{
			$kaizen_arr = Session::instance()->get('kaizen');
		}

  		Session::instance()->set('kaizen', $kaizen_arr);
  		//var_dump( Session::instance()->get('kaizen'));

  		$filtros = Session::instance()->get('kaizen')['filtros'];
  		foreach ($filtros as $key => $value) {
  			$view->$key = json_decode($value);
  		}

		$query = ORM::factory('objectStatu')
		->where('fase', '=', '1')
		->and_where('status_id', '=', '8');
		/************************/

		/***Filtros***/
		(isset($view->filter_taxonomia)) ? $query->where_open()->where('taxonomia', 'LIKE', '%'.$view->filter_taxonomia.'%')->or_where('title', 'LIKE', '%'.$view->filter_taxonomia.'%')->where_close() : '';
		(isset($view->filter_segmento)) ? $query->and_where('segmento_id', 'IN', $view->filter_segmento) : '';
		(isset($view->filter_project )) ? $query->and_where('project_id', 'IN', $view->filter_project) : '';		
		(isset($view->filter_collection )) ? $query->and_where('collection_id', 'IN', $view->filter_collection ) : '';
		(isset($view->filter_tipo)) ? $query->and_where('typeobject_id', 'IN', $view->filter_tipo) : '';
		
		// count number of objects
		$total_objects = $query->count_all();
		$view->total_objects = $total_objects;

		// set-up the pagination
		$pagination = Pagination::factory(array(
		    'total_items' => $total_objects,
		    'items_per_page' => 50, // this will override the default set in your config
		));

		/**estranho*/
		$query = ORM::factory('objectStatu')
		->where('fase', '=', '1')
		->and_where('status_id', '=', '8');

		/***Filtros***/
		(isset($view->filter_taxonomia)) ? $query->where_open()->where('taxonomia', 'LIKE', '%'.$view->filter_taxonomia.'%')->or_where('title', 'LIKE', '%'.$view->filter_taxonomia.'%')->where_close() : '';
		(isset($view->filter_segmento)) ? $query->and_where('segmento_id', 'IN', $view->filter_segmento) : '';
		(isset($view->filter_project )) ? $query->and_where('project_id', 'IN', $view->filter_project) : '';		
		(isset($view->filter_collection )) ? $query->and_where('collection_id', 'IN', $view->filter_collection ) : '';
		(isset($view->filter_tipo)) ? $query->and_where('typeobject_id', 'IN', $view->filter_tipo) : '';
		

		$view->objectsList = $query->order_by('title', 'ASC')->offset($pagination->offset)->limit($pagination->items_per_page)->find_all();
		$view->pagination = $pagination;

		
		//$this->endProfilling();
		echo $view;
	}    
}