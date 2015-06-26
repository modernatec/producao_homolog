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
	
		$view->isUpdate = true;

		$projeto = ORM::factory('project', $id);
		$view->projectVO = $this->setVO('project', $projeto);
		$view->segmentosList = ORM::factory('segmento')->find_all();
		$view->anosList = ORM::factory('collection')->group_by('ano')->order_by('ano', 'DESC')->find_all();
		$view->collectionsList = ORM::factory('collection')->order_by('name','ASC')->find_all();

		$collectionsArr = array();
		$collections = ORM::factory('collections_project')->where('project_id', '=', $id)->find_all();
		foreach ($collections as $collection) {
			array_push($collectionsArr, $collection->collection_id);
		}
		$view->collectionsArr = $collectionsArr;
		
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
					'description',
					'status',
					'ssid',
					'ano'
				));

				$segmento = ORM::factory('segmento', $this->request->post('segmento_id'));

				$pastaProjeto = Utils_Helper::criaPasta('public/upload/projetos/'.$segmento->pasta.'/', $projeto->pasta, $this->request->post('ano').'_'.$this->request->post('name'));
				$projeto->pasta = $pastaProjeto;                    
				$projeto->save();

				$collections = ORM::factory('collections_project')->where('project_id', '=', $projeto->id)->find_all();
				foreach ($collections as $collection) {
					$collection->delete();
				}

				foreach ($this->request->post('selected') as $collection) {
					$new_collection = ORM::factory('collections_project');
					$new_collection->project_id = $projeto->id;
					$new_collection->collection_id = $collection;
					$new_collection->save();
				}

							
				$db->commit();
				//Utils_Helper::mensagens('add','');
				$msg = "projeto salvo com sucesso.";
				//Request::current()->redirect('admin/projects');

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

        /*
        header('Content-Type: application/json');
		echo json_encode(array(
			'content' => URL::base().'admin/projects/index/ajax',				
			'msg' => $msg,
		));
		*/
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

    /*
    public function action_duplicateObjects(){
    	$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$project_id = '4';
			$collection_id = '36';
			$objects = ORM::factory('object')->where('project_id', '=', $project_id)->where('collection_id', '=', $collection_id)->find_all();
	    	foreach ($objects as $old_object) {
	    		$new_object = ORM::factory('object');
	    		$fields = ORM::factory('object')->list_columns();
			
				foreach($fields as $key=>$value){
					if($key != 'id'){
						$new_object->$key = $old_object->$key;	
					}
				}
				$new_object->project_id = '9';
				$new_object->save();

				$objectStatus = ORM::factory('objects_statu');
		        $objectStatus->object_id = $new_object->id;
		        $objectStatus->status_id = '1';
		        $objectStatus->crono_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '19/05/2014')));
				$objectStatus->userInfo_id = $this->current_user->userInfos->id;	
				$objectStatus->save();
	    	}
						
			$db->commit();
			Utils_Helper::mensagens('add','Objetos copiados com sucesso.');
			Request::current()->redirect('admin/projects');
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
    */
    
}