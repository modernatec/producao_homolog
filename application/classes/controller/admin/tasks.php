<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tasks extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); 
	public $secure_actions     	= array(
										'create' => array('login','coordenador'),
										'delete' => array('login','admin'),);
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response); 
		$this->check_login();	               
	}

	public function action_index()
	{	
		$view = View::factory('admin/tasks/list');
		$view->userInfo_id = $this->current_user->userInfos->id;

        $view->has_task = ORM::factory('taskUser')->join('userInfos', 'INNER')->on('userInfos.id', '=', 'task_to')->where('task_to', '!=', '0')->group_by('task_to')->order_by('nome', 'ASC')->find_all();
        $view->current_auth = $this->current_auth;

        if($this->request->query('userInfo_id')){
        	$tasks_of = ORM::factory('userInfo', $this->request->query('userInfo_id'));	
        	$nome = explode(" ", $tasks_of->nome);
        	$view->title = "tarefas - ".$nome[0];
        	$view->filter = "?to=".$tasks_of->id;
        }else{
        	$view->title = "tarefas - equipe";
        	$view->filter = "?status=".json_encode(array("5"));
        }
		$view->totalTasks = ORM::factory('taskUser')->count_all();
	  	$this->template->content = $view;	
	  	
	  	/*
	  	$rs = ORM::factory('task')->where('id', 'IN', (DB::select('task_id')->from('tasks')->where('status_id', '=', '7')))->find_all();
	  	foreach($rs as $task){
	  		$task->ended = '1';
	  		$task->save();

	  		$rs2 = ORM::factory('task')->where('task_id', '=', $task->id)->find_all();
	  		foreach($rs2 as $task2){
	  			$task2->ended = '1';
	  			$task2->save();
	  		}

	  	}
	  	*/
	  	//SELECT * FROM `moderna_tasks` WHERE `moderna_tasks`.`id` IN(SELECT `mt`.`task_id` FROM `moderna_tasks` `mt` WHERE `mt`.`status_id` = '7')
	  			  	
	} 
    
   	public function action_update($id){
		$this->auto_render = false;
		$view = View::factory('admin/tasks/form_edit');

		$view->bind('errors', $errors)
			->bind('message', $message);
		
		$task = ORM::factory('task', $id);
		$view->taskVO = $this->setVO('task', $task);
		$view->teamList = ORM::factory('userInfo')->where('status', '=', '1')->order_by('nome', 'ASC')->find_all(); 

		echo $view;
	}

	public function action_updateReply($id){
		$this->auto_render = false;
		$view = View::factory('admin/tasks/form_edit_reply');

		$view->bind('errors', $errors)
			->bind('message', $message);
		
		$task = ORM::factory('task', $id);
		$view->taskVO = $this->setVO('task', $task);

		echo $view;
	}

	/*****ENVIAR E-MAIL?********/
	public function action_edit($id){
		if (HTTP_Request::POST == $this->request->method()) 
		{
			$this->salvar($id, null, 'editing');
		}
	}
	
	public function action_start(){
		if (HTTP_Request::POST == $this->request->method()) 
		{
			$task_ini = ORM::factory('task')->where('task_id', '=',$this->request->post('task_id'))->find_all();
			if(count($task_ini) > 0){
				$message = "Tarefa já foi iniciada"; 
			
				Utils_Helper::mensagens('add',$message);
            	Request::current()->redirect('admin/objects/view/'.$this->request->post('object_id'));
			}else{
				//var_dump($this->request->post());
				//exit();
				$this->salvar(null, null, "starting");
			}
		}
	}	

	public function action_end(){
		if (HTTP_Request::POST == $this->request->method()) 
		{
			/*
			$task_end = ORM::factory('task')->where('status_id', '=',$this->request->post('status_id'))->and_where('topic', '=',$this->request->post('topic'))->and_where('topic', '=',$this->request->post('description'))->find_all();
			if(count($task_end) > 0){
				$message = "Tarefa já cadastrada"; 
			
				Utils_Helper::mensagens('add',$message);
            	Request::current()->redirect('admin/objects/view/'.$this->request->post('object_id'));
			}else{
			*/	
			$this->salvar(null, "sendEndMail");
			//}
		}
	}

	public function action_assign(){
		if (HTTP_Request::POST == $this->request->method()) 
		{    
			$this->salvar(null, "sendAssignMail");			
		}
	}

	protected function salvar($id = null, $func = null, $method = null)
	{
        $db = Database::instance();
        $db->begin();
		
		try {  
			
			$task = ORM::factory('task', $id);
			
			$task->values($this->request->post(), array(
				'topic',
				'crono_date',
				'description',
				'status_id',
				'task_id',
				'object_id',
				'task_to',
			)); 

			if(is_null($id)){
				if($this->request->post('userinfo_id') && $method != "starting"){
				   $task->userInfo_id = $this->request->post('userinfo_id');
				   $task->task_to = $this->request->post('task_to');
				}else{
			       $task->userInfo_id = $this->current_user->userInfos->id;
			       if($method == "starting"){
			       		$task->userInfo_id = $this->request->post('userinfo_id');
				       	$task->task_to = $this->current_user->userInfos->id;
				   }
			    }
			}else{
				/*---atualiza status do objeto----*/
		    	$objectStatus = ORM::factory('objects_statu')->where('object_id', '=', $this->request->post('object_id'))->order_by('id', 'DESC')->find();
		        $objectStatus->crono_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->request->post('crono_date'))));
				$objectStatus->save();  
			}

			/**encerra trio de tasks para a task concluida**/
		    if(!is_null($this->request->post('task_id')) && $func == "sendEndMail"){
		    	$task_end = ORM::factory('task', $this->request->post('task_id'));
		    	$task_end->ended = '1';
		    	$task_end->save();

				$task_id_end = ORM::factory('task')->where('task_id', '=', $this->request->post('task_id'))->find();
		    	$task_id_end->ended = '1';
		    	$task_id_end->save();			    	 		

		    	$task->ended = '1';
		    }

            $task->save();

            /**atualiza tarefas relacionadas (ex: ja abertas)**/
            if(!is_null($this->request->post('task_id')) && is_null($method)){
		    	$task_id = ORM::factory('task', $this->request->post('task_id'));
		    	$task_id->topic = $task_id->topic;
		    	$task_id->status_id = $task_id->status_id;  
		    	$task_id->userInfo_id = $task_id->userInfo_id; 
		    	$task_id->object_id = $task_id->object_id;  
		    	$task_id->task_to = $this->current_user->userInfos->id; 
		    	$task_id->save();

				$update_task = ORM::factory('task')->where('task_id', '=', $this->request->post('task_id'))->find();
		    	$update_task->topic = $update_task->topic;
		    	$update_task->status_id = $update_task->status_id;  
		    	$update_task->userInfo_id = $update_task->userInfo_id;
		    	$update_task->object_id = $update_task->object_id;  
		    	$update_task->task_to = $this->current_user->userInfos->id;  
		    	$update_task->save();			    	 	
		    } 

		    if(!is_null($this->request->post('task_id')) && $method == "starting"){
		    	$task_start = ORM::factory('task', $this->request->post('task_id'));
		    	$task_start->task_to = $this->current_user->userInfos->id;
		    	$task_start->ended = '1';
		    	$task_start->save();
		    }
		    

            /**atualiza tarefas de status relacionadas --- TRIGGER??**
            DB::update('tasks')->set(array(
            							'topic' => $this->request->post('topic'), 
            							'crono_date' => $this->request->post('crono_date'),
            							'description' => $this->request->post('description'),
            							))->where('task_id', '=', $id)->execute();
            //DB::update('tasks', array('topic', 'crono_date', 'description'))->values($this->request->post(), array('topic', 'crono_date', 'description'))->where('task_id', '=', $id)->execute();
			*/
			
			
            $task_replies = ORM::factory('task')->where('task_id', '=', $id)->find_all();
            if(count($task_replies) > 0){
	            foreach ($task_replies as $task_r) {
	            	$task_r->values($this->request->post(), array(
					'topic',
					'crono_date',
					'description',
					'task_to',
					));
					$task_r->save(); 
	            }
        	}
        	
            
            $db->commit();

            if($func != null){
	            call_user_func('Controller_Admin_Tasks::'.$func, array('post' => $this->request->post(), 
            																'user' => $this->current_user->userInfos));
            }
			
            $message = "Tarefa salva com sucesso."; 
			
			Utils_Helper::mensagens('add',$message);
            Request::current()->redirect('admin/objects/view/'.$task->object_id);
            
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
		/*
		try {            
			$projeto = ORM::factory('task', $inId);
			$projeto->delete();
			$message = "Tarefa excluída com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$message = 'Houveram alguns erros. Veja à seguir:';
			$errors = $e->errors('models');
		}
		
		Utils_Helper::mensagens('add',$message); 
		*/
		Request::current()->redirect('admin/tasks');
	}

	public static function sendAssignMail($arg){
		if($arg['post']['task_to'] != 0){
			$taskUser = ORM::factory('userInfo', $arg['post']['task_to']); 
			$object = ORM::factory('object', $arg['post']['object_id']);    	
			
			if($taskUser->mailer == '1'){
				$linkTask = URL::base().'admin/objects/view/'.$arg['post']['object_id'];
				
				$email = new Email_Helper();
				$email->userInfo = $taskUser;
				if($taskUser->email != ''){
					$nome = explode(" ", $taskUser->nome);
					$email->assunto = $arg['post']['topic'].' - '.$object->taxonomia;
					$email->mensagem = '<font face="arial">Olá, '.ucfirst($nome[0]).', você possuí uma nova tarefa.<br/><br/>
						<b>Título:</b> '.$arg['post']['topic'].'<br/>
						<b>Data de entrega:</b> '.$arg['post']['crono_date'].'<br/>
						<b>Descrição:</b> <pre>'.$arg['post']['description'].'</pre><br/>
						<b>Link:</b> <a href="'.$linkTask.'" title="Ir para a tarefa">'.$linkTask.'</a></font>';
					
					$email->enviaEmail();						
            	}
        	}            	    	
        }
	}

	public static function sendEndMail($arg){
		$task = ORM::factory('task', $arg['post']['task_id']);
		$object = ORM::factory('object', $arg['post']['object_id']);
		$taskUser = $task->userInfo;     	
		
		if($taskUser->mailer == '1'){
			$linkTask = URL::base().'admin/objects/view/'.$arg['post']['object_id'];
			
			$email = new Email_Helper();
			$email->userInfo = $taskUser;
			if($taskUser->email != ''){
				$nome = explode(" ", $taskUser->nome);
                       
				$email->assunto = $object->taxonomia.' - Tarefa concluída!';
				$email->mensagem = '<font face="arial">Olá, '.ucfirst($nome[0]).', a tarefa abaixo foi concuída.<br/><br/>
					<b>Entregue por:</b> '.$arg['user']->nome.'<br/>
					<b>Observações:</b> <pre>'.$arg['post']['description'].'</pre><br/>
					<b>Link:</b> <a href="'.$linkTask.'" title="Ir para a tarefa">'.$linkTask.'</a></font>';
				
				$email->enviaEmail();					
        	}
    	}     
	}

	

    /********************************/
    public function action_getTasks(){
    	$this->check_login();	
        $this->auto_render = false;
        $view = View::factory('admin/tasks/table');

        //$this->startProfilling();

        //$view->filter_tipo = json_decode($this->request->query('tipo'));
        $view->filter_status = json_decode($this->request->query('status'));  
		$view->filter_userInfo_id = $this->request->query('userInfo_id'); 
		$view->filter_task_to = $this->request->query('to');             

        //$query = ORM::factory('task')->where('status_id', '=', $view->filter_status)        
        $query = ORM::factory('taskUser');

        /***Filtros***/
        //(count($view->filter_tipo) > 0) ? $query->where('typeobject_id', 'IN', $view->filter_tipo) : '';
        //(!empty($view->filter_nome)) ? $query->where('nome', 'LIKE', '%'.$view->filter_nome.'%') : '';
        //(isset($view->filter_userInfo_id)) ? $query->and_where('userInfo_id', '=', $view->filter_userInfo_id)->and_where('task_id', 'NOT IN', DB::Select('task_id')->from('tasks')->where('status_id', '=', '7')) : '';
        (isset($view->filter_status)) ? $query->where('status_id', '=', $view->filter_status) : '';
        (isset($view->filter_userInfo_id)) ? $query->where('task_to', '=', $view->filter_userInfo_id)->or_where('userInfo_id', '=', $view->filter_userInfo_id) : '';
        (isset($view->filter_task_to)) ? $query->where('task_to', '=', $view->filter_task_to) : '';

        $view->taskList = $query->order_by('crono_date','ASC')->find_all();

        
        //$this->endProfilling();
        echo $view;
    }  

    public function action_ongoing(){
    	$this->check_login();	
        $this->auto_render = false;
        $view = View::factory('admin/tasks/table_ongoing');

        $view->objectsList = DB::select('*')->from('ongoings')->order_by('crono_date','ASC')->execute();

        echo $view;
    }   








    /*******************ANALIZAR************************/

	public function action_load()
	{
		$db = Database::instance();
        $db->begin();
		
		try {  

			$file = new Spreadsheet();
			$sheet = $file->read();

			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 1; $row <= $highestRow; $row++){ 

			    //  Read a row of data into an array
			    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

			   	if($rowData[0][0] == "END_SHEET"){
					break;
				}
			    
			    $task = ORM::factory('task');	
				$task->project_id = '4';
				$task->title = (empty($rowData[0][0])) ? "definir" : $rowData[0][0];
				$task->priority_id = '2';
				$task->crono_date = "01/02/2014";				
				$task->taxonomia = (empty($rowData[0][2])) ? "definir" : $rowData[0][2];
				$task->obs = (empty($rowData[0][7])) ? "-" : $rowData[0][7];
				//$task->vol_ano = $rowData[0][3];
				//$task->uni = $rowData[0][4];
				$task->cap = "-";
				$task->source = (empty($rowData[0][6])) ? "definir" : $rowData[0][6];
		        $task->userInfo_id = $this->current_user->userInfos->id;
	            $task->save();

	            $task_user = ORM::factory('tasks_user');
	            $task_user->task_id = $task->id;
				$task_user->userInfo_id = $task->userInfo_id;
				$task_user->save();

				$status_task = ORM::factory('status_task');
	            $status_task->status_id = 8;
				$status_task->task_id = $task->id;
				$status_task->date = date("Y-m-d H:i:s");
				$status_task->userInfo_id = $task->userInfo_id;
				$status_task->save();
			    //  Insert row data array into your database of choice here
			}

			$db->commit();
			
            $message = "Tarefas carregadas com sucesso."; 
			
			Utils_Helper::mensagens('add',$message);
            Request::current()->redirect('admin/tasks/tasks');

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

		/*

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
		*/
	}
    
	
	/*--------------*/
    public function action_searchnew()
    {	
    	$this->auto_render = false;
		$data = json_decode($this->request->query('data'));

        $taskList = ORM::factory('task')
                ->where('created_at', '>', $data)
                ->find_all();

        $arr = array('total'=>$taskList->count());
        print $callback.json_encode($arr);        
    } 
}


