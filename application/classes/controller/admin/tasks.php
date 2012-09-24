<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tasks extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array('post' => array('login','admin','coordenador', 'assistente'),
								   'edit' => array('login','admin'),
								   'delete' => array('login','admin'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
	
	public function action_index()
	{	
		$view = View::factory('admin/tasks/list');
		$view->taskList = ORM::factory('task')->find_all();
	  	$this->template->content = $view;
	} 

	public function action_create(){
		$view = View::factory('admin/tasks/create')
			->bind('errors', $errors)
            ->bind('message', $message)
            ->set('values', $this->request->post());
		
		$view->usersList = ORM::factory('user')->find_all();
		$view->projectList = ORM::factory('project')->find_all();
		$view->priorityList = ORM::factory('priority')->find_all();
	  	

	  	if (HTTP_Request::POST == $this->request->method()) 
        {
        	try {         
        		$this->salvar();
                $message = "You have added user '{$user->username}' to the database";                 
            } catch (ORM_Validation_Exception $e) {
                $message = 'There were errors, please see form below.';
                $errors = $e->errors('models');
            }
        }
        $this->template->content = $view;	
	}


	public function action_delete($inId){
		$this->template->content = View::factory('admin/projects/delete')
                ->bind('errors', $errors)
                ->bind('message', $message);
            
        try {            
            $projeto = ORM::factory('task', $inId);
            $projeto->delete();
            $message = "Projeto excluído com sucesso.";
        } catch (ORM_Validation_Exception $e) {
            $message = 'Houveram alguns erros. Veja à seguir:';
            $errors = $e->errors('models');
        }
	}
        
    public function action_edit($id){
        $view = View::factory('admin/task/create')
            ->bind('errors', $errors)
            ->bind('message', $message)
            ->set('values', $this->request->post());
      	
      	$view->projeto = ORM::factory('task', $id);
      	$view->isUpdate = true;
        $view->filesList = Controller_Admin_Files::listar($projeto->id);
                
        $this->template->content = $view;

        if (HTTP_Request::POST == $this->request->method()) 
        {                                              
            $view->projeto = $this->salvar($id); 
            Request::current()->redirect(URL::base().'admin/projects');
        }
	}


	protected function salvar($id = null){
		$this->template->content
			->bind('errors', $errors)
            ->bind('message', $message);

        try {            
            $task = ORM::factory('task')->values($this->request->post(), array('project_id','title','priority_id','description', 'crono_date', 'user_id'))->save();
                
            
            $file = $_FILES['arquivo'];
            if(Upload::valid($file)){
                if(Upload::not_empty($file))
                {                
                    $message = Controller_Admin_Files::subir($_FILES['arquivo'],$projeto->id);
                }else
                {
                    $message = "Projeto '{$task->title}' salvo com sucesso.";
                }
            }else
            {                    
                $message = "Projeto '{$task->title}' salvo com sucesso.";
            }
            
            return $projeto;

        } catch (ORM_Validation_Exception $e) {
            $message = 'Houveram alguns erros. Veja à seguir:';
            $errors = $e->errors('models');
        }
    }
}