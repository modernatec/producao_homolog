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
             
	public function action_index()
	{	
		$view = View::factory('admin/collections/list')
			->bind('message', $message);
		
		$view->collectionsList = ORM::factory('collection')->order_by('name','ASC')->find_all();
		$this->template->content = $view;    
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
		$view = View::factory('admin/collections/create')
				->bind('errors', $errors)
				->bind('message', $message);
	
		$this->addValidateJs("public/js/admin/validateCollections.js");
		$view->isUpdate = true;
				
		$collection = ORM::factory('collection', $id);
		$view->collectionVO = $this->setVO('collection', $collection);
		$view->materiaList = ORM::factory('materia')->find_all();
		$this->template->content = $view;	
	   
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar($id); 
		} 
	}

	protected function salvar($id = null)
	{
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$colecao = ORM::factory('collection', $id)->values($this->request->post(), array(
				'name',
				'op',
				'materia_id',
				'ano'
			));
			               
			
			$colecao->save();
			
			$db->commit();
			Utils_Helper::mensagens('add','Coleção '.$colecao->name.' salvo com sucesso.');
			Request::current()->redirect('admin/collections');

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
	
	public function action_delete($id)
	{
		try 
		{            
			$projeto = ORM::factory('collection', $id);
			$projeto->delete();
			Utils_Helper::mensagens('add','Coleção excluída com sucesso.'); 
		} catch (ORM_Validation_Exception $e) {
			Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$errors = $e->errors('models');
		}
		Request::current()->redirect('admin/collections');
	}

	/*******************************************/

	public function action_getCollections()
	{
		$view = View::factory('admin/collections/list')
			->bind('message', $message);
		
		return "OK";//$view->collectionsList = ORM::factory('collection')->order_by('name','ASC')->find_all();
	}
}