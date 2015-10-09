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
        
	public function action_form($id)
	{	
		$this->auto_render = false;
		$view = View::factory('admin/anotacoes/form_anotacoes_edit');

		$view->bind('errors', $errors)
			->bind('message', $message);
		
		/*
		if(!is_null($id)){
			$view->anotacao_txt = ORM::factory('anotacoes_object', $this->request->query('anotacao_id'));
		}
		*/
		$view->anotacao = ORM::factory('anotacoes_object', $id);
		$view->object_id = $this->request->post('object_id');
		$view->status_id = $this->request->post('status_id');

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
		echo json_encode(
			array(
				array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$this->request->post('object_id')),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
		
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
		echo json_encode(
			array(
				array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$object_id),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
		
		return false;	
	}
}