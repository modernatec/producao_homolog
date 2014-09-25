<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Format extends Controller_Admin_Template {
 
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
		$view = View::factory('admin/formats/list')
			->bind('message', $message);
		
		$view->sfwprodsList = ORM::factory('format')->order_by('id','DESC')->find_all();
		
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
		$view = View::factory('admin/formats/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs("public/js/admin/validateSfwprods.js");
		$view->isUpdate = false;  
		$view->sfwprodVO = $this->setVO('format');
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
			$view = View::factory('admin/formats/create')
			->bind('errors', $errors)
			->bind('message', $message);
			
			$this->addValidateJs();
			$view->isUpdate = true;   
			
			$sfwprod = ORM::factory('format', $id);
			$view->sfwprodVO = $this->setVO('format', $sfwprod);
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
			$sfwprod = ORM::factory('format', $id)->values($this->request->post(), array(
				'name',
			));
			                
			$sfwprod->save();
			$db->commit();
			//Utils_Helper::mensagens('add','');
			$msg = "formato salvo com sucesso.";
			//Request::current()->redirect('admin/format');

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'houveram alguns erros na validação <br/><br/>'.$erroList;

		    //Utils_Helper::mensagens('add',$message);    
            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'houveram alguns erros na base <br/><br/>'.$e->getMessage();
            //Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

        header('Content-Type: application/json');
		echo json_encode(array(
			'content' => URL::base().'admin/format/index/ajax',				
			'msg' => "formato salvo com sucesso.",
		));

        return false;
	}
	
	public function action_delete($id)
	{	
		$this->auto_render = false;
		try{            
			$objeto = ORM::factory('format', $id);
			$objeto->delete();
			//Utils_Helper::mensagens('add','Software de produção excluído com sucesso.'); 
			$msg = "formato excluído com sucesso";
		} catch (ORM_Validation_Exception $e) {
			//Utils_Helper::mensagens('add',''); 
			$msg = "houveram alguns erros na exclusão dos dados.";
			$errors = $e->errors('models');
		}

		header('Content-Type: application/json');
		echo json_encode(array(
			'content' => URL::base().'admin/format/index/ajax',				
			'msg' => $msg,
		));
		
		//Request::current()->redirect('admin/format');
	}
}