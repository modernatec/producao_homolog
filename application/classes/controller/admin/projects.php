<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Projects extends Controller_Admin_Template {
 
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
            $view = View::factory('admin/projects/list')
                ->bind('message', $message);
            $view->projectsList = ORM::factory('project')->order_by('id','DESC')->find_all();
            $this->template->content = $view;             
	} 

	public function action_create()
        { 
            $view = View::factory('admin/projects/create')
                ->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());

            $this->template->content = $view;

            if (HTTP_Request::POST == $this->request->method()) 
            {           
                $view->projeto = $this->salvar();
                //Request::current()->redirect(URL::base().'admin/projects');
            }    
	}
        
        public function action_delete($inId)
        {
            $view = View::factory('admin/projects/list')
            ->bind('errors', $errors)
            ->bind('message', $message);
            try 
            {            
                $projeto = ORM::factory('project', $inId);
                $projeto->delete();
                $message = "Projeto excluído com sucesso.";
            } catch (ORM_Validation_Exception $e) {
                $message = 'Houveram alguns erros na validação dos dados.';
                $errors = $e->errors('models');
            }
            $view->projectsList = ORM::factory('project')->order_by('id','DESC')->find_all();
            $this->template->content = $view;
            Utils_Helper::mensagens('add',$message); 
        }

        public function action_edit($id)
        {
            $view = View::factory('admin/projects/create')
                ->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());

            $projeto = ORM::factory('project', $id);
            $view->projeto = $projeto;
            $view->isUpdate = true;
            $view->filesList = Controller_Admin_Files::listar($projeto->id);

            $this->template->content = $view;

            if (HTTP_Request::POST == $this->request->method()) 
            {                                              
                $view->projeto = $this->salvar($id); 
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
                $projeto = ORM::factory('project', $id)->values($this->request->post(), array(
                    'name',
                    'target',
                    'description'            
                ));                
                if(!$id)
                {
                    $pastaProjeto = Utils_Helper::limparStr($projeto->name);
                    $basedir = 'public/upload/';
                    $rootdir = DOCROOT.$basedir;
                    
                    if(!file_exists($rootdir.$pastaProjeto))
                    {
                        mkdir($rootdir.$pastaProjeto,0777);
                    }
                    $projeto->pasta = $pastaProjeto;                    
                }
                $projeto->save();
                
                /*$file = $_FILES['arquivo'];
                if(Upload::valid($file))
                {
                    if(Upload::not_empty($file))
                    {                
                        $message = Controller_Admin_Files::subir($_FILES['arquivo'],$projeto);
                    }else
                    {
                        $message = "Projeto '{$projeto->name}' salvo com sucesso.";
                    }
                }else
                {                    
                    $message = "Projeto '{$projeto->name}' salvo com sucesso.";
                }*/
                $message = "Projeto '{$projeto->name}' salvo com sucesso.";
                Utils_Helper::mensagens('add',$message);
                //return $projeto;
                Request::current()->redirect(URL::base().'admin/projects');

            } catch (ORM_Validation_Exception $e) {
                $message = 'Houveram alguns erros.';
                $errors = $e->errors('models');
                Utils_Helper::mensagens('add',$message);
            }
        }
}