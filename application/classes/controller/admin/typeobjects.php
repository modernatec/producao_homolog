<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Typeobjects extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'admin'); //Auth is required to access this controller
 					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	protected function addValidateJs(){
		$scripts =   array(
			"public/js/admin/validateTypeObjects.js",
		);
		$this->template->scripts = array_merge( $scripts, $this->template->scripts );
	}
        
	public function action_index()
	{	
		$view = View::factory('admin/typeobjects/list')
			->bind('message', $message);
		
		$view->typeObjectsjsList = ORM::factory('typeobject')->order_by('name','ASC')->find_all();
		$this->template->content = $view;             
	} 

	public function action_create()
    { 
		$view = View::factory('admin/typeobjects/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();
		$view->isUpdate = false;
		$view->typeObjectVO = $this->setVO('typeobject');   
		$this->template->content = $view;
		
		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar();
		}
	}

	public function action_edit($id)
    {      
		$view = View::factory('admin/typeobjects/create')
			->bind('errors', $errors)
			->bind('message', $message);
			
		$this->addValidateJs();
		$view->isUpdate = true; 

		$typeObject = ORM::factory('typeobject', $id);
		$view->typeObjectVO = $this->setVO('typeobject', $typeObject);   
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
			$objeto = ORM::factory('typeobject', $id)->values($this->request->post(), array(
				'name',
			));
			                
			$objeto->save();
			$db->commit();
			
			Utils_Helper::mensagens('add','Tipo de objeto '.$objeto->name.' salvo com sucesso.');
			Request::current()->redirect('admin/typeobjects');

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
	}
	
	public function action_delete($id)
	{	
		try 
		{            
			$objeto = ORM::factory('typeobject', $id);
			$objeto->delete();
			Utils_Helper::mensagens('add','Tipo de objeto excluído com sucesso.'); 
		} catch (ORM_Validation_Exception $e) {
			Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$errors = $e->errors('models');
		}
		
		Request::current()->redirect('admin/typeobjects');
	}
}