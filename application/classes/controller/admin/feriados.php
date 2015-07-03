<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Feriados extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 	
	/*
	public $secure_actions     	= array(
										'create' => array('login', 'coordenador'),
										'edit' => array('login', 'coordenador'),
										'delete' => array('login', 'coordenador'),
                                  );
	*/
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/feriados/list')
			->bind('message', $message);
		
		$view->feriadosList = ORM::factory('feriado')->order_by('data','ASC')->find_all();
		
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
        
	public function action_edit($id)
    {    
		$this->auto_render = false;  
		$view = View::factory('admin/feriados/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$feriado = ORM::factory('feriado', $id);
		$view->objVO = $this->setVO('feriado', $feriado);
		//$this->template->content = $view;

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

			$msg = "feriado salvo com sucesso.";		

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
				array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/feriados/index/ajax'),
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

			$msg = "matéria excluído com sucesso";
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

	public function action_getWorkDay($days){
		$this->auto_render = false;
		echo Controller_Admin_Feriados::getNextWorkDay($days);
	}

	public static function getNextWorkDay($days){
		$feriados = DB::select('data')->from('feriados')->execute()->as_array('data');
		
		$next_date = date('Y-m-d', strtotime('now +'.$days.' weekdays'));

		if (array_key_exists($next_date, $feriados)) { 
		    Controller_Admin_Feriados::getNextWorkDay($days + 1);
		}else{
			return Utils_Helper::data($next_date);
		}
	}

}