/*

            /*
            if($this->request->post('task_to')){
				$task->remove('userInfos');
				$taskUser = ORM::factory('userInfo', ;     	
            	$task->add('userInfos', $taskUser);
				
				$envio = $taskUser->nome;
				
				/*
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
            */
            /*
            if($this->request->post('statu_id')){
				if($this->request->post('statu_id') == 7) // 7 = Concluído
				{
					$email = new Email_Helper();
					$email->userInfo = $task->userInfo;
					
					/*
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
				$status_tasks->status_id = $this->request->post('');
				$status_tasks->task_id = $task->id;
				$status_tasks->userInfo_id = $this->current_user->userInfos->id;
				$status_tasks->description = $this->request->post('description');
				$status_tasks->step_id = $this->request->post('step_id');
				$status_tasks->save();
	
	            Controller_Admin_Files::salvar($this->request, "public/upload/curriculum", $status_tasks->id, "task", $this->current_user);	
            }	


            if(isset($envio)){
				$message.= "<br/>Email enviado ".$envio; 	
			}

			 /*
	public function action_create(){
		$view = View::factory('admin/tasks/create')
                    ->bind('errors', $errors)
                    ->bind('message', $message);
                
        $this->addValidateJs();
		$view->isUpdate = false;                		
        
	  	$this->template->content = $view;	
                
	  	if (HTTP_Request::POST == $this->request->method()) 
		{                                             
			$this->salvar();
		}
                
	}	




	DELIMITER $$

ALTER ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `moderna_taskusers` AS 
SELECT
  `moderna_tasks`.`id`          AS `id`,
  `moderna_tasks`.`object_id`   AS `object_id`,
  `moderna_tasks`.`userInfo_id` AS `userInfo_id`,
  `moderna_tasks`.`status_id`   AS `status_id`,
  `moderna_tasks`.`crono_date`  AS `crono_date`,
  `moderna_tasks`.`topic`       AS `topic`,
  `moderna_tasks`.`description` AS `description`,
  `moderna_tasks`.`created_at`  AS `created_at`,
  `moderna_tasks`.`task_id`     AS `task_id`,
  `moderna_tasks`.`task_to`     AS `task_to`
FROM `moderna_tasks`
WHERE ((NOT(`moderna_tasks`.`id` IN(SELECT
                                      `moderna_tasks`.`task_id`
                                    FROM `moderna_tasks`
                                    WHERE ((`moderna_tasks`.`status_id` = '7')
                                            OR (`moderna_tasks`.`status_id` = '6')))))
       AND (`moderna_tasks`.`task_id` = '0')
       AND (`moderna_tasks`.`status_id` = '5'))UNION SELECT
                                                       `moderna_tasks`.`id`           AS `id`,
                                                       `moderna_tasks`.`object_id`    AS `object_id`,
                                                       `moderna_tasks`.`userInfo_id`  AS `userInfo_id`,
                                                       `moderna_tasks`.`status_id`    AS `status_id`,
                                                       `moderna_tasks`.`crono_date`   AS `crono_date`,
                                                       `moderna_tasks`.`topic`        AS `topic`,
                                                       `moderna_tasks`.`description`  AS `description`,
                                                       `moderna_tasks`.`created_at`   AS `created_at`,
                                                       `moderna_tasks`.`task_id`      AS `task_id`,
                                                       `moderna_tasks`.`task_to`      AS `task_to`
                                                     FROM `moderna_tasks`
                                                     WHERE ((NOT(`moderna_tasks`.`id` IN(SELECT
                                                                                           `moderna_tasks`.`task_id`
                                                                                         FROM `moderna_tasks`
                                                                                         WHERE (`moderna_tasks`.`status_id` = '7'))))
                                                            AND (`moderna_tasks`.`task_id` <> '0')
                                                            AND (NOT(`moderna_tasks`.`task_id` IN(SELECT
                                                                                                    `moderna_tasks`.`task_id`
                                                                                                  FROM `moderna_tasks`
                                                                                                  WHERE (`moderna_tasks`.`status_id` = '7'))))
                                                            AND (`moderna_tasks`.`status_id` = '6'))
GROUP BY `moderna_tasks`.`object_id`
ORDER BY `crono_date`$$

DELIMITER ;
*/