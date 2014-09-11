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

	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/countries/list')
			->bind('message', $message);
		
		$view->countriesjsList = ORM::factory('country')->order_by('name','ASC')->find_all();
		
		if($ajax == null){
			$this->template->content = $view;             
		}else{
			$this->auto_render = false;
			echo $view;
		}           
	} 

	/*
	public function action_create()
    { 
		$view = View::factory('admin/countries/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs("public/js/admin/validateCountries.js");
		$view->isUpdate = false;  
		$view->paisVO = $this->setVO('country');    
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
        	$this->salvar();
		}
	}
	*/
        
	public function action_edit($id)
    {      
    	if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar($id);
		}else{    
			$this->auto_render = false; 
			$view = View::factory('admin/countries/create')
				->bind('errors', $errors)
				->bind('message', $message);

			$this->addValidateJs("public/js/admin/validateCountries.js");		
			$view->isUpdate = true;       
			$pais = ORM::factory('country', $id);
			$view->paisVO = $this->setVO('country', $pais);   		
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
			$pais = ORM::factory('country', $id)->values($this->request->post(), array(
				'name',
			));
			                
			$pais->save();
			$db->commit();

			$msg = "país salvo com sucesso.";
			//Utils_Helper::mensagens('add','');
			//Request::current()->redirect('admin/countries');

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'houveram alguns erros na validação <br/><br/>'.$erroList;

		    //Utils_Helper::mensagens('add',$message);    
            $db->rollback();
        }catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            //Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

        header('Content-Type: application/json');
		echo json_encode(array(
			'esquerda' => URL::base().'admin/countries/index/ajax',				
			'msg' => $msg,
		));

        return false;
	}
	
	public function action_delete($id)
	{	
		$this->auto_render = false;
		try 
		{            
			$objeto = ORM::factory('country', $id);
			$objeto->delete();
			//Utils_Helper::mensagens('add','País excluído com sucesso.'); 
			$msg = "País excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			//Utils_Helper::mensagens('add','); 
			$msg = "Houveram alguns erros na exclusão dos dados.";
			$errors = $e->errors('models');
		}

		header('Content-Type: application/json');
		echo json_encode(array(
			'esquerda' => URL::base().'admin/countries/index/ajax',				
			'msg' => $msg,
		));
		
		//Request::current()->redirect('admin/countries');
	}

}