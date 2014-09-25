<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Anotacoes extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
	
	
	/* 
	public $secure_actions     	= array(
									'create' => array('login', 'coordenador'),
									'edit' => array('login', 'coordenador'),
								   	'delete' => array('login', 'admin'),
								 );
	*/
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	public function action_form($object_id)
	{	
		$this->auto_render = false;
		$view = View::factory('admin/anotacoes/form_anotacoes_edit');

		$view->bind('errors', $errors)
			->bind('message', $message);
		
		if(!is_null($this->request->query('anotacao_id'))){
			$view->anotacao_txt = ORM::factory('anotacoes_object', $this->request->query('anotacao_id'));
		}
		$view->object_id = $object_id;
		$view->status_id = $this->request->query('status_id');

		echo $view;          
	} 

	public function action_create($object_id)
	{ 
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar(); 
		} 
	}

	public function action_edit($id)
	{
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar($id); 
		} 
	}

	protected function salvar($id = null)
	{
		$this->auto_render = false;
		
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$anotacao = ORM::factory('anotacoes_object', $id)->values($this->request->post(), array(
				'object_id',
				'object_status_id',
				'anotacao',
			));
			$anotacao->userInfo_id = $this->current_user->userInfos->id;
			$anotacao->save();
			
			$db->commit();

			$msg = "anotação salva com sucesso.";
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
		echo json_encode(array(
			'direita' => URL::base().'admin/objects/view/'.$this->request->post('object_id'),				
			'msg' => $msg,
		));

        return false;
	}
		
	public function action_delete($id)
	{
		$this->auto_render = false;

		$anotacao = ORM::factory('anotacoes_object', $id);
		$object_id = $anotacao->object_id;
		try 
		{          
			$anotacao->delete();
			$msg = "anotação excluída com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'Houveram alguns erros<br/><br/>'.$erroList;
            $db->rollback();
		}

		header('Content-Type: application/json');
		echo json_encode(array(
			'direita' => URL::base().'admin/objects/view/'.$object_id,				
			'msg' => $msg,
		));
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