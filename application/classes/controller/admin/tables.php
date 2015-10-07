<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tables extends Controller_Admin_Template {
 
	public $auth_required		= array('login','coordenador'); //Auth is required to access this controller
 	
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

	public function action_getListTables($user_id){
		$this->auto_render = false;

		$view = View::factory('admin/tables/list');
		
        header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
                array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->action_getFiltros()->render())),
                
            )                       
        );
       
        return false;
	}

	public function action_getFiltros(){
		$table_view = View::factory('admin/tables/filtros');
		$table_view->list = ORM::factory('table')->order_by('name','ASC')->find_all();
		return $table_view;
	}

	public function action_edit($id)
    {    
		$this->auto_render = false;  
		$view = View::factory('admin/services/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$service = ORM::factory('service', $id);
		$view->VO = $this->setVO('service', $service);

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
			$table = ORM::factory('table', $id)->values($this->request->post(), array(
				'name',
			));
			                
			$table->save();

			$db->commit();
			$msg = "tudo certo!";
		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'houveram alguns erros na validação <br/><br/>'.$erroList;
            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            $db->rollback();
        }

		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->action_getFiltros()->render())),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);

        return false;
	}
	
	public function action_delete($id)
	{	
		$this->auto_render = false;
		try 
		{            
			$objeto = ORM::factory('service', $id);
			$objeto->delete();
			$msg = "serviço excluído.";
		} catch (ORM_Validation_Exception $e) {
			$msg = "houveram alguns erros na exclusão dos dados.";
			$errors = $e->errors('models');
		}
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getListServices(true)->render())),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}

}