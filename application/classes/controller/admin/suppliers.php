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
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
				)						
			);
	        return false;
		}          

	} 

	public function action_view($id, $ajax = null){
		$this->auto_render = false;
			$view = View::factory('admin/suppliers/view')
				->bind('errors', $errors)
				->bind('message', $message);

		$contact = ORM::factory('supplier', $id);
		$view->supplierVO = $this->setVO('supplier', ORM::factory('supplier', $id)); 
		$view->formatos = ORM::factory('format')->find_all(); 
		$view->contatos = array();//ORM::factory('contato')->where('tipo','=','supplier')->and_where('tipo_id','=', $id)->find_all();
			
		$view->teams = ORM::factory('team')->find_all();
		$view->formats = ORM::factory('formats_supplier')->where('supplier_id','=', $id)->find_all();
		$view->current_auth = $this->current_auth;
		
		if($ajax != null){
 			return $view;
 		}else{
			header('Content-Type: application/json');		
			echo json_encode(
				array(
					array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
		}
        return false;
	}

	public function action_edit($id)
	{
		$this->auto_render = false;
		$view = View::factory('admin/suppliers/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$contact = ORM::factory('supplier', $id);
		$view->supplierVO = $this->setVO('supplier', $contact); 
		$view->formatos = ORM::factory('format')->find_all(); 
		$view->contatos = array();//ORM::factory('contato')->where('tipo','=','supplier')->and_where('tipo_id','=', $id)->find_all();
			
		$view->teams = ORM::factory('team')->find_all();

		$view->team_arr = DB::select('team_id')->from('suppliers_teams')->where('supplier_id', '=', $id)->execute()->as_array('team_id');
		$view->formats_arr = DB::select('format_id')->from('formats_suppliers')->where('supplier_id', '=', $id)->execute()->as_array('format_id');

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
			$id = $supplier->id;

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

			$delete_teams_suppliers = DB::delete('suppliers_teams')->where('supplier_id', '=', $supplier->id)->execute();
		 	
		 	$team = $this->request->post('team');
		 	foreach ($team as $key => $value) {				
				$supplier_team = ORM::factory('suppliers_team');
				$supplier_team->team_id = $team[$key];
				$supplier_team->supplier_id = $supplier->id;
				$supplier_team->save();			
			}	
			
			$db->commit();
			$msg = "Fornecedor salvo com sucesso.";
		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'Houveram alguns erros na validação <br/><br/>'.$erroList;

            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            $db->rollback();
        }

        header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getSuppliers(true)->render())),
				array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_view($id, true)->render())),
				//array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/suppliers/index/ajax'),
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
    public function getFiltros(){
    	$this->auto_render = false;
    	$viewFiltros = View::factory('admin/suppliers/filtros');

    	$filtros = Session::instance()->get('kaizen')['filtros'];

  		$viewFiltros->filter_team = array();

  		$viewFiltros->teamList = ORM::factory('team')->order_by('name', 'ASC')->find_all();

		foreach ($filtros as $key => $value) {
  			$viewFiltros->$key = json_decode($value);
  		}

  		return $viewFiltros;
    }


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

		$query = ORM::factory('supplier')
					->join('suppliers_teams', 'INNER')->on('suppliers.id', '=', 'suppliers_teams.supplier_id')//comentar para incluir
					->where('suppliers.order', '=', '1');

		/***Filtros***/
		(isset($view->filter_team)) ? $query->where('suppliers_teams.team_id', 'IN', $view->filter_team) : '';
		(isset($view->filter_empresa)) ? $query->where_open()->where('suppliers.empresa', 'LIKE', '%'.$view->filter_empresa.'%')->or_where('contatos.nome', 'LIKE', '%'.$view->filter_empresa.'%')->where_close() : '';

		$view->suppliersList = $query->group_by('empresa')->order_by('empresa','ASC')->find_all();

		if($ajax != null){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
				)						
			);
	       
	        return false;
	    }
	}  		
}