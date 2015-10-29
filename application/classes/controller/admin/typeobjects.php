<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Typeobjects extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'admin'); //Auth is required to access this controller
 					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/typeobjects/list')
			->bind('message', $message);
		
		$view->typeObjectsjsList = ORM::factory('typeobject')->order_by('name','ASC')->find_all();
		$view->delete_msg = Kohana::message('models/typeobject', 'delete');
		$this->auto_render = false;

		if($ajax != ''){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#direita', 'type'=>'html', 'content'=> json_encode('')),
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode('')),
				)						
			);
		}
	    
	    return false;
		
		/*
		if($ajax == null){
			$this->template->content = $view;             
		}else{
			
		} 
		*/          
	} 

	/*
	public function action_create()
    { 
		$view = View::factory('admin/typeobjects/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs("public/js/admin/validateTypeObjects.js");
		$view->isUpdate = false;
		$view->typeObjectVO = $this->setVO('typeobject');   
		$this->template->content = $view;
		
		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar();
		}
	}
	*/

	public function action_edit($id)
    {    
		$this->auto_render = false;
		$view = View::factory('admin/typeobjects/create')
			->bind('errors', $errors)
			->bind('message', $message);
			
		$view->isUpdate = true; 

		$typeObject = ORM::factory('typeobject', $id);
		$view->typeObjectVO = $this->setVO('typeobject', $typeObject);   
		
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
			$objeto = ORM::factory('typeobject', $id)->values($this->request->post(), array(
				'name',
			));
			                
			$objeto->save();
			$db->commit();
			
			$msg = "cadastro efetuado com sucesso.";
		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
			$msg_type = 'error';
            $msg = 'Houveram alguns erros na validação <br/><br/>'.$erroList;
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
			if($this->request->post('typeobject_id') != ''){
				$new = ORM::factory('typeobject', $this->request->post('typeobject_id'));
				DB::update('objects')->set(array('typeobject_id' => $new->id))->where('typeobject_id', '=', $id)->execute();
			}

			DB::delete('typeobjects')->where('id','=', $id)->execute();

			$db->commit();
			$msg = "tipologia excluída com sucesso.";

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
		$view = View::factory('admin/typeobjects/delete')
					->bind('errors', $errors)
					->bind('message', $message);

		$view->current_auth = $this->current_auth;

		$objects = ORM::factory('object')->where('typeobject_id', '=', $id)->find_all();
		$view->total_objects = count($objects);
		$view->delete_msg = Kohana::message('models/typeobject', 'delete');
		$view->typeObject = ORM::factory('typeobject', $id);
		$view->typeList = ORM::factory('typeobject')
									->where('id', '!=', $id)
									->order_by('name', 'ASC')->find_all();

		echo $view;
	}
}