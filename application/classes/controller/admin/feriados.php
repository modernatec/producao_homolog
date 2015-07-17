<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Feriados extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 	
	
	public $secure_actions     	= array(
										'create' => array('login', 'coordenador'),
										'edit' => array('login', 'coordenador'),
										'delete' => array('login', 'coordenador'),
                                  );
	
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}

	public function action_getList($ajax = null){
		$this->auto_render = false;
        $view = View::factory('admin/feriados/table');

        $view->feriadosList = ORM::factory('feriado')->order_by('data','DESC')->find_all();
        
        if($ajax != null){
            return $view;
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
                    array('container' => '#direita', 'type'=>'html', 'content'=> json_encode("")),
                )                       
            );
           
            return false;
        }
	}
        
	public function action_edit($id)
    {    
		$this->auto_render = false;  
		$view = View::factory('admin/feriados/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$feriado = ORM::factory('feriado', $id);
		$view->objVO = $this->setVO('feriado', $feriado);

		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
			)						
		);
        return false;
			
	}

	public function action_salvar($id = null)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();

		try 
		{            
			$feriado = ORM::factory('feriado', $id)->values($this->request->post(), array(
				'feriado',
				'data',
			));
			                
			$feriado->save();
			$db->commit();

			$msg = "tudo certo!";		

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $msg = 'houveram alguns erros na validação <br/><br/>'.$erroList;
            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            $db->rollback();
        }

		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getList(true)->render())),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);

        return false;
	}
	
	public function action_delete($id)
	{	
		$this->auto_render = false;
		try 
		{            
			$objeto = ORM::factory('feriado', $id);
			$objeto->delete();

			$msg = "feriado excluído.";
		} catch (ORM_Validation_Exception $e) {
			$msg = "houveram alguns erros na exclusão dos dados.";
			$errors = $e->errors('models');
		}
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/feriados/index/ajax'),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}

	/*
	* Melhorar
	*/
	public function action_getWorkDay($days){
		$this->auto_render = false;
		if($this->request->post('from') != ''){
			$from = date('Y-m-d', strtotime(str_replace('/', '-', $this->request->post('from'))));
		}else{
			$from = 'now';
		}

		$feriados = DB::select('data')->from('feriados')->execute()->as_array('data');

		$x = 0;
		$i = 1;

		if($days != 0){
			if($days > 0){
				$signal = ' + ';
			}else{
				$signal = ' - ';
				$days = $days *-1;
			}

			while ($x < $days) {
				$nextBusinessDay = date('Y-m-d', strtotime($from . $signal . $i . ' Weekday'));

				while (array_key_exists($nextBusinessDay, $feriados)) {
				    $i++;
				    $nextBusinessDay = date('Y-m-d', strtotime($from . $signal . $i . ' Weekday'));
				}
				$i++;
				$x++;
			}
		}else{
			$i = 0;
			$nextBusinessDay = date('Y-m-d', strtotime($from . ' +' . $i . ' Weekday'));
			/*
			while (array_key_exists($nextBusinessDay, $feriados)) {
			    $i++;
			    $nextBusinessDay = date('Y-m-d', strtotime($from . ' +' . $i . ' Weekday'));
			}
			$i++;
			*/
		}

		if(date( "w", strtotime($nextBusinessDay)) == '0'){
			$nextBusinessDay = date('Y-m-d', strtotime($from . ' +' . $i . ' Weekday'));
		}

		echo Utils_Helper::data($nextBusinessDay);
	}

	/*
	* Acessar de outros controllers, mas esta redundante.
	*/
	public static function getNextWorkDay($days){
		$feriados = DB::select('data')->from('feriados')->execute()->as_array('data');
		$from = 'now';
		$x = 0;
		$i = 1;

		if($days != 0){
			while ($x < $days) {
				$nextBusinessDay = date('Y-m-d', strtotime($from . ' +' . $i . ' Weekday'));

				while (array_key_exists($nextBusinessDay, $feriados)) {
				    $i++;
				    $nextBusinessDay = date('Y-m-d', strtotime($from . ' +' . $i . ' Weekday'));
				}
				$i++;
				$x++;
			}
		}else{
			$i = 0;
			$nextBusinessDay = date('Y-m-d', strtotime($from . ' +' . $i . ' Weekday'));
			/*
			while (array_key_exists($nextBusinessDay, $feriados)) {
			    $i++;
			    $nextBusinessDay = date('Y-m-d', strtotime($from . ' +' . $i . ' Weekday'));
			}
			$i++;
			*/
		}

		if(date( "w", strtotime($nextBusinessDay)) == '0'){
			$nextBusinessDay = date('Y-m-d', strtotime($from . ' +' . $i . ' Weekday'));
		}

		return Utils_Helper::data($nextBusinessDay);
	}
}