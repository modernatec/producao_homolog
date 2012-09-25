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
		$view->taskList = ORM::factory('task')->join('tasks_users', 'INNER')->on('tasks.id', '=', 'tasks_users.task_id')->where('tasks_users.user_id', '=', Auth::instance()->get_user()->id)->or_where('tasks.user_id', '=', Auth::instance()->get_user()->id)->group_by('tasks_users.task_id')->find_all();
		
		//
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
		$view->statusList = ORM::factory('statu')->find_all();
	  	
	  	if (HTTP_Request::POST == $this->request->method()) 
        {
        	try {         
                $projeto = $this->salvar();
                $message = "You have added a task"; 
                Request::current()->redirect(URL::base().'admin/tasks/edit/'.$projeto->id);
                $view->filesList = Controller_Admin_Files::listar($projeto->id);
              
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
    	if(in_array('coordenador', $this->user->roles->find_all()->as_array('id','name'))){
	        $view = View::factory('admin/tasks/create');
    	}else{
	        $view = View::factory('admin/tasks/edit');
    	}

        $view->bind('errors', $errors)
            ->bind('message', $message)
            ->set('values', $this->request->post());
      	
      	$task = ORM::factory('task', $id);
      	$view->task = $task;
      	$view->isUpdate = true;

      	$view->usersList = ORM::factory('user')->find_all();
		$view->projectList = ORM::factory('project')->find_all();
		$view->priorityList = ORM::factory('priority')->find_all();
		$view->statusList = ORM::factory('statu')->find_all();
		$status_task = ORM::factory('status_task')->where('task_id', '=', $id)->order_by('date', 'DESC')->find_all();
		$view->taskflows = $status_task;

        $this->template->content = $view;
        	
        if (HTTP_Request::POST == $this->request->method()) 
        {                                              
            if($this->salvar($id)){ 
	            Request::current()->redirect(URL::base().'admin/tasks/edit/'.$id);            
	        } 
        }
	}

	protected function salvar($id = null){
        try {  
            $task = ORM::factory('task', $id);
            $task->project_id = $this->request->post('project_id');
            $task->title = $this->request->post('title');
            $task->priority_id = $this->request->post('priority_id');
            $task->crono_date = $this->request->post('crono_date');
            
            if(!$id)	
  	          $task->user_id = Auth::instance()->get_user()->id;
            
            $task->save();
            
            if($this->request->post('task_to')){
            	$task->remove('users');     	
            	$task->add('users', ORM::factory('user', $this->request->post('task_to')));
            }
            
            if($this->request->post('statu_id')==7) // 7 = Concluído
            {
                $email = new Email_Helper();
                $email->userInfo = ORM::factory('userInfo',array('user_id'=>$task->user_id));
                $email->assunto = 'Tarefa '.$task->title.' foi '.ORM::factory('statu',$this->request->post('statu_id'))->status;
                $email->mensagem = 'Tarefa '.$task->title.' foi '.ORM::factory('statu',$this->request->post('statu_id'))->status.' em '.date('d/m/Y - H:i:s');
                $email->enviaEmail();
            }elseif($this->request->post('statu_id')==5)// 5 = Aguardando
            {
                $email = new Email_Helper();
                $email->userInfo = ORM::factory('userInfo',array('user_id'=>$this->request->post('task_to')));
                $email->assunto = 'Olá, '.$email->userInfo->nome.' você possuí uma tarefa!';
                $email->mensagem = 'Olá, '.$email->userInfo->nome.' você possuí uma tarefa!.
Projeto: '.ORM::factory('project',$task->project_id)->name.'
Título: '.$task->title.'
Data de entrega: '.  Utils_Helper::data($task->crono_date).'
Prioridade: '.ORM::factory('priority',$task->priority_id)->priority.'
Descrição: '.$this->request->post('description');
                $email->enviaEmail();
            }

            if($this->request->post('statu_id') != $this->request->post('old_status')){
                $status_tasks = ORM::factory('status_task');
            }else{
            	$status_tasks = ORM::factory('status_task', $this->request->post('status_task_id'));
            }

            $status_tasks->status_id = $this->request->post('statu_id');
            $status_tasks->task_id = $task->id;
            $status_tasks->user_id = Auth::instance()->get_user()->id;
            $status_tasks->date = date('Y-m-d H:i:s');
            $status_tasks->description = $this->request->post('description');
            $status_tasks->save();

            $file = $_FILES['arquivo'];
            if(Upload::valid($file)){
                if(Upload::not_empty($file))
                {       
                	Utils_Helper::mensagens('add',Controller_Admin_Files::subir($_FILES['arquivo'],$task,$status_tasks));
                }else
                {
                	Utils_Helper::mensagens('add',"tarefa salva com sucesso.");
                }
            }else
            {                    
                Utils_Helper::mensagens('add',"tarefa salva com sucesso.");
            }

            return $task;

        } catch (ORM_Validation_Exception $e) {
            $message = 'Houveram alguns erros.';
            $errors = $e->errors('models');
            var_dump($errors);
        }
    }
}