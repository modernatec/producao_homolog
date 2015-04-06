<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tasks extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); 
	public $secure_actions     	= array(
										'create' => array('login','coordenador'),
										'delete' => array('login','assistente 2'),);
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);                
	}

	public function action_index($ajax = null)
	{	
		//$this->setRefresh();
		$view = View::factory('admin/tasks/list');
		$view->userInfo_id = $this->current_user->userInfos->id;

        //$query = ORM::factory('taskView')
        //						->join('userInfos', 'INNER')->on('userInfos.id', '=', 'task_to')
        //						->where('ended', '=', '0');
		
		//if($this->current_auth != 'admin'){
		//	$query->where('taskViews.team_id', '=', $this->current_user->userInfos->team_id);
		//}
        //$view->has_task = $query->where('task_to', '!=', '0')->group_by('task_to')->order_by('nome', 'ASC')->find_all();

        if($this->request->query('to')){
        	$tasks_of = ORM::factory('userInfo', $this->request->query('to'));	
        	$nome = explode(" ", $tasks_of->nome);
        	
        	$view->title = "tarefas - ".$nome[0];
        	$view->filter = "?to=".$tasks_of->id;
        }else{
        	
        	if($this->request->query('team') != ''){
        		$team_id = $this->request->query('team');
        	}else{
        		$team_id = $this->current_user->userInfos->team_id;
        	}
        	
        	$team = ORM::factory('team', $team_id);
        	$name = explode(" ", $team->name);

        	$view->title = "tarefas - ".$name[0];
        	$view->filter = "?status=".json_encode(array("5")).'&team='.$team->id;
        }

		//$view->totalTasks = ORM::factory('task')->where('ended', '=', '0')->count_all();
		$view->current_auth = $this->current_auth;	
	  	
	  	/*alert de nova tarefa*/
	  	//$view->update = false;
  		//if(Session::instance()->get('total_tarefas') < $view->totalTasks){
  		//	$view->update = true;	  			
  		//}

	  	//Session::instance()->set('total_tarefas', $view->totalTasks);

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

	public function action_reorder(){
		$this->auto_render = false;
		if (HTTP_Request::POST == $this->request->method()) 
		{
			$i = '0';
			foreach($this->request->post('item') as $task_id){
				$task = ORM::factory('task', $task_id);
				$task->ordem = $i;
				$task->save();

				$i++;
			}
		}
	}
    
	public function action_mail(){
		$this->auto_render = false;
		$view = View::factory('admin/tasks/layout_mail');
		echo $view;

	}
    
	/**
	**Formulario popup. 	
	**/
   	public function action_update($id){
		$this->auto_render = false;
		$view = View::factory('admin/tasks/form_edit');

		$view->bind('errors', $errors)
			->bind('message', $message);
		
		$task = ORM::factory('task', $id);
		$taskVO = $this->setVO('task', $task);

		if($id == ""){
			$taskVO['object_id'] = $this->request->query('object_id');
			$taskVO['object_status_id'] = $this->request->query('object_status_id');
		}		

		$view->taskVO = $taskVO;

		$query_team =  ORM::factory('userInfo')->where('status', '=', '1');
		
		if($this->current_auth != 'admin'){
			$query_team->where('team_id', '=', $this->current_user->userInfos->team_id);
		}

		$view->teamList = $query_team->order_by('nome', 'ASC')->find_all(); 
		$view->tagList = ORM::factory('tag')->where('type', '=', 'task')->order_by('tag', 'ASC')->find_all(); 

		echo $view;
	}

	public function action_updateReply($id){
		$this->auto_render = false;
		$view = View::factory('admin/tasks/form_edit_reply');

		$view->bind('errors', $errors)
			->bind('message', $message);
		
		$task = ORM::factory('tasks_statu', $id);
		$view->taskVO = $this->setVO('tasks_statu', $task);

		echo $view;
	}
	
	public function action_salvar($id = null)
	{
		$this->auto_render = false;
		if (HTTP_Request::POST == $this->request->method()){  
	        $db = Database::instance();
	        $db->begin();
			
			$task = ORM::factory('task', $id);
			$object_id = $task->object_id;
			try {  						
				$task->values($this->request->post(), array(
					'object_id',
					'object_status_id',
					'tag_id',
					'topic',
					'crono_date',
					'description',
					'task_to',
				)); 
				
				if(empty($id)){				
					/**para não atualizar o criador da tarefa no update**/
					$task->userInfo_id = $this->current_user->userInfos->id;
					$task->team_id = $this->current_user->userInfos->team_id;
	            }

	            $task->save();  
	            $object_id = $task->object_id;

	            if(empty($id)){
	            	/*
					* cria status inicial da tarefa
					*/    
					$task_statu = ORM::factory('tasks_statu');
					$task_statu->userInfo_id = $this->current_user->userInfos->id;
					$task_statu->status_id = '5';
					$task_statu->task_id = $task->id;
					$task_statu->save();  	

					$type = "inicia_tarefa";
				}else{
					/*
					* atualiza status caso a tarefa já tenha sido iniciada
					*/
					$task_statu = ORM::factory('tasks_statu')->where('task_id', '=', $id)->and_where('status_id', '=', '6')->find();
					$task_statu->userInfo_id = $task->task_to;
					$task_statu->save(); 

					$type = "atualiza_tarefa";
				}
				
				/*
				if($this->request->post('sendmail') || empty($id)){
					/*
		            * envia email de tarefa para o usuário
		            */
		            /*
					Controller_Admin_Taskstatus::sendMail(array(
															'type' => $type,
															'subject'=> $task->tag->tag,
															'post' => $this->request->post(), 
            												'user' => $this->current_user->userInfos));	
				}
				*/

				//var_dump($this->request->post('sendmail'));

	            $db->commit();

	            $msg = "Tarefa salva com sucesso."; 
	        } catch (ORM_Validation_Exception $e) {
	            $errors = $e->errors('models');
				$erroList = '';
				foreach($errors as $erro){
					$erroList.= $erro.'<br/>';	
				}
	            $db->rollback();
	            $msg = 'Houveram alguns erros na validação <br/><br/>'.$erroList;
	        } catch (Database_Exception $e) {
	            $db->rollback();
	            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
	        }

			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$object_id),
					array('type'=>'msg', 'content'=> $msg),

				)						
			);
	        return false;
	    }
    }
	
	public function action_delete($id){    
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();
		
		$task = ORM::factory('task', $id);
		$object_id = $task->object_id;

		try {  	
			$task_status = ORM::factory('tasks_statu')->where('task_id', '=', $id)->find_all();
			foreach($task_status as $status){
				$status->delete();
			}

			$task->delete();

            $db->commit();

            $msg = "Tarefa excluída com sucesso."; 
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}

            $db->rollback();
            $msg = 'Houveram alguns erros na validação <br/><br/>'.$erroList;
        } catch (Database_Exception $e) {
            $db->rollback();
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
        }
	
		header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$object_id),
					array('type'=>'msg', 'content'=> $msg),
				)						
			);
	        return false;        
	}

    /********************************/
    public function action_getTasks(){
        $this->auto_render = false;
        $view = View::factory('admin/tasks/table');
        $view->current_auth = $this->current_auth;

        //$this->startProfilling();

        $view->filter_status = json_decode($this->request->query('status'));  
		$view->filter_task_to = $this->request->query('to');  
		$view->filter_team = $this->request->query('team');          

        $query = ORM::factory('taskView');

        if($this->current_auth != 'admin'){
			$query->where('team_id', '=', $this->current_user->userInfos->team_id);
		}

        /***Filtros***/
        (isset($view->filter_status)) ? $query->where('status_id', 'IN', $view->filter_status)->and_where('team_id', '=', $view->filter_team) : '';
        //(isset($view->filter_userInfo_id)) ? $query->where('task_to', '=', $view->filter_userInfo_id) : '';
        (isset($view->filter_task_to)) ? $query->where('task_to', '=', $view->filter_task_to) : '';

        $view->taskList = $query->and_where('ended', '=', '0')->order_by('ordem', 'ASC')->order_by('crono_date','ASC')->find_all();
               
        //$this->endProfilling();
        header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
			)						
		);
        return false;
    }  

    public function action_ongoing(){
        $this->auto_render = false;
        $view = View::factory('admin/tasks/table');
        $view->current_auth = $this->current_auth;

        $view->taskList = ORM::factory('ongoing')->where('status_id', '=', '7')->find_all();

        echo $view;
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
