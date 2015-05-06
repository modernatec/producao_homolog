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

	public function action_path()
	{	
		$this->auto_render = false;
		$objctList = ORM::factory('object')->where('object_id', '!=', '')->and_where('fase', '=', '1')->find_all();
		var_dump(count($objctList));
		foreach ($objctList as $object) {
			$obj = ORM::factory('objects_path');
			$obj->object_id = $object->id;
			$obj->object_reap_id = $object->object_id;
			$obj->save();
		}
		echo 'ok';
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
     
	public function action_view($id, $ajax = null)
    {       
    	$this->auto_render = false;
        $view = View::factory('admin/acervo/view')
            ->bind('errors', $errors)
            ->bind('message', $message);

		$objeto = ORM::factory('object', $id);
        $view->obj = $objeto;   
        $view->user = $this->current_user->userInfos;    

        $array_path = array();
        if($objeto->object_id != ""){        	
            $this->searchPathBehind($array_path, $objeto->object_id);  
        }      
        $view->array_path = $array_path;  

        $array_pathFoward = array();
        $this->searchPathFoward($array_pathFoward, $objeto->id);             
        $view->array_pathFoward = $array_pathFoward;                  
		
        //ALTERAR APOS INCLUSAO DAS TASKS NO STATUS
        $view->objects_status = ORM::factory('objects_statu')->where('object_id', '=', $id)->order_by('created_at', 'DESC')->find_all();
        $last_status = $view->objects_status[0];
        
 		$view->current_auth = $this->current_auth;

 		if($ajax != null){
 			return $view;
 		}else{
	        header('Content-Type: application/json');		
			echo json_encode(
				array(
					array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
	        return false;
	    }
	}

	public function searchPathFoward(&$array, $id){
		$object_path = ORM::factory('object')->where('object_id', '=', $id)->find_all();
		if(count($object_path) > 0){
			foreach ($object_path as $value) {
				array_push($array, $value);
				$this->searchPathFoward($array, $value->id);
			}
		}
	}

	public function searchPathBehind(&$array, $id){
		$object_path = ORM::factory('object', $id);
		array_push($array, $object_path);

		if($object_path->object_id != ''){
			$this->searchPathBehind($array, $object_path->object_id)[0];
		}
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

    public function action_getObjects($page, $ajax = null){
    	//$this->startProfilling();

    	$page = ($page != "") ? $page : Session::instance()->get('kaizen')['parameters'];

		$this->auto_render = false;
		$view = View::factory('admin/acervo/table');

		if(count($this->request->post('acervo')) > '0' || Session::instance()->get('kaizen')['model'] != 'acervo'){
			$kaizen_arr = Utils_Helper::setFilters($this->request->post(), $page, "acervo");
		}else{
			$kaizen_arr = Session::instance()->get('kaizen');
		}

  		Session::instance()->set('kaizen', $kaizen_arr);

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
		if($ajax != null){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
					//array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($viewFiltros->render())),
				)						
			);
	       
	        return false;
	    }
	}    
}