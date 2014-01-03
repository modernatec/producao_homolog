<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tasks extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); 
	public $secure_actions     	= array(
										'create' => array('login','coordenador'),
										'delete' => array('login','admin'),);
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);                
	}
	
	public function action_index()
	{	
		if(Auth::instance()->logged_in()== 0){	
			Request::current()->redirect('login');
		}
		
		$view = View::factory('admin/tasks/list');
		
		/* Tasks para o user ou geradas por ele */      
		$query = ORM::factory('task')->join('tasks_users', 'INNER')->on('tasks.id', '=', 'tasks_users.task_id')
                        ->where('tasks_users.userInfo_id', '=', $this->current_user->userInfos->id)
                        ->group_by('tasks_users.task_id')
                        ->order_by('crono_date','ASC');
						
		$view->taskList	= $query->find_all();
		
		$arr_users = array();		
		/* Tasks encaminhadas para users da equipe coordenada */
		if($this->current_auth == 'coordenador'){
			$team = ORM::factory('team')->where('userInfo_id', '=', $this->current_user->userInfos->id)->find();
			$team_users = ORM::factory('userInfo')->where('team_id', '=', $team->id)->find_all();
			foreach($team_users as $team_user){
				array_push($arr_users, $team_user->id);	
			}
			
			if(count($arr_users) > 0){			
				$query_team = ORM::factory('task')->join('tasks_users', 'INNER')->on('tasks.id', '=', 'tasks_users.task_id')
							->where('tasks_users.userInfo_id', 'IN', $arr_users)
							->group_by('tasks_users.task_id')
							->order_by('crono_date','ASC');
							
				$view->taskTeam = $query_team->find_all();			
			}
		}	
		/* Todas as tasks abertas no sistema */
		if($this->current_auth == 'admin'){
			$otherUsers = ORM::factory('userInfo')->where('id', '!=', $this->current_user->userInfos->id)->find_all();
			foreach($otherUsers as $userInfo){
				array_push($arr_users, $userInfo->id);	
			}	
			//echo '<pre>';
			//var_dump($arr_users);
			$query_team = ORM::factory('task')->join('tasks_users', 'INNER')->on('tasks.id', '=', 'tasks_users.task_id')
							->where('tasks_users.userInfo_id', 'IN', $arr_users)
							->group_by('tasks_users.task_id')
							->order_by('crono_date','ASC');	
			$view->taskTeam = $query_team->find_all();	
		}
				
	  	$this->template->content = $view;		
	} 
        
	public function action_create(){
		$view = View::factory('admin/tasks/create')
                    ->bind('errors', $errors)
                    ->bind('message', $message);
                
        $this->addValidateJs();
		$view->isUpdate = false;                		
        $view->teamsList = ORM::factory('team')->find_all();
		$view->projectList = ORM::factory('project')->find_all();
		//$view->statusList = ORM::factory('statu')->find_all();
		$view->materiasList = ORM::factory('materia')->find_all();
		$view->collectionList = ORM::factory('collection')->find_all();
		$view->typeObjList = ORM::factory('typeobject')->find_all();
		$view->supplierList = ORM::factory('supplier')->find_all();
		$view->segmentoList = ORM::factory('segmento')->find_all();
		

		//$view->anexosView = View::factory('admin/files/anexos');
	  	$this->template->content = $view;	
                
	  	if (HTTP_Request::POST == $this->request->method()) 
		{                                             
			$this->salvar();
		}
                
	}
	
	public function action_edit($id){
		$view = View::factory('admin/tasks/create');

		$view->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();
		$view->isUpdate = true;
		
		$task = ORM::factory('task', $id);
		$view->taskVO = $this->setVO('task', $task);
		
		$userId = $task->userInfos->find_all();
		foreach($userId as $userInfo){
			$view->taskVO['userInfo_id'] = $userInfo->id;
			$view->taskVO['team_id'] = $userInfo->team_id;
		}
		
		//$view->taskVO['equipeUsers'] = ORM::factory('userInfo')->where('team_id', '=', $view->taskVO['team_id'])->find_all();
		//$view->taskflows = ORM::factory('status_task')->where('task_id', '=', $id)->order_by('date', 'DESC')->find_all();
		
		//$view->anexosView = View::factory('admin/files/anexos');
		$view->teamsList = ORM::factory('team')->find_all();
		$view->projectList = ORM::factory('project')->find_all();
		//$view->statusList = ORM::factory('statu')->find_all();
		$view->materiasList = ORM::factory('materia')->find_all();
		$view->collectionList = ORM::factory('collection')->find_all();
		$view->typeObjList = ORM::factory('typeobject')->find_all();
		$view->supplierList = ORM::factory('supplier')->find_all();
		$view->segmentoList = ORM::factory('segmento')->find_all();
		
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar($id);
		}
	}

	public function action_assign($id){
		$view = View::factory('admin/tasks/assign');

		$view->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();
		$view->isUpdate = true;
		
		$task = ORM::factory('task', $id);
		$view->taskVO = $this->setVO('task', $task);
		
		$userId = $task->userInfos->find_all();
		foreach($userId as $userInfo){
			$view->taskVO['userInfo_id'] = $userInfo->id;
			$view->taskVO['team_id'] = $userInfo->team_id;
		}
		
		$view->taskVO['equipeUsers'] = ORM::factory('userInfo')->where('team_id', '=', $view->taskVO['team_id'])->find_all();
		$view->taskflows = ORM::factory('status_task')->where('task_id', '=', $id)->order_by('date', 'DESC')->find_all();
		
		$view->anexosView = View::factory('admin/files/anexos');
		$view->teamsList = ORM::factory('team')->find_all();
		$view->projectList = ORM::factory('project')->find_all();
		$view->statusList = ORM::factory('statu')->find_all();
		$view->materiasList = ORM::factory('materia')->find_all();
		$view->collectionList = ORM::factory('collection')->find_all();
		$view->typeObjList = ORM::factory('typeobject')->find_all();
		$view->supplierList = ORM::factory('supplier')->find_all();
		$view->segmentoList = ORM::factory('segmento')->find_all();
		$view->projectStepsList = ORM::factory('projects_step')->where('project_id','=', $task->project_id)->find_all();
		
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar($id);
		}
	}

	protected function salvar($id = null)
	{
        $db = Database::instance();
        $db->begin();
		
		try {  
			$task = ORM::factory('task', $id);			
			
			$task->values($this->request->post(), array(
				'project_id',
				'title',
				'crono_date',
				'taxonomia',
				'obs',
				'collection_id',
				'supplier_id',
				'typeobject_id',
				'source',
				'vol_ano',
				'uni',
				'cap',	
			)); 
            
			
			/* fluxo para criação de pastas no servidor *
            $pastaProjeto = ORM::factory('project',$task->project_id)->pasta;
            $rootdir = DOCROOT.'public/upload/'.$pastaProjeto.'/'.$task->pasta;
            if(!file_exists($rootdir))
            {
                mkdir($rootdir,0777);
            } 
            */
            if(!$id)	
  	          $task->userInfo_id = $this->current_user->userInfos->id;
            
            $task->save();
            /*------
            if($this->request->post('task_to')){
				$task->remove('userInfos');
				$taskUser = ORM::factory('userInfo', $this->request->post('task_to'));     	
            	$task->add('userInfos', $taskUser);
				
				$envio = $taskUser->nome;
				if($taskUser->mailer == '1'){
					$linkTask = URL::base().'admin/tasks/edit/'.$task->id;
					if($this->request->post('statu_id') == 5)// 5 = Solicitada
					{
						$email = new Email_Helper();
						$email->userInfo = $taskUser;
						if($taskUser->email != ''){
							$email->assunto = 'Olá, '.$taskUser->nome.' você possuí uma tarefa!';
							$email->mensagem = '<font face="arial">Olá, '.$task->userInfo->nome.' lhe enviou uma tarefa.<br/><br/>
							<b>Projeto:</b> '.$task->project->name.'<br/>
							<b>Título:</b> '.$task->title.'<br/>
							<b>Data de entrega:</b> '.Utils_Helper::data($task->crono_date).'<br/>
							<b>Descrição:</b> '.$this->request->post('description').'<br/>
							<b>Link:</b> <a href="'.$linkTask.'" title="Ir para a tarefa">'.$linkTask.'</a></font>';
							$envio.= $email->enviaEmail();
						}
                	}
            	}
				
            }

            if($this->request->post('statu_id')){
				if($this->request->post('statu_id') == 7) // 7 = Concluído
				{
					$email = new Email_Helper();
					$email->userInfo = $task->userInfo;
					
					if($task->userInfo->email!=''){
						$email->assunto = 'Tarefa '.$task->title.' foi '.ORM::factory('statu',$this->request->post('statu_id'))->status;
						$email->mensagem = '<font face="arial">Tarefa <b><em>'.$task->title.'</em></b><br/><br/>
						<b>'.ORM::factory('statu',$this->request->post('statu_id'))->status.'</b> em '.date('d/m/Y - H:i:s').'<br/>
						<b>Por:</b> '.ORM::factory('userInfo',array('user_id'=>$status_tasks->user_id))->nome.'<br/>
						<b>Link:</b> <a href="'.$linkTask.'" title="Ir para a tarefa">'.$linkTask.'</a></font>';
						$email->enviaEmail();
					}
				}
				
            	$status_tasks = ORM::factory('status_task');
				$status_tasks->status_id = $this->request->post('statu_id');
				$status_tasks->task_id = $task->id;
				$status_tasks->userInfo_id = $this->current_user->userInfos->id;
				$status_tasks->description = $this->request->post('description');
				$status_tasks->save();
	
	            Controller_Admin_Files::salvar($this->request, "public/upload/curriculum", $status_tasks->id, "task", $this->current_user);	
            }	

            if(isset($envio)){
				$message.= "<br/>Email enviado ".$envio; 	
			}
            */	
			            
			$db->commit();
			
            $message = "Tarefa salva com sucesso."; 
			
			Utils_Helper::mensagens('add',$message);
            Request::current()->redirect('admin/tasks/edit/'.$task->id);

        } catch (ORM_Validation_Exception $e) {
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
	
	public function action_delete($inId){            
		try {            
			$projeto = ORM::factory('task', $inId);
			$projeto->delete();
			$message = "Projeto excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$message = 'Houveram alguns erros. Veja à seguir:';
			$errors = $e->errors('models');
		}
		
		Utils_Helper::mensagens('add',$message); 
		Request::current()->redirect('admin/tasks');
	}
	
	
	
	public function action_filter()
	{	
		$view = View::factory('admin/tasks/list');
		$view->task_to = $this->request->query('task_to');
		$view->status = $this->request->query('status');
		
		if(in_array('coordenador', $this->current_user->roles->find_all()->as_array('id','name'))){
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
    
	
	/*--------------*/
    public function action_searchnew()
    {	
        /*
		$callback = $this->request->query('callback');
        $rls = $this->current_user->roles->find_all()->as_array('id','name');       
        $dados = array();
        $taskList = ORM::factory('task')
                ->join('tasks_users', 'INNER')->on('tasks.id', '=', 'tasks_users.task_id')
                ->where('tasks_users.userInfo_id', '=', Auth::instance()->get_user()->id)
                ->or_where('tasks.userInfo_id', '=', Auth::instance()->get_user()->id)
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
        $arr = array('role_user'=>$rls->role_id,'dados'=>$dados);
        print $callback.json_encode($arr);
        exit;
		*/
    } 
}