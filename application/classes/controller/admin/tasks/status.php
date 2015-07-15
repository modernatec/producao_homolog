<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tasks_Status extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); 
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response); 	              
	}
	
	/*
	* inicia uma tarefa 
	*/
	public function action_start(){
		$this->auto_render = false;

		$task_ini = ORM::factory('tasks_statu')->where('task_id', '=',$this->request->post('task_id'))->find_all();
		if(count($task_ini) > 0){
			$msg = "Tarefa já foi iniciada ".$this->request->post('task_id'); 
		}else{
			$db = Database::instance();
	        $db->begin();
			
			try {  					
				$task_statu = ORM::factory('tasks_statu');
				$task_statu->task_id = $this->request->post('task_id');
				$task_statu->description = $this->request->post('description'); 
				$task_statu->started = date("Y-m-d H:i:s");
				$task_statu->save();

				/*
				* atualiza tarefa com info do user que a iniciou
				*/
				$task = ORM::factory('task', $this->request->post('task_id'));
				$task->task_to = $this->current_user->userInfos->id;
				$task->status_id = '6';
	            $task->save();
	            
	            $db->commit();
				
	            $msg = "Tarefa iniciada com sucesso."; 
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
		}

		if($this->request->post('from') == "tasks/index/ajax"){
			echo json_encode(
				array(
					array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$this->request->post('object_id')),
					array('type'=>'msg', 'content'=> $msg),
				)						
			);
		}else{
			echo json_encode(
				array(
					array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$this->request->post('object_id')),
					//array('container' => '#tabs_content', 'type'=>'url', 'content'=> URL::base().'admin/objects/getObjects/'.$task->object->project_id),
					array('type'=>'msg', 'content'=> $msg),
				)						
			);
		}

		/*
		header('Content-Type: application/json');		
		echo json_encode(
			array(
				array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$this->request->post('object_id')),
				$tabs_content,
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
		*/
        return false;
	}

	/*
	* encerra uma tarefa
	*/
	public function action_end(){
		$this->auto_render = false;
		$task_end = ORM::factory('task')->where('id', '=', $this->request->post('task_id'))->and_where('status_id', '=', '7')->find_all();
		
		if(count($task_end) > 0){
			$msg = "Tarefa já finalizada";
		}else{
			$db = Database::instance();
	        $db->begin();
			
			try {  					
				$task_statu = ORM::factory('tasks_statu')->where('task_id', '=', $this->request->post('task_id'))->find();
				$task_statu->task_id = $this->request->post('task_id');
				$task_statu->description = $this->request->post('description'); 
				$task_statu->finished = date("Y-m-d H:i:s");
				$task_statu->save();
	            
	            /*
				* atualiza flag ended, encerrando a tarefa para o user
				*/
				$task = ORM::factory('task', $this->request->post('task_id'));
				$task->delivered_date = date('Y-m-d', strtotime("now"));
				$task->diff = Utils_Helper::dataDiff($task->delivered_date, $task->planned_date);
				$task->ended = '1';
				$task->status_id = '7';
	            $task->save();

	            /*
	            * abre próx. tarefa automaticamente.
	            */
	            if($task->tag->next_tag_id != '0'){
		            $new_task = ORM::factory('task');
	            	$new_task->object_id = $task->object_id;
	            	$new_task->object_status_id = $task->object_status_id;
	            	$new_task->tag_id = $task->tag->next_tag_id;
	            	$new_task->team_id = $task->team_id;

	            	$dates = date('Y-m-d', strtotime(str_replace('/', '-', Controller_Admin_Feriados::getNextWorkDay($new_task->tag->days))));
	            	$new_task->crono_date = $dates;
	            	$new_task->planned_date = $dates;//Controller_Admin_Feriados::getNextWorkDay($task->tag->days);

	            	//$new_task->topic = '1';
	            	//$new_task->description = $description;
	            	switch ($task->tag->to) {
	            		case '1':
	            			/*
	            			* busca usuário do time, responsável pela coleção
	            			*/
	            			$userInfo = ORM::factory('userInfo', $task->userInfo_id);
	            			$object = ORM::factory('object', $task->object_id);

	            			$user_collection = ORM::factory('collections_userinfo')
	            								->where('collection_id', '=', $object->collection_id)
	            								->and_where('team_id', '=', $userInfo->team_id)->find();

	            			$task_to = $user_collection->userInfo_id;
	            			break;
	            		case '2':
	            			/*
							* fazer buscar usuário do time, menos atarefado
							* verificar se vale a pena - coordenadores sao usuários tbm!
							* SELECT 
									u.nome, 
									(SELECT COUNT(*) FROM moderna_tasks WHERE task_to = u.id AND ended = '0') AS t,
									u.team_id
								FROM moderna_userinfos u
								WHERE u.team_id = '1' 
	            			*/

	            			$task_to = '0';
	            			break;
	            		default:
	            			$task_to = '0';
	            			break;
	            	}

	            	$new_task->task_to = $task_to;
	            	$new_task->status_id = '5'; //aberto
	            	$new_task->userInfo_id = $this->current_user->userInfos->id;
		            $new_task->save(); 
		        }
				
	            $db->commit();
				
	            $msg = "Tarefa finalizada com sucesso."; 
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
		}

		header('Content-Type: application/json');

		if($this->request->post('from') == "tasks/index/ajax"){
			echo json_encode(
				array(
					array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$this->request->post('object_id')),
					array('type'=>'msg', 'content'=> $msg),
				)						
			);
		}else{
			echo json_encode(
				array(
					array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$this->request->post('object_id')),
					array('container' => '#tabs_content', 'type'=>'url', 'content'=> URL::base().'admin/objects/getObjects/'.$task->object->project_id),
					array('type'=>'msg', 'content'=> $msg),
				)						
			);
		}

        return false;
	}

	/*
	* edita um status 
	*/
	public function action_edit($id){
		$this->auto_render = false;
		if (HTTP_Request::POST == $this->request->method()){
			$db = Database::instance();
	        $db->begin();
			
			$task_status = ORM::factory('tasks_statu', $id);
			$task = ORM::factory('task', $task_status->task_id);
			try {
				
				$task_status->description = $this->request->post('description');
				$task_status->save();

	            $db->commit();
	            $msg = "status editado com sucesso."; 
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

			if($this->request->post('from') == "tasks/index/ajax"){
				echo json_encode(
					array(
						array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$task->object_id),
						array('type'=>'msg', 'content'=> $msg),
					)						
				);
			}else{
				echo json_encode(
					array(
						array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/objects/view/'.$task->object_id),
						array('container' => '#tabs_content', 'type'=>'url', 'content'=> URL::base().'admin/objects/getObjects/'.$task->object->project_id),
						array('type'=>'msg', 'content'=> $msg),
					)						
				);				
			}

	        return false;
		}
	}

	public static function sendMail($arg){
		/*
		$object = ORM::factory('object', $arg['post']['object_id']);    	
		$linkTask = URL::base().'admin/objects/view/'.$arg['post']['object_id'];
		$email = new Email_Helper();
		$send = false;
		
		
		switch($arg['type']){
			case 'inicia_tarefa':
				if($arg['post']['task_to'] != 0){
					$taskUser = ORM::factory('userInfo', $arg['post']['task_to']); 
					$send = ($taskUser->mailer == '1' && $taskUser->email != '') ? true: false;

					$email->userInfo = $taskUser;
					$nome = explode(" ", $taskUser->nome);

					$assunto = $arg['subject'].' - '.$object->taxonomia;
					$data_arr = array(
						'mensagem' => 'Olá, '.ucfirst($nome[0]).', você possuí uma nova tarefa.',
						'titulo' => $arg['subject'],
						'por' => $arg['user']->nome,
						'entrega' => $arg['post']['crono_date'],
						'descricao' => $arg['post']['description'],
						'link' => $linkTask
					);
		        }
			break;
			case 'atualiza_tarefa':
				if($arg['post']['task_to'] != 0){
					$taskUser = ORM::factory('userInfo', $arg['post']['task_to']); 
					$send = ($taskUser->mailer == '1' && $taskUser->email != '') ? true: false;

					$email->userInfo = $taskUser;
					$nome = explode(" ", $taskUser->nome);

					$assunto = $arg['subject'].' - '.$object->taxonomia;
					$data_arr = array(
						'mensagem' => 'Olá, '.ucfirst($nome[0]).', a tarefa abaixo foi atualizada.',
						'titulo' => $arg['subject'],
						'por' => $arg['user']->nome,
						'entrega' => $arg['post']['crono_date'],
						'descricao' => $arg['post']['description'],
						'link' => $linkTask
					);
		        }
			break;
			case 'entrega_tarefa':
				/* removemos as entregas uma vez que as tarefas são abertas automaticamente

				$task = ORM::factory('task', $arg['post']['task_id']);
				$taskUser = $task->userInfo;    
				$send = ($taskUser->mailer == '1' && $taskUser->email != '') ? true: false; 	
				$email->userInfo = $taskUser;
				$nome = explode(" ", $taskUser->nome);

				$assunto = $object->taxonomia.' - Tarefa concluída!';
				$data_arr = array(
					'mensagem' => 'Olá, '.ucfirst($nome[0]).', a tarefa abaixo foi concuída.',
					'titulo' => $arg['subject'],
					'entrega' => $arg['post']['crono_date'],
					'descricao' => $arg['post']['description'],
					'link' => $linkTask
				);
                       
				$email->assunto = 
				$email->mensagem = '<font face="arial"><br/><br/>
					<b>Entregue por:</b> '.$arg['user']->nome.'<br/>
					<b>Observações:</b> <pre>'.$arg['post']['description'].'</pre><br/>
					<b>Link:</b> <a href="'.$linkTask.'" title="Ir para a tarefa">'.$linkTask.'</a></font>';
				*	
			break;
		} 


		if($send){
			$template = View::factory('admin/tasks/layout_mail')
							->bind('data', $data_arr);

			$email->assunto = $assunto;
			$email->mensagem = $template;
			$email->enviaEmail();
		}
		*/
	}

	public function action_updateTasksBar(){
		$this->auto_render = false;
		if($this->current_auth != "assistente"){
	    	/*rever*/
	    	$view = View::factory('admin/bar');

	    	/*
	    	possibilidade de ordenar
			ORM::factory('task')
                ->select('tasks.id','userinfos.nome', DB::expr('COUNT(moderna_tasks.id) as total'))
                ->join('userinfos')->on('task_to', '=', 'userinfos.id')
                ->where('ended', '=', '0')->and_where('userinfos.team_id', '=', '1')
                ->group_by('userinfos.id')
                ->order_by('total', 'ASC')
                ->limit('1')
                ->find_all();
	    	*/

            /*
			$query = ORM::factory('task')
				->join('userInfos', 'INNER')->on('userInfos.id', '=', 'task_to')
				->where('ended', '=', '0')
				->where('task_to', '!=', '0');

			//somente coordenadores
			if($this->current_auth != "admin"){
				$query->where('tasks.team_id', '=', );
				/*
				$members_arr = array();
				$team_members = DB::select('id')->from('userInfos')->where('team_id', '=', $this->current_user->userInfos->team_id)->execute()->as_array();
				foreach ($team_members as $key => $member) {
					array_push($members_arr, $member['id']);
				}

				$query->and_where('tasks.task_to', 'IN', $members_arr);
				*
			}	
	    	$view->has_task = $query->group_by('task_to')->order_by('nome', 'ASC')->find_all();
	    	*/
	    	$members_arr = array();
			$team_members = DB::select('id')->from('userInfos')->where('team_id', '=', $this->current_user->userInfos->team_id)->execute()->as_array();
			foreach ($team_members as $key => $member) {
				array_push($members_arr, $member['id']);
			}

	    	$query = ORM::factory('task')
                ->select(DB::expr('count(moderna_tasks.id) as total'))
                ->join('userinfos', 'INNER')->on('task_to', '=', 'userinfos.id')
                ->where('ended', '=', '0')
                ->where('task_to', '!=', '0');
                

            if($this->current_auth != "admin"){
				$query->and_where('tasks.task_to', 'IN', $members_arr);
            }	
            //$query->and_where('tasks.team_id', '=', $this->current_user->userInfos->team_id);
                

	    	$view->has_task = $query->group_by('userinfos.id')->order_by('userinfos.nome', 'ASC')->find_all();

			$teamsVO = array();
			$query = ORM::factory('team')->order_by('name');
			if($this->current_auth != "admin"){
				$query->where('id', '=', $this->current_user->userInfos->team_id);
			}	

			$teams = $query->find_all();
			foreach($teams as $key => $team) {
				$team_qtd = ORM::factory('task')->where('ended', '=', '0')->where('team_id', '=', $team->id)->count_all();
				if($team_qtd > 0){
					$teamsVO[$key]['id'] = $team->id;
					$teamsVO[$key]['name'] = $team->name;
					$teamsVO[$key]['ico'] = substr($team->name, 0, 1);
					$teamsVO[$key]['color'] = $team->color; 
					$teamsVO[$key]['qtd'] = $team_qtd; 				
				}
			}

			$view->teamsVO = $teamsVO;

	    	$view->current_auth = $this->current_auth;
						
	        echo $view;        	
        }

        return false;
    }

}