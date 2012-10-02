<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Teams extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array(
								   	'edit' => array('login', 'coordenador'),
								   	'delete' => array('login', 'coordenador'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
        protected function addValidateJs(){
            $scripts =   array(
                "public/js/admin/validateTeams.js",
            );
            $this->template->scripts = array_merge( $scripts, $this->template->scripts );
        }
        
	public function action_index()
	{	
            $view = View::factory('admin/teams/list')
                ->bind('message', $message);
            $view->teamsList = ORM::factory('team')->order_by('name','ASC')->find_all();
            $this->template->content = $view;             
	} 

	public function action_create()
        { 
            $view = View::factory('admin/teams/create')
                ->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());

            $this->addValidateJs();
            $this->template->content = $view;

            if (HTTP_Request::POST == $this->request->method()) 
            {           
                $view->contact = $this->salvar();
                //Request::current()->redirect(URL::base().'admin/projects');
            }    
	}
        
        public function action_delete($inId)
        {
            $view = View::factory('admin/teams/list')
            ->bind('errors', $errors)
            ->bind('message', $message);
            try 
            {            
                $contact = ORM::factory('team', $inId);
                $contact->delete();
                $message = "Contato excluído com sucesso.";
            } catch (ORM_Validation_Exception $e) {
                $message = 'Houveram alguns erros na validação dos dados.';
                $errors = $e->errors('models');
            }
            $view->teamsList = ORM::factory('team')->order_by('id','ASC')->find_all();
            $this->template->content = $view;
            Utils_Helper::mensagens('add',$message); 
        }

        public function action_edit($id)
        {
            
            $view = View::factory('admin/teams/create')
                ->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());

            $contact = ORM::factory('team', $id);
            $view->team = $contact;
            $view->isUpdate = true;
            
            $this->addValidateJs();
            $this->template->content = $view;

            if (HTTP_Request::POST == $this->request->method()) 
            {                                              
                $view->contact = $this->salvar($id); 
                //Request::current()->redirect(URL::base().'admin/projects');
            }             
        }

        protected function salvar($id = null)
        {
            $this->template->content
                ->bind('errors', $errors)
                ->bind('message', $message);
            try 
            {            
                $team = ORM::factory('team', $id)->values($this->request->post(), array(
                    'name'
                )); 
                $team->save();
                
                $message = "Equipe '{$team->name}' salva com sucesso.";
                Utils_Helper::mensagens('add',$message);
                //return $projeto;
                Request::current()->redirect(URL::base().'admin/teams');

            } catch (ORM_Validation_Exception $e) {
                $message = 'Houveram alguns erros.';
                $errors = $e->errors('models');
                Utils_Helper::mensagens('add',$message);
            }
        }
}