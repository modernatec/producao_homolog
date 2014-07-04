<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Taskstatus extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); 
	public $secure_actions     	= array(
										'create' => array('login','coordenador'),
										'delete' => array('login','admin'),);
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response); 
		$this->check_login();	               
	}
  
	
	/*
	* inicia uma tarefa 
	*/
	public function action_start(){
		if (HTTP_Request::POST == $this->request->method()) 
		{
			$task_ini = ORM::factory('tasks_statu')->where('task_id', '=',$this->request->post('task_id'))->and_where('status_id', '=', '6')->find_all();
			if(count($task_ini) > 0){
				$message = "Tarefa já foi iniciada ".$this->request->post('task_id'); 
			
				Utils_Helper::mensagens('add',$message);
            	Request::current()->redirect('admin/objects/view/'.$this->request->post('object_id'));
			}else{
				$db = Database::instance();
		        $db->begin();
				
				try {  					
					$task_statu = ORM::factory('tasks_statu');
					$task_statu->userInfo_id = $this->current_user->userInfos->id;
					$task_statu->status_id = '6';
					$task_statu->task_id = $this->request->post('task_id');
					$task_statu->description = $this->request->post('description'); 
					$task_statu->save();

					/*
					* atualiza tarefa com info do user que a iniciou
					*/
					$task = ORM::factory('task', $this->request->post('task_id'));
					$task->task_to = $this->current_user->userInfos->id;
		            $task->save();
		            
		            $db->commit();
					
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
		}
	}	

	/*
	* encerra uma tarefa
	*/
	public function action_end(){
		if (HTTP_Request::POST == $this->request->method()) 
		{
			$task_end = ORM::factory('tasks_statu')->where('task_id', '=',$this->request->post('task_id'))->and_where('status_id', '=', '7')->find_all();
			if(count($task_end) > 0){
				$message = "Tarefa já finalizada";
			
				Utils_Helper::mensagens('add',$message);
            	Request::current()->redirect('admin/objects/view/'.$this->request->post('object_id'));
			}else{
				$db = Database::instance();
		        $db->begin();
				
				try {  					
					$task_statu = ORM::factory('tasks_statu');
					$task_statu->userInfo_id = $this->current_user->userInfos->id;
					$task_statu->status_id = '7';
					$task_statu->task_id = $this->request->post('task_id');
					$task_statu->description = $this->request->post('description'); 
					$task_statu->save();
		            
		            /*
					* atualiza flag ended, encerrando a tarefa para o user
					*/
					$task = ORM::factory('task', $this->request->post('task_id'));
					$task->ended = '1';
		            $task->save();

		            /*
		            * envia email de entrega
		            */
		            $this->sendMail(
			            	array(	
				            	'type' => 'entrega_tarefa',
				            	'post' => $this->request->post(), 
		            			'user' => $this->current_user->userInfos));
		            
		            $db->commit();
					
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
		}
	}

	public static function sendMail($arg){
		$object = ORM::factory('object', $arg['post']['object_id']);    	
		$linkTask = URL::base().'admin/objects/view/'.$arg['post']['object_id'];
		
		switch($arg['type']){
			case 'inicia_tarefa':
				if($arg['post']['task_to'] != 0){
					$taskUser = ORM::factory('userInfo', $arg['post']['task_to']); 
					
					if($taskUser->mailer == '1'){							
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
			break;
			case 'entrega_tarefa':
				$task = ORM::factory('task', $arg['post']['task_id']);
				$taskUser = $task->userInfo;     	
				
				if($taskUser->mailer == '1'){					
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
			break;
		} 
	}
}