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
		
		$view->projectsList = ORM::factory('project')->order_by('name','ASC')->find_all();
		
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
		$collection_list = ORM::factory('collection')->where('ano', '=', $ano);

		if($projeto->segmento != ''){
			$collection_list->where('segmento_id', '=', $projeto->segmento->id);
		}

		$view_collections = View::factory('admin/collections/select');
		$view_collections->collectionsList = $collection_list->find_all();
		$view_collections->collectionsArr = DB::select('collection_id')->from('collections_projects')->where('project_id', '=', $projeto->id)->execute()->as_array('collection_id');

		$view->view_collections = $view_collections;
		
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

        $search = ORM::factory('project')->where('name', '=', $this->request->post('name'))->find_all();
        if(!$id && $search->count() > 0){
        	$msg = 'Já existe um projeto com este nome';
        }else{
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

				$pastaProjeto = Utils_Helper::criaPasta('public/upload/projetos/'.$segmento->pasta.'/', $projeto->pasta, $this->request->post('ano').'_'.$this->request->post('name'));
				$projeto->pasta = $pastaProjeto;                    
				$projeto->save();

				$collections = DB::delete('collections_projects')->where('project_id','=', $projeto->id)->execute();

				if($this->request->post('selected') != ''){
					foreach ($this->request->post('selected') as $collection) {
						$new_collection = ORM::factory('collections_project');
						$new_collection->project_id = $projeto->id;
						$new_collection->collection_id = $collection;
						$new_collection->save();
					}
				}
							
				$db->commit();
				$msg = "projeto salvo com sucesso.";
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
	    }

        header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/projects/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
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

    public function action_getList($status_id, $ajax = null){
		$this->auto_render = false;
		$view = View::factory('admin/projects/table');

		$query = ORM::factory('project')->where('status', '=', $status_id);		
		$view->projectsList = $query->order_by('name','ASC')->find_all();
		
		if($ajax != null){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
	       
	        return false;
	    }
	}
}