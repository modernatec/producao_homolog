<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Repositorios extends Controller_Admin_Template {
 
	public $auth_required		= array('login','admin'); //Auth is required to access this controller
 	
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
		$this->auto_render = false;
		$view = View::factory('admin/repositorios/list')
			->bind('message', $message);
		$view->delete_msg = Kohana::message('models/object', 'repositorio.delete');
		$view->repositoriosList = ORM::factory('repositorio')->order_by('name','DESC')->find_all();
		
		if($ajax != ''){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode('')),
					array('container' => '#direita', 'type'=>'html', 'content'=> json_encode('')),
				)						
			);
	        return false;
	    }
		  
	} 
        
	public function action_edit($id)
    {    
		$this->auto_render = false;  
		$view = View::factory('admin/repositorios/create')
			->bind('errors', $errors)
			->bind('message', $message);

		//$this->addValidateJs("public/js/admin/validateMaterias.js");
		$view->isUpdate = true;  
		$materia = ORM::factory('repositorio', $id);
		$view->objVO = $this->setVO('repositorio', $materia);
		//$this->template->content = $view;

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

        $msg_type = 'normal';
		try 
		{            
			$materia = ORM::factory('repositorio', $id)->values($this->request->post(), array(
				'name',
			));
			                
			$materia->save();
			$db->commit();
			$msg = "repositório salvo com sucesso.";		

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
			$msg_type = 'error';
            $msg = 'houveram alguns erros na validação <br/><br/>'.$erroList;
		    
            $db->rollback();
        } catch (Database_Exception $e) {
        	$msg_type = 'error';
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            
            $db->rollback();
        }

		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_index(true)->render())),
				array('container' => '#direita', 'type'=>'html', 'content'=> json_encode('')),
				array('container' => $msg_type, 'type'=>'msg', 'content'=> $msg),
			)						
		);

        return false;
	}
	
	public function action_delete($id)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();

        $collection_id = $id;
        $msg_type = 'normal';
		
		try 
		{    
			if($this->request->post('repositorio_id') != ''){
				$new = ORM::factory('repositorio', $this->request->post('repositorio_id'));
				DB::update('objects_repositorios')->set(array('repositorio_id' => $new->id))->where('repositorio_id', '=', $id)->execute();
			}

			DB::delete('repositorios')->where('id','=', $id)->execute();

			$db->commit();
			$msg = "repositório excluído com sucesso.";

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
			$msg_type = 'error';
            $msg = $erroList;
            $db->rollback();
        } catch (Database_Exception $e) {
        	$msg_type = 'error';
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            $db->rollback();
        }

		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_index(true)->render())),
				array('container' => '#direita', 'type'=>'html', 'content'=> json_encode('')),
				array('container' => $msg_type, 'type'=>'msg', 'content'=> $msg),
			)						
		);

        return false;
	}

	public function action_deletePanel($id)
	{
		$this->auto_render = false;
		$view = View::factory('admin/repositorios/delete')
					->bind('errors', $errors)
					->bind('message', $message);

		$view->current_auth = $this->current_auth;

		$objects = ORM::factory('objects_repositorio')->where('repositorio_id', '=', $id)->find_all();
		$view->total_objects = count($objects);
		$view->delete_msg = Kohana::message('models/object', 'repositorio.delete');
		$view->repositorio = ORM::factory('repositorio', $id);
		$view->repositorioList = ORM::factory('repositorio')
									->where('id', '!=', $id)
									->order_by('name', 'ASC')->find_all();

		echo $view;
	}

}