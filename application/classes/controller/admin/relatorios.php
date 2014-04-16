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
		$objectList = ORM::factory('objectStatu')->where('fase', '=', '1')
					->where('project_id', '=', $post['project_id'])
					->order_by('crono_date', 'ASC')
					->find_all();

		$arr = array(0 => array());

		$titulos = array('coleção', 'materia','taxonomia', 'tipo', 'reaproveitamento', 'fornecedor', 'retorno', 'prova', 'status', 'anotações');
		array_push($arr, $titulos);

		foreach ($objectList as $object) {
			$datas = explode("-", $object->retorno);
			$line = array(
						'collection' => $object->collection_name, 
						'materia' => $object->materia_name, 
						'taxonomia' => $object->taxonomia, 
						'typeobject' => $object->typeobject_name, 
						'reaproveitamento' => ($object->reaproveitamento == '0') ? 'Não' : 'Sim',  
						'fornecedor' => $object->supplier_empresa, 
						'data_retorno' => PHPExcel_Shared_Date::FormattedPHPToExcel($datas[0], $datas[1], $datas[2]),
						'prova' => $object->prova, 
						'status' => $object->statu_status,  
						'anotacoes' => $object->anotacoes);
			array_push($arr, $line);
    	}

    	$excel = new Spreadsheet();
		$excel->setData($arr);
		$excel->save(array('name' => 'projeto'));
	}
}