<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Relatorios extends Controller_Admin_Template {
 
	public $auth_required = array('login'); //Auth is required to access this controller
 
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
	
	public function action_index($ajax = null)
	{	
		$view = View::factory('admin/relatorios/view')
			->bind('message', $message);
		
		$view->projectList = ORM::factory('project')->where('status', '=', '1')->order_by('name', 'ASC')->find_all(); 		
		$view->graficos = $this->action_geraGraficos('init');
		$view->current_auth = $this->current_auth;

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

	public function action_geraGraficos($id = null){
		$this->auto_render = false;
		$view = View::factory('admin/relatorios/charts')
			->bind('message', $message);

		$project_title = ' (projetos em andamento)';
		if($id != 'init' && $id != ''){
			$project = ORM::factory('project', $id);
			$project_title = '('.$project->name.')';
		}
		$view->project_title = $project_title;

		//grafico 1 tag X qtd
		$dbTasks = DB::select('tag, count("tag_id") qtd')->from('tasks')
		->join('tags', 'INNER')
		->on('tasks.tag_id', '=', 'tags.id')
		->join('objects', 'INNER')
		->on('objects.id', '=', 'tasks.object_id')
		->where('ended', '=', '0');
		if($id != 'init' && $id != ''){
			$dbTasks->where('project_id', '=', $id);
		}
		$tasks = $dbTasks->group_by('tag_id')->as_object()->execute();
		
		$tagQtd = array(json_encode(array('tag', 'qtd')));
		foreach ($tasks as $task) {
			$r = array('('.$task->qtd.') '.$task->tag, $task->qtd);
			array_push($tagQtd, json_encode($r));
		}

		$view->tagQtd = json_encode($tagQtd);
		

		//grafico 2 status X object
		$objectDbStatus = DB::select('status, count("status_id") qtd')->from('objectstatus')
		->join('status', 'INNER')
		->on('objectstatus.status_id', '=', 'status.id');
		if($id != 'init' && $id != ''){
			$objectDbStatus->where('project_id', '=', $id);
		}

		$objectStatus = $objectDbStatus->group_by('status_id')->as_object()->execute();
		
		$statusQtd = array(json_encode(array('status', 'qtd')));
		foreach ($objectStatus as $status) {
			$r = array('('.$status->qtd.') '.$status->status, $status->qtd);
			array_push($statusQtd, json_encode($r));
		}

		$view->statusQtd = json_encode($statusQtd);

		/*lista de fechamentos*/
		$lista = DB::select('name, count("objectstatus.status_id") qtd, fechamento')->from('collections')
		->join('objectstatus', 'INNER')->on('objectstatus.collection_id', '=', 'collections.id')
		->where('objectstatus.status_id', '!=', '8')
		->and_where('objectstatus.fase', '=', '53')
		->and_where('objectstatus.project_status', '!=', '0');

		if($id != 'init' && $id != ''){
			$lista->and_where('objectstatus.project_id', '=', $id);
		}

		$view->collections = $lista->group_by('collections.id')
		->order_by('collections.fechamento', 'ASC')
		->as_object()->execute();

		if($id != 'init'){
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => $this->request->post('container'), 'type'=>'html', 'content'=> json_encode($view->render())),
				)						
			);
	        return false;
		}else{
			return $view;
		}
	}

	public function action_relatorioLink(){
		$this->auto_render = false;
		$this->generate(array("project_id"=>$this->request->query('project_id')));
		return false;
	}

	public function action_generateStatus(){
		$this->auto_render = false;
		ini_set('max_execution_time', 300); //max. response para 5 minutos

		$objectList = ORM::factory('objectStatu')->where('fase', '=', '53')
					->where('project_id', '=', $this->request->post('project_id'))
					->where('status_id', '!=', '8')
					//->where('collection_id', '=', $this->request->post('project_id'))
					
					->order_by('collection_fechamento', 'ASC')
					->order_by('collection_name', 'ASC')
					->find_all();

		$arr = array(0 => array());

		$titulos = array(
			'título', 
			'taxonomia', 
			'coleção', 
			'materia', 
			'tipo', 
			'novo/reap.', 
			'envio', 
			'retorno', 
			
			'status', 
			'fechamento', 
			'f. coleção', 
			'anotações');

		array_push($arr, $titulos);

		foreach ($objectList as $object) {
			$datas = explode("-", $object->retorno);
			$datas_e = explode("-", $object->envio);

			$retorno = ($datas[0] != '') ? PHPExcel_Shared_Date::FormattedPHPToExcel($datas[0], $datas[1], $datas[2]) : 'aguardando definição';
			//$gdocs_fechamento = $object->getGdocs($object->id);
			//var_dump($object->taxonomia);
			//$datas_f = $object->planned_date;

			$datas_fc = (!is_null($object->collection_fechamento)) ? explode("-", $object->collection_fechamento) : null;

			if($object->reaproveitamento == '0'){
				$reap = 'novo';
			}elseif($object->reaproveitamento == '1'){ 
				$reap = 'reap.';
			}else{
				$reap = 'reap. integral';
			}

			$line = array(
						'title' => $object->title, 
						'taxonomia' => $object->taxonomia, 
						
						'collection' => $object->collection_name, 
						
						'materia' => $object->materia_name, 
						'typeobject' => $object->typeobject_name,
						
						'reaproveitamento' => $reap,  
						 
						'data_envio' => PHPExcel_Shared_Date::FormattedPHPToExcel($datas_e[0], $datas_e[1], $datas_e[2]),
						'data_retorno' => $retorno,
						'status' => $object->statu_status, 
						'fechamento' => '-',
						//'fechamento' => ($datas_f[0] != "" && count($datas_f) > 1) ? PHPExcel_Shared_Date::FormattedPHPToExcel($datas_f[2], $datas_f[0], $datas_f[1]) : "-",
						'fechamento_colecao' => (!is_null($datas_fc)) ? PHPExcel_Shared_Date::FormattedPHPToExcel($datas_fc[0], $datas_fc[1], $datas_fc[2]) : "-",
						'anotacoes' => ($object->status_id != '8') ? $object->getAnotacoes($object->id) : '',
					);
			array_push($arr, $line);
    	}

    	$excel = new Spreadsheet(array('title' => $objectList[0]->project_name));
		$excel->setData($arr);
		$file = $excel->save(array('name' => 'relatorio_'.$objectList[0]->project_pasta));

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

	/*
	GERAR RELATÓRIO FINAL 

	public function action_generateStatus(){
		$this->auto_render = false;
		ini_set('max_execution_time', 300); //max. response para 5 minutos

		$objectList = ORM::factory('objectStatu')->where('fase', '=', '1')
					->where('project_id', '=', $this->request->post('project_id'))
					->where('status_id', '!=', '8')
					->where('collection_id', 'IN', DB::select('collection_id')->from('collections_projects')->where('project_id', '=', $this->request->post('project_id')))
					->order_by('collection_name', 'ASC')
					->find_all();

		$arr = array(0 => array());

		$titulos = array(
			'título', 
			'taxonomia', 
			'coleção', 
			'materia', 
			'tipo', 
			'formato', 
			'tamanho (kb)', 
			'duracao', 
			'reaproveitamento', 
			'fornecedor', 
			'envio', 
			'retorno', 
			'prova', 
			'status', 
			'fechamento', 
			'fechamento coleção', 
			'anotações');

		array_push($arr, $titulos);

		foreach ($objectList as $object) {
			$datas = explode("-", $object->retorno);
			$datas_e = explode("-", $object->envio);
			$datas_f = (!is_null($object->collection_fechamento)) ? explode("-", $object->collection_fechamento) : null;
			$line = array(
						'title' => $object->title, 
						'taxonomia' => $object->taxonomia, 
						
						'collection' => $object->collection_name, 
						
						'materia' => $object->materia_name, 
						'typeobject' => $object->typeobject_name,
						'format' => $object->format,
						'tamanho' => $object->tamanho,
						'duracao' => $object->duracao,
						'reaproveitamento' => ($object->reaproveitamento == '0') ? 'Não' : 'Sim',  
						'fornecedor' => $object->supplier_empresa, 
						'data_envio' => PHPExcel_Shared_Date::FormattedPHPToExcel($datas_e[0], $datas_e[1], $datas_e[2]),
						'data_retorno' => PHPExcel_Shared_Date::FormattedPHPToExcel($datas[0], $datas[1], $datas[2]),
						'prova' => $object->prova, 
						'status' => $object->statu_status, 
						'fechamento' => (!is_null($datas_f)) ? PHPExcel_Shared_Date::FormattedPHPToExcel($datas_f[0], $datas_f[1], $datas_f[2]) : "-",
						'anotacoes' => ($object->status_id != '8') ? $object->getAnotacoes($object->id) : '',
					);
			array_push($arr, $line);
    	}

    	$excel = new Spreadsheet(array('title' => $objectList[0]->project_name));
		$excel->setData($arr);
		$file = $excel->save(array('name' => 'relatorio_'.$objectList[0]->project_pasta));

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
	*/
}