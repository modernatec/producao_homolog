<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Projects extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'coordenador');
 	
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
		$view = View::factory('admin/projects/list')
			->bind('message', $message);
		
		if($ajax == null){
			$this->template->content = $view;             
		}else{
			$this->auto_render = false;
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getList(true)->render())),
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
				)						
			);
	        return false;
		}  	
	} 

	public function action_edit($id, $ajax = null)
    {      
		$this->auto_render = false;
		$view = View::factory('admin/projects/create')
				->bind('errors', $errors)
				->bind('message', $message);
	
		$projeto = ORM::factory('project', $id);
		$view->projectVO = $this->setVO('project', $projeto);
		$view->segmentosList = ORM::factory('segmento')->find_all();
		$view->anosList = ORM::factory('collection')->group_by('ano')->order_by('ano', 'DESC')->find_all();

		if($projeto->ano == ''){
			$ano = date('Y');
		}else{
			$ano = $projeto->ano;
		}

		$view->ano = $ano;
		
		/*
		$collection_list = ORM::factory('collection')->where('ano', '=', $ano);

		if($projeto->segmento != ''){
			$collection_list->where('segmento_id', '=', $projeto->segmento->id);
		}

		$view_collections = View::factory('admin/collections/select');
		$view_collections->collectionsList = $collection_list->find_all();
		$view_collections->collectionsArr = DB::select('collection_id')->from('collections_projects')->where('project_id', '=', $projeto->id)->execute()->as_array('collection_id');
		*/
		
		$view->project = $projeto;
		
		if($ajax == null){
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
	        return false;
	    }else{
	    	return $view->render();
	    }
	}

	public function action_salvar($id = null)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();
        $msg_type = 'normal';
        $project_id = $id;
        
		try 
		{         
			$projeto = ORM::factory('project', $id)->values($this->request->post(), array(
				'name',
				'segmento_id',
				'status',
				'ssid',
				'ano'
			));

			$segmento = ORM::factory('segmento', $this->request->post('segmento_id'));
			$rs = $projeto->save();
			if($rs){
				$pastaProjeto = Utils_Helper::criaPasta('public/upload/projetos/'.$segmento->pasta.'/', $projeto->pasta, $this->request->post('ano').'_'.$this->request->post('name'));
				$projeto->pasta = $pastaProjeto;                    
				$projeto->save();
			}

			$project_id = $projeto->id;

			/*
			$collections = DB::delete('collections_projects')->where('project_id','=', $projeto->id)->execute();

			if($this->request->post('selected') != ''){
				foreach ($this->request->post('selected') as $collection) {
					$new_collection = ORM::factory('collections_project');
					$new_collection->project_id = $projeto->id;
					$new_collection->collection_id = $collection;
					$new_collection->save();
				}
			}
			*/
						
			$db->commit();
			$msg = "projeto salvo com sucesso.";
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
				array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
				array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_edit($project_id, true))),
				array('container' => $msg_type, 'type'=>'msg', 'content'=> $msg),
			)						
		);
        return false;
	}

	public function action_delete($id)
	{
		$view = View::factory('admin/projects/list')
			->bind('errors', $errors)
			->bind('message', $message);
		/*
		try 
		{            
			$steps = ORM::factory('projects_step')->where('project_id', '=', $id)->find_all();
			foreach ($steps as $step) {
				$step->delete();
			}

			$projeto = ORM::factory('project', $id);
			$projeto->delete();
			Utils_Helper::mensagens('add','Projeto excluído com sucesso.'); 
		} catch (ORM_Validation_Exception $e) {
			Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$errors = $e->errors('models');
		}
		*/
		Request::current()->redirect('admin/projects');
	}

	public function getFiltros(){
    	$this->auto_render = false;
    	$viewFiltros = View::factory('admin/projects/filtros');

    	$filtros = Session::instance()->get('kaizen')['filtros'];

  		$viewFiltros->filter_segmento = array();
		$viewFiltros->filter_ano = array();
		$viewFiltros->filter_status = array();

  		$viewFiltros->segmentoList = ORM::factory('segmento')->order_by('name', 'ASC')->find_all();
  		$viewFiltros->anosList = ORM::factory('project')->group_by('ano')->order_by('ano', 'DESC')->find_all();

		foreach ($filtros as $key => $value) {
  			$viewFiltros->$key = json_decode($value);
  		}

  		return $viewFiltros;
    }

	public function action_collections($id)
    {	
        $callback = $this->request->query('callback');        
        $dados = array();
        $collectionList = ORM::factory('collection')->where('project_id', '=', $id)->find_all();
        foreach($collectionList as $collection){
            $dado = array('id'=>$collection->id,'name'=>$collection->name);
            array_push($dados,$dado);
        }
        $arr = array('dados'=>$dados);
        print $callback.json_encode($arr);
        exit;
    } 

    public function action_getList($ajax = null){
		$this->auto_render = false;
		$view = View::factory('admin/projects/table');

		if(count($this->request->post('projects')) > '0' || Session::instance()->get('kaizen')['model'] != 'project'){
			$kaizen_arr = Utils_Helper::setFilters($this->request->post(), '', "project");
		}else{
			$kaizen_arr = Session::instance()->get('kaizen');	
		}
		Session::instance()->set('kaizen', $kaizen_arr);

  		$filtros = Session::instance()->get('kaizen')['filtros'];
  		
  		foreach ($filtros as $key => $value) {
  			$view->$key = json_decode($value);
  		}

  		$query = ORM::factory('project');

		(isset($view->filter_segmento)) ? $query->where('segmento_id', 'IN', $view->filter_segmento) : '';
		(isset($view->filter_ano)) ? $query->where('ano', 'IN', $view->filter_ano) : '';
		(isset($view->filter_status)) ? $query->where('status', 'IN', $view->filter_status) : '';
		(isset($view->filter_name)) ? $query->where('name', 'LIKE', '%'.$view->filter_name.'%') : '';
		
		$view->projectsList = $query->order_by('status','DESC')->order_by('name','ASC')->find_all();

		//$query = ORM::factory('project')->where('status', '=', $status_id);		
		//$view->projectsList = $query->order_by('name','ASC')->find_all();
		
		if($ajax != null){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
					array('container' => '#direita', 'type'=>'html', 'content'=> json_encode('')),
				)						
			);
	       
	        return false;
	    }
	}
}