<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Suppliers extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array(
									'create' => array('login', 'coordenador'),
									'edit' => array('login', 'coordenador'),
								   	'delete' => array('login', 'admin'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->check_login();	
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

	/*
	public function action_create()
	{ 
		$view = View::factory('admin/suppliers/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs("public/js/admin/validateSuppliers.js");
		$view->isUpdate = false;
		$view->formatos = ORM::factory('format')->find_all();
		$view->supplierVO = $this->setVO('supplier'); 
		$view->teams = ORM::factory('team')->find_all();

		$view->formats_arr = array();

		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar();
		} 
	}
	*/

	public function action_view($id){
		$this->auto_render = false;
			$view = View::factory('admin/suppliers/view')
				->bind('errors', $errors)
				->bind('message', $message);

		$view->fornecedorVO = ORM::factory('supplier', $id);	
		$view->current_auth = $this->current_auth;

		echo $view;	
	}

	public function action_edit($id)
	{
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar($id); 
		}else{ 
			$this->auto_render = false;
			$view = View::factory('admin/suppliers/create')
				->bind('errors', $errors)
				->bind('message', $message);

			$this->addValidateJs();
			$view->isUpdate = true;
			$contact = ORM::factory('supplier', $id);
			$view->supplierVO = $this->setVO('supplier', $contact); 
			$view->formatos = ORM::factory('format')->find_all(); 
			$contatos = ORM::factory('contato')->where('tipo','=','supplier')->and_where('tipo_id','=', $id)->find_all();
				
			$contatos_arr = array();
			foreach ($contatos as $value) {
				array_push($contatos_arr, $this->setVO('contato', $value));
			}
			$view->contactVO = $contatos_arr;

			$view->teams = ORM::factory('team')->find_all();
			$formats_supplier = ORM::factory('formats_supplier')->where('supplier_id','=', $id)->find_all();
			$formats_arr = array();
			foreach ($formats_supplier as $value) {
				array_push($formats_arr, $value->format_id);
			}
			$view->formats_arr = $formats_arr;
			echo $view;
			//$this->template->content = $view;
		}
		
	}

	protected function salvar($id = null)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$supplier = ORM::factory('supplier', $id)->values($this->request->post(), array(
				'site',
				'empresa',
				'observacoes',
				'team_id'
			));

			$supplier->save();

			$delete_contacts = DB::delete('contatos')->where('tipo','=', 'supplier')->and_where('tipo_id', '=', $supplier->id)->execute();

			$email = $this->request->post('email');
			$telefone = $this->request->post('telefone');
			$nome = $this->request->post('nome');
			foreach ($nome as $key => $value) {
				if($nome[$key] != ""){
					$contact = ORM::factory('contato');
					$contact->nome = $value;
					$contact->email = $email[$key];
					$contact->telefone = $telefone[$key];
					$contact->tipo = "supplier";
					$contact->tipo_id = $supplier->id;	
					$contact->save();
				}
			}	

			$delete_contatos_suppliers = DB::delete('formats_suppliers')->where('supplier_id', '=', $supplier->id)->execute();
		 	
		 	$formato = $this->request->post('formato');
		 	foreach ($formato as $key => $value) {				
				$format_supplier = ORM::factory('formats_supplier');
				$format_supplier->format_id = $formato[$key];
				$format_supplier->supplier_id = $supplier->id;
				$format_supplier->save();			
			}	
			
			$db->commit();
			$message = "Fornecedor salvo com sucesso.";
			Utils_Helper::mensagens('add',$message);
			//Request::current()->redirect('admin/suppliers');
			echo URL::base().'admin/suppliers/view/'.$supplier->id;

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
		$view->filter_empresa = ($this->request->post('empresa') != "") ? $this->request->post('empresa') : "";
		$view->filter_contato = ($this->request->post('contato') != "") ? $this->request->post('contato') : "";


		//$view->typeObjectsjsList = ORM::factory('objectStatu')->where('typeobject_id', 'IN', DB::Select('id')->from('typeobjects'))->where('project_id', '=', $project_id)->group_by('typeobject_id')->find_all();

		$query = ORM::factory('supplier')->where('order', '=', '1');

		/***Filtros***/
		//(count($view->filter_origem) > 0) ? $query->where('reaproveitamento', 'IN', $view->filter_origem) : '';
		(!empty($view->filter_empresa)) ? $query->where('empresa', 'LIKE', '%'.$view->filter_empresa.'%') : '';
		(!empty($view->filter_contato)) ? $query->where('name', 'LIKE', '%'.$view->filter_contato.'%') : '';

		$view->suppliersList = $query->order_by('empresa','ASC')->find_all();

		
		// $this->endProfilling();
		echo $view;
	}  		
}