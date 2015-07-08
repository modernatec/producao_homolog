<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Contatos extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'coordenador'); //Auth is required to access this controller
 
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
		$view = View::factory('admin/contatos/list')
                ->bind('message', $message);
		
        if($ajax == null){
			$this->template->content = $view;             
		}else{
			$this->auto_render = false;
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getContatos(true)->render())),
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
				)						
			);
	        return false;
		}          
	} 

	public function action_edit($id)
	{
		$this->auto_render = false;
		$view = View::factory('admin/contatos/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$view->services = ORM::factory('service')->order_by('name', 'ASC')->find_all();

		$contato = ORM::factory('contato', $id);
		$view->VO = $this->setVO('contato', $contato); 

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
			$contato = ORM::factory('contato', $id)->values($this->request->post(), array(
				'nome',
				'email',
				'telefone',
				'celular',
				'service_id'
			));

			$contato->save();
			
			$db->commit();
			$msg = "contato salvo com sucesso.";
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
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getContatos(true)->render())),
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
			$contact = ORM::factory('contato', $id);
			$contact->delete();
			$message = "contato excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$message = 'Houveram alguns erros na validação dos dados.';
			$errors = $e->errors('models');
		}
	
		Utils_Helper::mensagens('add',$message); 
		Request::current()->redirect('admin/suppliers');
	}


    /********************************/
    public function getFiltros(){
    	$this->auto_render = false;
    	$viewFiltros = View::factory('admin/contatos/filtros');

    	$filtros = Session::instance()->get('kaizen')['filtros'];

  		$viewFiltros->filter_service_id = array();
  		$viewFiltros->services = ORM::factory('service')->order_by('name', 'ASC')->find_all();

		foreach ($filtros as $key => $value) {
  			$viewFiltros->$key = json_decode($value);
  		}

  		return $viewFiltros;
    }


    public function action_getContatos($ajax = null, $view = 'table'){
		$this->auto_render = false;
		$view = View::factory('admin/contatos/'.$view);
		
		//$this->startProfilling();
		$view->teams = ORM::factory('team')->find_all();

		if(count($this->request->post('contatos')) > '0' || Session::instance()->get('kaizen')['model'] != 'contatos'){
			$kaizen_arr = Utils_Helper::setFilters($this->request->post(), '', "contatos");
		}else{
			$kaizen_arr = Session::instance()->get('kaizen');
		}

  		Session::instance()->set('kaizen', $kaizen_arr);

  		$filtros = Session::instance()->get('kaizen')['filtros'];
  		foreach ($filtros as $key => $value) {
  			$view->$key = json_decode($value);
  		}

		$query = ORM::factory('contato');
		/***Filtros***/
		(isset($view->filter_service_id)) ? $query->where('service_id', 'IN', $view->filter_service_id) : '';
		(isset($view->filter_nome)) ? $query->where_open()->where('nome', 'LIKE', '%'.$view->filter_nome.'%')->or_where('email', 'LIKE', '%'.$view->filter_nome.'%')->where_close() : '';

		$view->contatosList = $query->order_by('nome','ASC')->find_all();

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

	public function action_getListContatos($ajax = null){
		$this->auto_render = false;

		$listView = $this->action_getContatos(true, $view = 'dialog_item');
		$listView->services = ORM::factory('service')->order_by('name', 'ASC')->find_all();
		
		$view = View::factory('admin/contatos/dialog_list');
		$view->listView = $listView;

		if($ajax != null){
			echo $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#contatosList', 'type'=>'html', 'content'=> json_encode($listView->render())),
				)						
			);
	    }
	}		
}