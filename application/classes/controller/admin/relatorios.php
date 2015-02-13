<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Relatorios extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
					 
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
		$zend_data = new Zend_Gdata();
		
		// set credentials for ClientLogin authentication
	    $user = "moderna.tec@gmail.com";
	    $pass = "moderna@01";

	    $project = ORM::factory('project', $this->request->post('project_id'));
	    $view->project = $project;

	    try {  
			// connect to API
			$service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
			$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
			$service = new Zend_Gdata_Spreadsheets($client);

	    	// get spreadsheet entry
	    	// https://spreadsheets.google.com/feeds/spreadsheets/private/full
	      	$ssEntry = $service->getSpreadsheetEntry($project->ssid);
	      
	      	// get worksheets in this spreadsheet
	      	$view->wsFeed = $ssEntry->getWorksheets();
	    } catch (Exception $e) {
	      die('ERROR: ' . $e->getMessage());
	    }
	  
	    echo "<h2>".$ssEntry->title."</h2>"; 
	    
	    
	    echo "<ul>";
		foreach($wsFeed as $wsEntry){
			echo "<div class='sheet'>";
      		echo "<div class='name'>Worksheet:";
        	echo $wsEntry->getTitle()."</div>";

      		$rows = $wsEntry->getContentsAsRows();
      		echo "<table>";
      		foreach ($rows as $row){
        		echo "<tr>";
          		foreach($row as $key => $value){
          			echo "<td>".$value."</td>";
          		}
        	echo "</tr>";
      		}
      		echo "</table>";
    		echo "</div>";
    	}
		echo "</ul>";
		*/
		echo $view;

		return false;
	}


	public function action_generate(){
		$this->auto_render = false;
		ini_set('max_execution_time', 300); //max. response para 5 minutos

		$objectList = ORM::factory('objectStatu')->where('fase', '=', '1')
					->where('project_id', '=', $this->request->post('project_id'))
					->where('status_id', '!=', '8')
					->where('collection_id', 'IN', DB::select('collection_id')->from('collections_projects')->where('project_id', '=', $this->request->post('project_id')))
					->order_by('collection_name', 'ASC')
					->find_all();

		$arr = array(0 => array());

		$titulos = array('título', 'taxonomia', 'coleção', 'materia', 'tipo', 'formato', 'tamanho (kb)', 'duracao', 'reaproveitamento', 'fornecedor', 'envio', 'retorno', 'prova', 'status', 'fechamento', 'anotações');
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
}