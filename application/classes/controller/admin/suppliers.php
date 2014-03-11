<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Suppliers extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'coordenador'); //Auth is required to access this controller
 
	public $secure_actions     	= array(
								   	'delete' => array('login', 'admin'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	protected function addValidateJs(){
		$scripts =   array(
			"public/js/admin/validateSuppliers.js",
		);
		$this->template->scripts = array_merge( $scripts, $this->template->scripts );
	}
        
	public function action_index()
	{	
		$view = View::factory('admin/suppliers/list')
                ->bind('message', $message);
		
		//$view->filter_tipo = ($this->request->post('tipo') != "") ? json_encode($this->request->post('tipo')) : json_encode(array());
		$view->filter_empresa = ($this->request->post('empresa') != "") ? $this->request->post('empresa') : "";
		$view->filter_contato = ($this->request->post('contato') != "") ? $this->request->post('contato') : "";
		          
        $this->template->content = $view;             
	} 

	public function action_create()
	{ 
		$view = View::factory('admin/suppliers/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();
		$view->isUpdate = false;
		$view->contactVO = $this->setVO('supplier'); 
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar();
		} 
	}

	public function action_edit($id)
	{
		$view = View::factory('admin/suppliers/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();
		$view->isUpdate = true;
		$contact = ORM::factory('supplier', $id);
		$view->contactVO = $this->setVO('supplier', $contact);  		
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
			$contact = ORM::factory('supplier', $id)->values($this->request->post(), array(
				'name',
				'email',
				'telefone',
				'site',
				'empresa',
				'trabalho',
				'observacoes'
			));
			 
			$contact->save();
			$db->commit();
			$message = "Fornecedor '{$contact->empresa}' salvo com sucesso.";
			Utils_Helper::mensagens('add',$message);
			Request::current()->redirect('admin/suppliers');

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
			$contact = ORM::factory('supplier', $id);
			$contact->delete();
			$message = "Fornecedor excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$message = 'Houveram alguns erros na validação dos dados.';
			$errors = $e->errors('models');
		}
	
		Utils_Helper::mensagens('add',$message); 
		Request::current()->redirect('admin/suppliers');
	}


    /********************************/
    public function action_getSuppliers(){
		$this->auto_render = false;
		$view = View::factory('admin/suppliers/table');

		//$this->startProfilling();

		//$view->filter_origem  = json_decode($this->request->query('origem'));			
		$view->filter_empresa = $this->request->query('empresa');
		$view->filter_contato = $this->request->query('contato');	


		//$view->typeObjectsjsList = ORM::factory('objectStatu')->where('typeobject_id', 'IN', DB::Select('id')->from('typeobjects'))->where('project_id', '=', $project_id)->group_by('typeobject_id')->find_all();

		$query = ORM::factory('supplier');

		/***Filtros***/
		//(count($view->filter_origem) > 0) ? $query->where('reaproveitamento', 'IN', $view->filter_origem) : '';
		(!empty($view->filter_empresa)) ? $query->where('empresa', 'LIKE', '%'.$view->filter_empresa.'%') : '';
		(!empty($view->filter_contato)) ? $query->where('name', 'LIKE', '%'.$view->filter_contato.'%') : '';

		$view->suppliersList = $query->order_by('empresa','ASC')->find_all();
		
		// $this->endProfilling();
		echo $view;
	}  		
}