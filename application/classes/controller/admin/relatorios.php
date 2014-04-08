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
		$data = $this->getData($post);
		$arr = array(0 => array());

		switch ($data['organizar']) {
			case 'collection_id':
				$titulos = array('coleção','taxonomia', 'tipo', 'status', 'fornecedor', 'retorno', 'prova', 'anotações');
				array_push($arr, $titulos);

				foreach ($data['collectionList'] as $collection) {
					//array_push($arr, array(''));
					foreach ($data['objecList'] as $object) {
			    		if($object->collection_id == $collection->collection->id){
			    			if(strtotime($object->retorno) < strtotime("now")){
			    				$class = "ff0000";
			    			}else{
			    				$class = "000000";
			    			}
			    			$line = array($collection->collection->name, $object->taxonomia, $object->typeobject->name, $object->statu->status,  $object->supplier->empresa, Utils_Helper::data($object->retorno,'d/m/Y'), $object->prova, $object->anotacoes);
			    			array_push($arr, $line);
			    		}
			    	}
				}
				# code...
				break;
			default:
				# code...
				break;
		}


		$this->excel($arr);

	    /*

	    

	    if($organizar == ""){
	    	echo '<tr>
					<td >taxonomia</td>
					<td >tipo</td>
					<td >status</td>
					<td >retorno</td>
					<td >prova</td>
					<td >anotações</td>
				</tr>';	
	    	foreach ($supplierList as $supplier) {
	    		echo '<tr style="margin:10px 0px;background:#fff;"><td colspan="6"><b>'.$supplier->empresa.'</b></td></tr>';
	    			foreach ($objecList as $object) {
			    		if($object->supplier_id == $supplier->id){
			    			if(strtotime($object->retorno) < strtotime("now")){
			    				$class = "style='color:#ff0000'";
			    			}else{
			    				$class = "style='color:#000'";
			    			}
			    			echo '<tr>
			    					<td '.$class.'><a '.$class.' href="'.URL::base().'admin/objects/view/'.$object->id.'" title="Editar">'.$object->taxonomia.'</td>
			    					<td '.$class.'>'.$object->typeobject->name.'</td>
			    					<td '.$class.'>'.$object->statu->status.'</td>
			    					<td '.$class.'>'.Utils_Helper::data($object->retorno,'d/m/Y').'</td>
			    					<td '.$class.'>'.$object->prova.'</td>
			    					<td '.$class.'>'.$object->anotacoes.'</td>
			    				</tr>';		
			    		}
			    	}
	    	}
	    }

	    if($organizar == "typeobject_id"){
	    	echo '<tr>
					<td >taxonomia</td>
					<td >fornecedor</td>
					<td >status</td>
					<td >retorno</td>
					<td >prova</td>
					<td >anotações</td>
				</tr>';	
	    	foreach ($typeList as $type) {
	    		echo '<tr style="margin:10px 0px;background:#fff;"><td colspan="6"><b>'.$type->name.'</b></td></tr>';
	    			foreach ($objecList as $object) {
			    		if($object->typeobject_id == $type->id){
			    			if(strtotime($object->retorno) < strtotime("now")){
			    				$class = "style='color:#ff0000'";
			    			}else{
			    				$class = "style='color:#000'";
			    			}
			    			echo '<tr>
			    					<td '.$class.'><a '.$class.' href="'.URL::base().'admin/objects/view/'.$object->id.'" title="Editar">'.$object->taxonomia.'</td>
			    					<td '.$class.' width="100">'.$object->supplier->empresa.'</td>
			    					<td '.$class.'>'.$object->statu->status.'</td>
			    					<td '.$class.'>'.Utils_Helper::data($object->retorno,'d/m/Y').'</td>
			    					<td '.$class.'>'.$object->prova.'</td>
			    					<td '.$class.'>'.$object->anotacoes.'</td>
			    				</tr>';		
			    		}
			    	}
	    	}
	    }
		*/

		//$this->excel($view);
		
	}

	public function getData($post){
		$data = array();

		switch ($post['organizar']) {
			case 'collection_id':
				$data['collectionList'] = ORM::factory('Collections_Project')->join('objectstatus', 'INNER')
									->on('Collections_Projects.collection_id', '=', 'objectstatus.collection_id')
									->where('Collections_Projects.project_id', '=', $post['project_id'])
									->group_by('Collections_Projects.collection_id')
									->find_all();
				break;
			case 'status_id':
				$data['statusList'] = ORM::factory('statu')->join('objectstatus', 'INNER')
									->on('status.id', '=', 'objectstatus.status_id')
									->where('objectstatus.project_id', '=', $post['project_id'])
									->group_by('objectstatus.status_id')
									->find_all();

				break;			

			case 'supplier_id':
				$data['supplierList'] = ORM::factory('supplier')->join('objectstatus', 'INNER')
									->on('suppliers.id', '=', 'objectstatus.supplier_id')
									->where('objectstatus.project_id', '=', $post['project_id'])
									->group_by('objectstatus.supplier_id')
									->find_all();

				break;	
			case 'typeobject_id':
				$data['typeList'] = ORM::factory('typeobject')->join('objectstatus', 'INNER')
									->on('typeobjects.id', '=', 'objectstatus.typeobject_id')
									
									->group_by('objectstatus.typeobject_id')
									->find_all();
				break;			
			default:
				# code...
				break;
		}
		
		
		$data['objecList'] = ORM::factory('objectStatu')->where('fase', '=', '1')
					->where('project_id', '=', $post['project_id'])
					->where('reaproveitamento', '=', $post['origem'])
					->order_by('crono_date', 'ASC')
					->find_all();

		$data['organizar'] = $post['organizar'];

		return $data;
	}

	public function excel($data = NULL){
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
		$excel->save();/**'php://output' force download??***/
		//var_dump($data);
	}		
}