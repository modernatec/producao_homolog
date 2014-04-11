<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Relatorios extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
		$this->check_login();
	}
	
	public function action_index()
	{	
		$view = View::factory('admin/relatorios/view')
			->bind('message', $message);
		
		$view->projectList = ORM::factory('project')->where('status', '=', '1')->order_by('name', 'ASC')->find_all(); 
		$this->template->content = $view;  
		
		if (HTTP_Request::POST == $this->request->method()) 
		{
			$this->generate($this->request->post());
		}           
	} 

	public function generate($post){
		$objectList = $this->getData($post);
		$arr = array(0 => array());

		$titulos = array('coleção','taxonomia', 'tipo', 'reaproveitamento', 'fornecedor', 'retorno', 'prova', 'status', 'anotações');
		array_push($arr, $titulos);

		foreach ($objectList as $object) {
			$datas = explode("-", $object->retorno);
			$line = array(
						'collection' => $object->collection_name, 
						'taxonomia' => $object->taxonomia, 
						'typeobject' => $object->typeobject_name, 
						'reaproveitamento' => $object->reaproveitamento, 
						'fornecedor' => $object->supplier_empresa, 
						'data_retorno' => PHPExcel_Shared_Date::FormattedPHPToExcel($datas[0], $datas[1], $datas[2]),
						'prova' => $object->prova, 
						'status' => $object->statu_status,  
						'anotacoes' => $object->anotacoes);
			array_push($arr, $line);
    	}

		$this->excel($arr, $objectList[0]->collection_name);		
	}

	public function getData($post){
		$objectList = ORM::factory('objectStatu')->where('fase', '=', '1')
					->where('project_id', '=', $post['project_id'])
					->order_by('crono_date', 'ASC')
					->find_all();

		return $objectList;
	}

	public function excel($data = NULL, $filename = NULL){


		/*Melhorar*/

		//$filename = 'relatorio_'.date('d/m/Y').'.xls';

		/*
		header('Content-Encoding: UTF-8');
		header("Content-Type:   application/vnd.ms-excel; charset=UTF-8");
		header("Content-Disposition: attachment; filename='".$filename."'");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		*/
		/*
		// Convert to UTF-16LE
		$data = mb_convert_encoding($data, 'UTF-16LE', 'UTF-8'); 

		// Prepend BOM
		$data = "\xFF\xFE" . $data;

		header('Pragma: public');
		header("Content-type: application/x-msexcel"); 
		header('Content-Disposition: attachment;  filename="'.$filename.'"');

		echo $data;

		$phpExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('6F6F6F');
		*/

		$excel = new Spreadsheet();
		$excel->setData($data);
		$excel->save(array('name' => 'projeto'));/**'php://output' force download??***/
		//var_dump($data);
	}		
}