<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Tables extends Controller_Admin_Template {
 
	public $auth_required		= array('login','coordenador'); //Auth is required to access this controller
 	
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

	public function action_getListTables($user_id){
		$this->auto_render = false;

		header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode('')),
                array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->action_getFiltros()->render())),                
            )                       
        );
       
        return false;
	}

	public function action_getFiltros(){
		$table_view = View::factory('admin/tables/filtros');
		$table_view->list = ORM::factory('table')->where('userInfo_id', '=', $this->current_user->userInfos->id)->order_by('name','ASC')->find_all();
		return $table_view;
	}

	public function action_edit($object_id)
    {    
		$this->auto_render = false;  
		$view = View::factory('admin/tables/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$view->object_id = $object_id;

		echo $view;
	}

	public function action_salvar($id = null)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();
        $mesa_id = $id;

		try 
		{            
			$mesa = ORM::factory('table', $id)->values($this->request->post(), array(
				'name',
			));
			$mesa->userInfo_id = $this->current_user->userInfos->id;			                
			$mesa->save();

			if($this->request->post('object_id') != ''){
				$object_mesa = ORM::factory('objects_table');
				$object_mesa->table_id = $mesa->id;
				$object_mesa->object_id = $this->request->post('object_id');
				$object_mesa->save();
				$msg = "OED adicionado à mesa";
			}else{
				$msg = "tudo certo!";
			}

			$mesa_id = $mesa->id;

			$db->commit();
			
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

		if($this->request->post('object_id') != ''){
			echo json_encode(
				array(
					array('type'=>'msg', 'content'=> $msg),
				)						
			);
		}else{
			echo json_encode(
				array(
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->action_getFiltros()->render())),
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getObjectsTable($mesa_id, true)->render())),
					array('type'=>'msg', 'content'=> $msg),
				)						
			);
		}

        return false;
	}

	public function action_add($mesa_id)
	{
		$this->auto_render = false;
		$db = Database::instance();
        $db->begin();

		try 
		{      
			/**
			* Melhorar
			*/
			$object_id = $this->request->post('object_id');      
			$exist = ORM::factory('objects_table')->where('table_id', '=', $mesa_id)->and_where('object_id', '=', $object_id)->find_all();
			if(count($exist) > 0){
				$msg = "Este OED já existe nesta mesa";
			}else{
			//if($this->request->post('object_id') != ''){
				$object_mesa = ORM::factory('objects_table');
				$object_mesa->table_id = $mesa_id;
				$object_mesa->object_id = $object_id;
				$object_mesa->save();
				$msg = "OED adicionado à mesa";
			//}
			}

			$db->commit();
			
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

        echo $msg;

        return false;
	}
	
	public function action_delete($id)
	{	
		$this->auto_render = false;
		try 
		{            
			$table = ORM::factory('table', $id);
			$table->delete();
			DB::delete('objects_tables')->where('table_id','=', $id)->execute();

			$msg = "mesa excluída.";
		} catch (ORM_Validation_Exception $e) {
			$msg = "houveram alguns erros na exclusão dos dados.";
			$errors = $e->errors('models');
		}
		
		header('Content-Type: application/json');
		echo json_encode(
			array(
				array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode('')),
				array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->action_getFiltros()->render())),
				array('type'=>'msg', 'content'=> $msg),
			)						
		);
	}

	public function action_getObjectsTable($id, $ajax = null)
	{	
		$this->auto_render = false;  
		$view = View::factory('admin/tables/table')
			->bind('errors', $errors)
			->bind('message', $message);

		$view->table = ORM::factory('table', $id);
		$view->objectsList = ORM::factory('objects_table')->where('table_id', '=', $id)->find_all();

		if($ajax != null){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
		}
        return false;
	}

	public function action_export($mesa_id){
		$this->auto_render = false;
		ini_set('max_execution_time', 300); //max. response para 5 minutos

		$table = ORM::factory('table', $mesa_id);

		$objectList = ORM::factory('objects_table')
					->join('objects')->on('objects_tables.object_id', '=', 'objects.id')
					->where('objects.fase', '=', '1')
					->where('objects_tables.table_id', '=', $mesa_id)
					->order_by('objects.title', 'ASC')
					->find_all();

		$arr = array(0 => array());

		$titulos = array(
			'título', 
			'taxonomia', 
			'reaproveitamento',
			'correção (sim/não)', 
			'observações', 
		);

		//array_push($arr, $titulos);
		array_push($arr, $titulos);

		foreach ($objectList as $table_object) {
			if($table_object->object->reaproveitamento == '0'){
				$reap = 'novo';
			}elseif($table_object->object->reaproveitamento == '1'){ 
				$reap = 'reap.';
			}else{
				$reap = 'reap. integral';
			}

			$line = array(
						'title' => $table_object->object->title, 
						'taxonomia' => $table_object->object->taxonomia, 
						'reaproveitamento' => $reap,  
						'correcao' => '',
						'observacoes' => '',
					);
			array_push($arr, $line);
    	}

    	$file_name = Utils_Helper::limparStr($this->current_user->userInfos->nome);

    	$excel = new Spreadsheet(array('title' => $table->name));
		$excel->setData($arr);
		$file = $excel->save(array('name' => 'mesa_luz_'.$file_name));

		if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);

            unlink($file);
            exit;
        }
	}
}