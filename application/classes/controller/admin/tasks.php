<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tasks extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
        public $secure_actions     	= array(
                                                'edit' => array('login'),
                                                'delete' => array('login','admin'),
                                              );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);                
	}
	
	public function action_index()
	{	
		$view = View::factory('admin/tasks/list');
		$view->taskList = ORM::factory('task')
                        ->join('tasks_users', 'INNER')->on('tasks.id', '=', 'tasks_users.task_id')
                        ->where('tasks_users.user_id', '=', Auth::instance()->get_user()->id)
                        ->or_where('tasks.user_id', '=', Auth::instance()->get_user()->id)
                        ->group_by('tasks_users.task_id')
                        ->order_by('crono_date','ASC')->order_by('priority_id','ASC')
                        ->find_all();
                if(in_array('coordenador', $this->user->roles->find_all()->as_array('id','name'))){
                    $view->showFiltro = true;
                }else{
                    $view->showFiltro = false;
                }
                $view->usersList = ORM::factory('user')->find_all();
                $view->statusList = ORM::factory('statu')->find_all();   
	  	$this->template->content = $view;
	} 
        
        public function action_filter()
	{	
		$view = View::factory('admin/tasks/list');
                $view->task_to = $this->request->query('task_to');
                $view->status = $this->request->query('status');
                if(in_array('coordenador', $this->user->roles->find_all()->as_array('id','name'))){
                    $view->showFiltro = true;
                }else{
                    $view->showFiltro = false;
                }
                if($view->task_to!='' && $view->status!='')
                {  
                    $view->taskList = ORM::factory('task')
                        ->join('tasks_users','INNER')
                        ->on('tasks.id','=','tasks_users.task_id')
                        ->where('tasks_users.user_id', '=', $view->task_to)
                        ->and_where(DB::Expr('(SELECT status_id FROM moderna_status_tasks WHERE task_id = `moderna_tasks`.`id` ORDER BY id DESC LIMIT 1)'),'=',(int)$view->status)
                        ->group_by('tasks_users.task_id')
                        ->order_by('crono_date','ASC')
                        ->order_by('priority_id','ASC')
                        ->find_all();
                }elseif($view->task_to!='')
                {  
                    $view->taskList = ORM::factory('task')
                        ->join('tasks_users','INNER')
                        ->on('tasks.id','=','tasks_users.task_id')
                        ->where('tasks_users.user_id', '=', $view->task_to)
                        ->group_by('tasks_users.task_id')
                        ->order_by('crono_date','ASC')
                        ->order_by('priority_id','ASC')
                        ->find_all();
                }
                elseif($view->status!='')
                {  
                    $view->taskList = ORM::factory('task')
                        ->join('tasks_users','INNER')
                        ->on('tasks.id','=','tasks_users.task_id')
                        ->where_open()
                        ->where('tasks_users.user_id','=',Auth::instance()->get_user()->id)
                        ->or_where('tasks.user_id','=',Auth::instance()->get_user()->id)
                        ->where_close()
                        ->where(DB::Expr('(SELECT status_id FROM moderna_status_tasks WHERE task_id = `moderna_tasks`.`id` ORDER BY id DESC LIMIT 1)'),'=',(int)$view->status)
                        ->group_by('tasks_users.task_id')
                        ->order_by('crono_date','ASC')
                        ->order_by('priority_id','ASC')
                        ->find_all();
                }
                else
                {
                    $view->taskList = ORM::factory('task')
                        ->join('tasks_users','INNER')
                        ->on('tasks.id','=','tasks_users.task_id')
                        ->where_open()
                        ->where('tasks_users.user_id','=',Auth::instance()->get_user()->id)
                        ->or_where('tasks.user_id','=',Auth::instance()->get_user()->id)
                        ->where_close()
                        ->group_by('tasks_users.task_id')
                        ->order_by('crono_date','ASC')
                        ->order_by('priority_id','ASC')
                        ->find_all();
                }
                //Utils_Helper::debug($view->taskList);
                $view->usersList = ORM::factory('user')->find_all();  
                $view->statusList = ORM::factory('statu')->find_all();    
	  	$this->template->content = $view;
	}
        
        protected function addPlupload(){
            $scripts =   array(
                //"http://bp.yahooapis.com/2.4.21/browserplus-min.js",
                "public/plupload/js/plupload.js",
                /*"public/plupload/js/plupload.gears.js",
                "public/plupload/js/plupload.silverlight.js",
                "public/plupload/js/plupload.flash.js",
                "public/plupload/js/plupload.browserplus.js",
                "public/plupload/js/plupload.html4.js",*/
                "public/plupload/js/plupload.html5.js",
                "public/plupload/init.js",
            );
            $this->template->scripts = array_merge( $scripts, $this->template->scripts );
        }
        
        protected function addValidateJs(){
            $scripts =   array(
                "public/js/admin/validateTasks.js",
            );
            $this->template->scripts = array_merge( $scripts, $this->template->scripts );
        }
        
        

	public function action_create(){
		$view = View::factory('admin/tasks/create')
                    ->bind('errors', $errors)
                    ->bind('message', $message)
                    ->set('values', $this->request->post());
                
                $this->addValidateJs();
                		
		//$view->usersList = ORM::factory('user')->find_all(); fluxo para pegar os usuário. Agora é feito com ajax
                $view->teamsList = ORM::factory('team')->find_all();
		$view->projectList = ORM::factory('project')->find_all();
		$view->priorityList = ORM::factory('priority')->find_all();
		$view->statusList = ORM::factory('statu')->find_all();
	  	$this->template->content = $view;	
                
	  	if (HTTP_Request::POST == $this->request->method()) 
                {                                             
                    $this->salvar($id);
                }
                
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

            $this->addPlupload();
            $this->addValidateJs();

            $view->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());

            $task = ORM::factory('task', $id);
            $view->task = $task;
            $view->isUpdate = true;

            //$view->usersList = ORM::factory('user')->find_all(); fluxo para pegar os usuário. Agora é feito com ajax
            $view->teamsList = ORM::factory('team')->find_all();
            $view->projectList = ORM::factory('project')->find_all();
            $view->priorityList = ORM::factory('priority')->find_all();
            $view->statusList = ORM::factory('statu')->find_all();
            $status_task = ORM::factory('status_task')->where('task_id', '=', $id)->order_by('date', 'DESC')->find_all();
            $view->taskflows = $status_task;

            $this->template->content = $view;

            if (HTTP_Request::POST == $this->request->method()) 
            {                                              
                $this->salvar($id);
            }
	}

	protected function salvar($id = null){
        try {  
            $task = ORM::factory('task', $id);
            $task->project_id = $this->request->post('project_id');
            $task->title = $this->request->post('title');
            $task->priority_id = $this->request->post('priority_id');
            $task->crono_date = $this->request->post('crono_date');
            $task->pasta = $this->request->post('pasta');
            
            $pastaProjeto = ORM::factory('project',$task->project_id)->pasta;
            
            /* fluxo para criação de pastas no servidor */
            $rootdir = DOCROOT.'public/upload/'.$pastaProjeto.'/'.$task->pasta;
            if(!file_exists($rootdir))
            {
                mkdir($rootdir,0777);
            } 
            /* fluxo para criação de pastas no servidor */
            if(!$id)	
  	          $task->user_id = Auth::instance()->get_user()->id;
            
            $task->save();
            
            if($this->request->post('task_to')){
            	$task->remove('users');     	
            	$task->add('users', ORM::factory('user', $this->request->post('task_to')));
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

            /* FLUXO DE UPLOAD 1 ARQUIVO SÓ COM INPUT FILE
            $file = $_FILES['arquivo'];
            if(Upload::valid($file)){
                if(Upload::not_empty($file)){
                	Utils_Helper::mensagens('add',Controller_Admin_Files::subir($_FILES['arquivo'],$pastaProjeto.'/'.$task->pasta,$status_tasks->id));
                }else
                {
                	Utils_Helper::mensagens('add',"tarefa salva com sucesso.");
                }
            }else
            {                    
                Utils_Helper::mensagens('add',"tarefa salva com sucesso.");
            }
             */
            
            $filesUploads = $this->request->post('filesUploads');
            $mimeUploads = $this->request->post('mimeUploads');
            if($filesUploads!='')
            {
                $arrFiles = explode(',',$filesUploads);
                $arrMimes = explode(',',$mimeUploads);
                $basedir = 'public/plupload/temporario/';
                $newbasedir = 'public/upload/'.$pastaProjeto.'/'.$task->pasta.'/';
                foreach($arrFiles as $k=>$file){
                    if($file!='empty'){
                        $size = filesize($basedir.$file);

                        Controller_Admin_Files::salvar($newbasedir.$file,$arrMimes[$k],$size,$status_tasks->id);

                        rename($basedir.$file, $newbasedir.$file);
                    }
                }
            }
            
            if($this->request->post('statu_id') != $this->request->post('old_status')){
                $linkTask = (URL::base().'admin/tasks/edit/'.$task->id);
                if($this->request->post('statu_id')==7) // 7 = Concluído
                {
                    $email = new Email_Helper();
                    $email->userInfo = ORM::factory('userInfo',array('user_id'=>$task->user_id));
                    if($email->userInfo->email!=''){
                        $email->assunto = 'Tarefa '.$task->title.' foi '.ORM::factory('statu',$this->request->post('statu_id'))->status;
                        $email->mensagem = '<font face="arial">Tarefa <b><em>'.$task->title.'</em></b><br/><br/>
                        <b>'.ORM::factory('statu',$this->request->post('statu_id'))->status.'</b> em '.date('d/m/Y - H:i:s').'<br/>
                        <b>Por:</b> '.ORM::factory('userInfo',array('user_id'=>$status_tasks->user_id))->nome.'<br/>
                        <b>Link:</b> <a href="'.$linkTask.'" title="Ir para a tarefa">'.$linkTask.'</a></font>';
                        $email->enviaEmail();
                    }
                }elseif($this->request->post('statu_id')==5)// 5 = Aguardando
                {
                    $email = new Email_Helper();
                    $email->userInfo = ORM::factory('userInfo',array('user_id'=>$this->request->post('task_to')));
                    if($email->userInfo->email!=''){
                        $email->assunto = 'Olá, '.$email->userInfo->nome.' você possuí uma tarefa!';
                        $email->mensagem = '<font face="arial">Olá, <b>'.$email->userInfo->nome.'</b> você possuí uma tarefa!.<br/><br/>
                        <b>Projeto:</b> '.ORM::factory('project',$task->project_id)->name.'<br/>
                        <b>Título:</b> '.$task->title.'<br/>
                        <b>Data de entrega:</b> '.  Utils_Helper::data($task->crono_date).'<br/>
                        <b>Prioridade:</b> '.ORM::factory('priority',$task->priority_id)->priority.'<br/>
                        <b>Descrição:</b> '.$this->request->post('description').'<br/>
                        <b>Link:</b> <a href="'.$linkTask.'" title="Ir para a tarefa">'.$linkTask.'</a></font>';
                        $email->enviaEmail();
                    }
                }
            }
            $message = "Tarefa salva com sucesso."; 
            Utils_Helper::mensagens('add',$message);
            Request::current()->redirect(URL::base().'admin/tasks/edit/'.$id);

        } catch (ORM_Validation_Exception $e) {
            $message = 'Houveram alguns erros.';
            Utils_Helper::mensagens('add',$message);
            $errors = $e->errors('models');
            
        } catch (Database_Exception $e) {
            $message = 'Houveram alguns erros:<br/>'.$e->getMessage();
            Utils_Helper::mensagens('add',$message);
        }
    }
    
    public function action_searchnew()
    {	
        $callback = $this->request->query('callback');
        $rls = $this->user->roles->find_all()->as_array('id','name');       
        $dados = array();
        $taskList = ORM::factory('task')
                ->join('tasks_users', 'INNER')->on('tasks.id', '=', 'tasks_users.task_id')
                ->where('tasks_users.user_id', '=', Auth::instance()->get_user()->id)
                ->or_where('tasks.user_id', '=', Auth::instance()->get_user()->id)
                ->group_by('tasks_users.task_id')
                ->order_by('crono_date','ASC')->order_by('priority_id','ASC')
                ->find_all();
        foreach($taskList as $task){
            $status = $task->status->order_by('status_tasks.id', 'DESC')->limit('1')->find_all();
            if($status[0]->id == 5 && in_array('assistente', $rls)){
                $dado = array('id'=>$task->id,'title'=>$task->title,'status'=>$status[0]->id);
                array_push($dados,$dado);
            }
            if($status[0]->id == 7 && in_array('coordenador', $rls)){
                $dado = array('id'=>$task->id,'title'=>$task->title,'status'=>$status[0]->id);
                array_push($dados,$dado);
            }
        }
        $arr = array('role_user'=>$roles[0]->role_id,'dados'=>$dados);
        print $callback.json_encode($arr);
        exit;
    } 
}