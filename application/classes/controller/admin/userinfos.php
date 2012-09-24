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
        
        public function action_delete($inId)
        {
            $view = View::factory('admin/userinfos/list')
            ->bind('errors', $errors)
            ->bind('message', $message);
            try 
            {            
                $userinfo = ORM::factory('userInfo', $inId);
                $userinfo->delete();
                $message = "Usuário excluído com sucesso.";
            } catch (ORM_Validation_Exception $e) {
                $message = 'Houveram alguns erros na validação dos dados.';
                $errors = $e->errors('models');
            }
            $view->userinfosList = ORM::factory('userInfo')->order_by('nome','ASC')->find_all();
            $this->template->content = $view;
            Utils_Helper::mensagens('add',$message); 
        }

        public function action_edit($id)
        {
            $view = View::factory('admin/userinfos/create')
                ->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());

            $userinfo = ORM::factory('userInfo', $id);
            $view->userinfo = $userinfo;

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
                
                $file = $_FILES['arquivo'];
                if(Upload::valid($file))
                {
                    if(Upload::not_empty($file))
                    {                
                        $userinfo->foto = Utils_Helper::uploadNoAssoc($_FILES['arquivo'],'userinfos');
                    }
                }
                $userinfo->save();
                $message = "Contato '{$userinfo->nome}' salvo com sucesso.";
                
                Utils_Helper::mensagens('add',$message);
                return $userinfo;

            } catch (ORM_Validation_Exception $e) {
                $message = 'Houveram alguns erros. Veja à seguir:';
                $errors = $e->errors('models');
                Utils_Helper::mensagens('add',$message);
            }
        }
}