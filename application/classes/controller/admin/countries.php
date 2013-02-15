<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Countries extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'admin'); //Auth is required to access this controller
 	
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
        
	protected function addValidateJs(){
		$scripts =   array(
			"public/js/admin/validateCountries.js",
		);
		$this->template->scripts = array_merge( $scripts, $this->template->scripts );
	}
        
	public function action_index()
	{	
		$view = View::factory('admin/countries/list')
			->bind('message', $message);
		
		$view->countriesjsList = ORM::factory('country')->order_by('nome','ASC')->find_all();
		$this->template->content = $view;             
	} 

	public function action_create()
    { 
		$view = View::factory('admin/countries/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();
		$view->isUpdate = false;  
		$view->paisVO = $this->setVO('country');    
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
        	$this->salvar();
		}
	}
        
	public function action_edit($id)
    {           
		$view = View::factory('admin/countries/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();		
		$view->isUpdate = true;       
		$pais = ORM::factory('country', $id);
		$view->paisVO = $this->setVO('country', $pais);   		
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
			$pais = ORM::factory('country', $id)->values($this->request->post(), array(
				'nome',
			));
			                
			$pais->save();
			$db->commit();
			Utils_Helper::mensagens('add','País '.$pais->nome.' salvo com sucesso.');
			Request::current()->redirect('admin/countries');

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
			$objeto = ORM::factory('country', $id);
			$objeto->delete();
			Utils_Helper::mensagens('add','País excluído com sucesso.'); 
		} catch (ORM_Validation_Exception $e) {
			Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$errors = $e->errors('models');
		}
		
		Request::current()->redirect('admin/countries');
	}

}