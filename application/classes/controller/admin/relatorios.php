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
		
		if($ajax == null){
			$this->template->content = $view;
		}else{
			$this->auto_render = false;
			echo $view;
		}   		         
	} 

	public function action_relatorioLink(){
		$this->auto_render = false;
		$this->generate(array("project_id"=>$this->request->query('project_id')));
		return false;
	}

	public function action_updateGdocs()
	{
		$this->auto_render = false;
		$view = View::factory('admin/relatorios/sync');
		
		// set credentials for ClientLogin authentication
	    $user = "moderna.tec@gmail.com";
	    $pass = "moderna@01";

	    $project = ORM::factory('project', $this->request->post('project_id'));
	    $view->project = $project;

      	// connect to API
      	//https://spreadsheets.google.com/feeds/spreadsheets/private/full

    	$service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
      	$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
		$spreadsheetService = new Zend_Gdata_Spreadsheets($client);
		//$feed = $spreadsheetService->getSpreadsheetFeed();

		$r = array();
		if(!empty($project->ssid)){
			$spreadsheetKey = $project->ssid;	

			$gdocs_obj = ORM::factory('gdoc')->where('project_id', '=', $project->id)->find_all();
			foreach ($gdocs_obj as $obj) {
				$obj->delete();
			}

			//FUNCIONA
			/*
			$searchFor = array(
					"Taxonomia do arquivo", 
					"Envio para a produtora",
					"Prova 1",
					"Prova 1 Relatório consolidado de conteúdo",
					"Prova 1 Relatório de erros",
					"Prova 2",
					"Prova 2 Relatório consolidado de conteúdo",
					"Prova 2 Relatório de erros",
					"Prova 3",
					"Prova 3 Relatório consolidado de conteúdo",
					"Prova 3 Relatório de erros",
					"Prova 4",
					"OK",
			);
			*/

			$searchFor = array(
				"taxonomiadoarquivo", 
				"envioparaaprodutora",
				"prova1",
				"prova1relatórioconsolidadodeconteúdo",
				"prova1relatóriodeerros",
				"prova2",
				"prova2relatórioconsolidadodeconteúdo",
				"prova2relatóriodeerros",
				"prova3",
				"prova3relatóriodeconteúdo",
				"prova3relatóriodeerros",
				"prova4",
				"ok",
				"observações"
			);

			$arrayKeyDb = array(
				"taxonomia",
				"envio_produtora",
				"p1",
				"rt1",
				"r1",
				"p2",
				"rt2",
				"r2",
				"p3",
				"rt3",
				"r3",
				"p4",
				"fechamento",
				"observacoes",
			);			

			$query = new Zend_Gdata_Spreadsheets_DocumentQuery();
			$query->setSpreadsheetKey($spreadsheetKey);
			$feed = $spreadsheetService->getWorksheetFeed($query);
		
        	foreach ($feed as $entry) {
				$entries = $entry->getContentsAsRows();
				//$entries = $feed->entries[0]->getContentsAsRows();
								
				foreach ($entries as $value) {
					foreach ($value as $key => $nv) {
						if(!in_array($key, $searchFor)){
							unset($value[$key]);	
						}						
					}
					
					if(!empty($value['taxonomiadoarquivo'])){
						$c = array_combine($arrayKeyDb, $value);
						
						$db = Database::instance();
        				$db->begin();

						try {
							$gdocs_item = ORM::factory('gdoc');
							$gdocs_item->values($c, $arrayKeyDb); 

							$object = ORM::factory('object')->where('taxonomia', '=', $c['taxonomia'])->find();
							$gdocs_item->object_id = $object->id;
							$gdocs_item->project_id = $project->id;

							$gdocs_item->save();
							
							$db->commit();	

							if($object->id == ""){
								$msg = "<span class='list_faixa red round' >".$gdocs_item->taxonomia. " - não encontrado no kaizen </span>";
							}else{
								$msg = "<span class='list_faixa blue round' >".$gdocs_item->taxonomia. " - OK </span>";
							}
						}catch (ORM_Validation_Exception $e) {
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

				        array_push($r, $msg);
					}
				}
			}

		    
		    
		}else{
			$msg = "<span class='list_faixa red round' >o projeto não esta com a planilha do gdocs cadastrada</span>";
			array_push($r, $msg);
		}   
		$view->r = $r;
		echo $view; 

		return false;
	}


	public function action_generateStatus(){
		$this->auto_render = false;
		ini_set('max_execution_time', 300); //max. response para 5 minutos

		$objectList = ORM::factory('objectStatu')->where('fase', '=', '1')
					->where('project_id', '=', $this->request->post('project_id'))
					->where('status_id', '!=', '8')
					->where('collection_id', 'IN', DB::select('collection_id')->from('collections_projects')->where('project_id', '=', $this->request->post('project_id')))
					
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
			'fornecedor', 
			'envio', 
			'retorno', 
			'prova', 
			'status', 
			'fechamento', 
			'f. coleção', 
			'anotações');

		array_push($arr, $titulos);

		foreach ($objectList as $object) {
			$datas = explode("-", $object->retorno);
			$datas_e = explode("-", $object->envio);
			$gdocs_fechamento = $object->getGdocs($object->id);
			var_dump($object->taxonomia);
			$datas_f = (!is_null($gdocs_fechamento)) ? explode("/", $gdocs_fechamento->fechamento) : null;

			$datas_fc = (!is_null($object->collection_fechamento)) ? explode("-", $object->collection_fechamento) : null;
			$line = array(
						'title' => $object->title, 
						'taxonomia' => $object->taxonomia, 
						
						'collection' => $object->collection_name, 
						
						'materia' => $object->materia_name, 
						'typeobject' => $object->typeobject_name,
						
						'reaproveitamento' => ($object->reaproveitamento == '0') ? 'Novo' : 'Reap.',  
						'fornecedor' => $object->supplier_empresa, 
						'data_envio' => PHPExcel_Shared_Date::FormattedPHPToExcel($datas_e[0], $datas_e[1], $datas_e[2]),
						'data_retorno' => PHPExcel_Shared_Date::FormattedPHPToExcel($datas[0], $datas[1], $datas[2]),
						'prova' => $object->prova, 
						'status' => $object->statu_status, 
						'fechamento' => ($datas_f[0] != "" && count($datas_f) > 1) ? PHPExcel_Shared_Date::FormattedPHPToExcel($datas_f[2], $datas_f[0], $datas_f[1]) : "-",
						'fechamento_colecao' => (!is_null($datas_f)) ? PHPExcel_Shared_Date::FormattedPHPToExcel($datas_fc[0], $datas_fc[1], $datas_fc[2]) : "-",
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