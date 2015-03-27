<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Teams extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array(
									'edit' => array('login', 'admin'),
									'create' => array('login', 'admin'),
								   	'delete' => array('login', 'admin'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
	
	public function action_index($ajax = null)
	{	
        $view = View::factory('admin/teams/list')
            ->bind('message', $message);
        $view->teamsList = ORM::factory('team')->order_by('name','ASC')->find_all();
        //$this->template->content = $view;             

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
		$view = View::factory('admin/teams/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$view->isUpdate = false;			
		$this->addValidateJs("public/js/admin/validateTeams.js");
		$view->projectVO = $this->setVO('team');
		
		$view->userInfos = ORM::factory('userInfo')->find_all();
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
		$view = View::factory('admin/teams/create')
			->bind('errors', $errors)
			->bind('message', $message);

		
		$this->addValidateJs("public/js/admin/validateTeams.js");
		$view->isUpdate = true;		
		$team = ORM::factory('team', $id);		
		$view->teamVO = $this->setVO('team', $team);

		$view->userInfos = ORM::factory('userInfo')->find_all();
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
			$team = ORM::factory('team', $id)->values($this->request->post(), array(
				'name', 'userInfo_id'
			)); 
			$team->save();
			$db->commit();
			
			$msg = "time salvo com sucesso.";
			//Utils_Helper::mensagens('add',$message);
			//Request::current()->redirect('admin/teams');
			
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
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/teams/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
		
		return false;	
	}
	
	public function action_delete($inId)
	{
		/*
		$view = View::factory('admin/teams/list')
		->bind('errors', $errors)
		->bind('message', $message);
		try 
		{            
			$team = ORM::factory('team', $inId);
			$team->delete();
			$message = "Equipe excluída com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$message = 'Houveram alguns erros na validação dos dados.';
			$errors = $e->errors('models');
		}
		$view->teamsList = ORM::factory('team')->order_by('id','ASC')->find_all();
		$this->template->content = $view;
		Utils_Helper::mensagens('add',$message); 
		*/
	}
}