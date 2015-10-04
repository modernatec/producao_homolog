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
		
		if($ajax == null){
			$this->template->content = $view;             
		}else{
			$this->auto_render = false;
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
	        return false;
		}           
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
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/typeobjects/index/ajax'),
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
			$objeto = ORM::factory('typeobject', $id);
			$objeto->delete();
			//Utils_Helper::mensagens('add',''); 
			$msg = "tipo de objeto excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			//Utils_Helper::mensagens('add',''); 
			$errors = $e->errors('models');
			$msg = "houveram alguns erros na exclusão dos dados.";
		}
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/typeobjects/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}
}