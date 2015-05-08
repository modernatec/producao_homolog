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
	}
        
	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/suppliers/list')
                ->bind('message', $message);
		
        if($ajax == null){
			$this->template->content = $view;             
		}else{
			$this->auto_render = false;
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getSuppliers(true)->render())),

				)						
			);
	        return false;
		}          

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

		//$view->fornecedorVO = ORM::factory('supplier', $id)->join('contatos', 'INNER')->on('suppliers.id', '=', 'contatos.tipo_id')->where('suppliers.order', '=', '1')->and_where('contatos.tipo','=','supplier');
		$contact = ORM::factory('supplier', $id);
		$view->supplierVO = $this->setVO('supplier', ORM::factory('supplier', $id)); 
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

		//ORM::factory('supplier', $id);	
		$view->current_auth = $this->current_auth;

		header('Content-Type: application/json');		
		echo json_encode(
			array(
				array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
			)						
		);
        return false;
	}

	public function action_edit($id)
	{
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
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
			)						
		);
        return false;
		
		
	}

	public function action_salvar($id = null)
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
			$msg = "Fornecedor salvo com sucesso.";
			//Utils_Helper::mensagens('add',$message);
			//Request::current()->redirect('admin/suppliers');
			//echo URL::base().'admin/suppliers/view/'.$supplier->id;

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
		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/suppliers/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
		
		return false;	
	}
		
	public function action_delete($id)
	{
		try 
		{            
			$contact = ORM::factory('supplier', $id);
			$contact->delete();
			$msg = "Fornecedor excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$msg = 'Houveram alguns erros na validação dos dados.';
			$errors = $e->errors('models');
		}
	
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/suppliers/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
		
		return false;	
	}


    /********************************/
    public function action_getSuppliers($ajax = null){
		$this->auto_render = false;
		$view = View::factory('admin/suppliers/table');

		//$this->startProfilling();
		$view->teams = ORM::factory('team')->find_all();

		if(count($this->request->post('suppliers')) > '0' || Session::instance()->get('kaizen')['model'] != 'suppliers'){
			$kaizen_arr = Utils_Helper::setFilters($this->request->post(), '', "suppliers");
		}else{
			$kaizen_arr = Session::instance()->get('kaizen');
		}

  		Session::instance()->set('kaizen', $kaizen_arr);

  		$filtros = Session::instance()->get('kaizen')['filtros'];
  		foreach ($filtros as $key => $value) {
  			$view->$key = json_decode($value);
  		}

		$query = ORM::factory('supplier')->join('contatos', 'INNER')->on('suppliers.id', '=', 'contatos.tipo_id')->where('suppliers.order', '=', '1')->and_where('contatos.tipo','=','supplier');

		/***Filtros***/
		(isset($view->filter_team)) ? $query->where('team_id', 'IN', $view->filter_team) : '';
		(isset($view->filter_empresa)) ? $query->where_open()->where('suppliers.empresa', 'LIKE', '%'.$view->filter_empresa.'%')->or_where('contatos.nome', 'LIKE', '%'.$view->filter_empresa.'%')->where_close() : '';

		$view->suppliersList = $query->group_by('empresa')->order_by('empresa','ASC')->find_all();

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
}