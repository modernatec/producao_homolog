<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Collections extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'admin');
 	
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
		$view = View::factory('admin/collections/list')
			->bind('message', $message);
		
		$view->collectionsList = ORM::factory('collection')->group_by('ano')->order_by('ano', 'DESC')->find_all();
		
		if($ajax == null){
			$this->template->content = $view;             
		}else{
			$this->auto_render = false;
			echo $view;
		}   
	} 

	public function action_create()
    { 
		$view = View::factory('admin/collections/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs("public/js/admin/validateCollections.js");
		$view->isUpdate = false;
		
		$view->projectVO = $this->setVO('collection');		
		$view->materiaList = ORM::factory('materia')->find_all();
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar();
		}    
	}

	public function action_edit($id)
    {   
    	if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar($id); 
		}else{      
	    	$this->auto_render = false;
			$view = View::factory('admin/collections/create')
					->bind('errors', $errors)
					->bind('message', $message);
		
			//$this->addValidateJs("public/js/admin/validateCollections.js");
			$view->isUpdate = true;
					
			$collection = ORM::factory('collection', $id);
			$view->collectionVO = $this->setVO('collection', $collection);
			$view->materiaList = ORM::factory('materia')->find_all();
			//$this->template->content = $view;	
			echo $view;		   
		}
	}

	protected function salvar($id = null)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$colecao = ORM::factory('collection', $id)->values($this->request->post(), array(
				'name',
				'op',
				'materia_id',
				'ano',
				'fechamento',
			));
			               
			
			$colecao->save();
			
			$db->commit();
			$msg = "coleção salva com sucesso.";
			//Utils_Helper::mensagens('add','Coleção '.$colecao->name.' salvo com sucesso.');
			//Request::current()->redirect('admin/collections');

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'Houveram alguns erros na validação <br/><br/>'.$erroList;
		    //Utils_Helper::mensagens('add',$message);    
            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            //Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

        header('Content-Type: application/json');
		echo json_encode(array(
			'content' => URL::base().'admin/collections/index/ajax',				
			'msg' => $msg,
		));

        return false;
	}
	
	public function action_delete($id)
	{
		$this->auto_render = false;
		try 
		{            
			$projeto = ORM::factory('collection', $id);
			$projeto->delete();
			$msg = "coleção excluída com sucesso.";
			//Utils_Helper::mensagens('add',''); 
		} catch (ORM_Validation_Exception $e) {
			//Utils_Helper::mensagens('add',''); 
			$errors = $e->errors('models');
			$msg = "houveram alguns erros na exclusão dos dados.";
		}

		header('Content-Type: application/json');
		echo json_encode(array(
			'content' => URL::base().'admin/collections/index/ajax',				
			'msg' => $msg,
		));
		//Request::current()->redirect('admin/collections');
	}

	/*******************************************/

	public function action_getList($ano){
		$this->auto_render = false;
		$view = View::factory('admin/collections/table');
		$view->collectionsList = ORM::factory('collection')->where('ano', '=', $ano)->order_by('name','ASC')->find_all();
		echo $view;
	}
	
	public function action_getListProject($ano){
		$this->auto_render = false;

		$view = View::factory('admin/collections/select');


		$collectionsArr = array();
		$collections = ORM::factory('collections_project')->where('project_id', '=', $this->request->query('project_id'))->find_all();
		foreach ($collections as $collection) {
			array_push($collectionsArr, $collection->collection_id);
		}
		$view->collectionsArr = $collectionsArr;
		$view->collectionsList = ORM::factory('collection')->where('ano', '=', $ano)->order_by('name','ASC')->find_all();
		echo $view;
	}
}