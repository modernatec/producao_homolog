<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Userinfos extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array(
								   	'edit' => array('login', 'admin', 'coordenador'),
								   	'delete' => array('login', 'admin', 'coordenador'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	public function action_index()
	{	
            $view = View::factory('admin/userinfos/list')
                ->bind('message', $message);
            $view->userinfosList = ORM::factory('userInfo')->order_by('nome','ASC')->find_all();
            $this->template->content = $view;             
	} 

	public function action_edit($id)
	{
		$view = View::factory('admin/userinfos/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs("public/js/admin/validateUsers.js");	
			
		$view->userinfo = ORM::factory('userInfo', $id);
		$view->anexosView = View::factory('admin/files/anexos');

		$this->template->content = $view;
		$this->template->isUpdate = 1;
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$view->userinfo = $this->salvar($id); 
			Request::current()->redirect(URL::base().'admin/userinfos');
		}             
	}
	
	public function action_create()
	{
		$view = View::factory('admin/userinfos/create')
			->bind('errors', $errors)
			->bind('message', $message)
			->set('values', $this->request->post());

		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$view->userinfo = $this->salvar(); 
			Request::current()->redirect(URL::base().'admin/userinfos');
		}             
	}

	protected function salvar($id = null)
	{
		$this->template->content
			->bind('errors', $errors)
			->bind('message', $message);

		try 
		{            
			$userinfo = ORM::factory('userInfo', $id)->values($this->request->post(), array(
				'nome',
				'email',
				'data_aniversaril',
				'ramal',
				'telefone'
			));                                                
			
			/*$file = $_FILES['arquivo'];
			if(Upload::valid($file))
			{
				if(Upload::not_empty($file))
				{                
					$userinfo->foto = Utils_Helper::uploadNoAssoc($_FILES['arquivo'],'userinfos');
				}
			}
			*/
			Controller_Admin_Files::salvar($this->request, "public/upload/userinfos/", $curriculum->id, "userinfos", $this->current_user, 100);			
				

			$userinfo->save();
			$db->commit();
			$message = "Contato salvo com sucesso.";
			
			Utils_Helper::mensagens('add',$message);
			return $userinfo;

		}  catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $message = 'Houveram alguns erros na validação <br/><br/>'.$erroList;

		    Utils_Helper::mensagens('add',$message);    
            $db->rollback();
        } catch (Database_Exception $e) {
            $message = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

        return false;
	}
	
	public function action_delete($inId)
	{
		try 
		{            
			$userinfo = ORM::factory('userInfo', $inId);
			$userinfo->delete();
			$message = "Usuário excluído com sucesso.";
			Utils_Helper::mensagens('add',$message); 
			Request::current()->redirect(URL::base().'admin/userinfos');
		} catch (ORM_Validation_Exception $e) {
			$message = 'Houveram alguns erros na validação dos dados.';
			$errors = $e->errors('models');
			Utils_Helper::mensagens('add',$message); 
		}
	}
}