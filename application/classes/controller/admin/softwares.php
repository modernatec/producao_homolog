<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Softwares extends Controller_Admin_Template {
 
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
			"public/js/admin/validateSfwprods.js",
		);
		$this->template->scripts = array_merge( $scripts, $this->template->scripts );
	}
        
	public function action_index()
	{	
		$view = View::factory('admin/softwares/list')
			->bind('message', $message);
		
		$view->sfwprodsList = ORM::factory('software')->order_by('id','DESC')->find_all();
		$this->template->content = $view;             
	} 

	public function action_create()
    { 
		$view = View::factory('admin/softwares/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();
		$view->isUpdate = false;  
		$view->sfwprodVO = $this->setVO('software');
		$this->template->content = $view;
		
		if (HTTP_Request::POST == $this->request->method()) 
		{           
        	$this->salvar();
		}       
	}
        
	public function action_edit($id)
    {  
		$view = View::factory('admin/softwares/create')
		->bind('errors', $errors)
		->bind('message', $message);
		
		$this->addValidateJs();
		$view->isUpdate = true;   
		
		$sfwprod = ORM::factory('software', $id);
		$view->sfwprodVO = $this->setVO('software', $sfwprod);
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
			$sfwprod = ORM::factory('software', $id)->values($this->request->post(), array(
				'nome',
			));
			                
			$sfwprod->save();
			$db->commit();
			Utils_Helper::mensagens('add','Software de produção '.$sfwprod->nome.' salvo com sucesso.');
			Request::current()->redirect('admin/softwares');

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
		try{            
			$objeto = ORM::factory('software', $id);
			$objeto->delete();
			Utils_Helper::mensagens('add','Software de produção excluído com sucesso.'); 
		} catch (ORM_Validation_Exception $e) {
			Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$errors = $e->errors('models');
		}
		
		Request::current()->redirect('admin/softwares');
	}
}