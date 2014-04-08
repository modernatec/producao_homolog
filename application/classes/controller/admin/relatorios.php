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
		$view = $this->getData($post);
		$this->excel($view);
		
	}

	public function getData($post){
		$this->auto_render = false;

		$view = View::factory('admin/relatorios/relatorio')
			->bind('message', $message);

		switch ($post['organizar']) {
			case 'collection_id':
				$view->collectionList = ORM::factory('Collections_Project')->join('objectstatus', 'INNER')
									->on('Collections_Projects.collection_id', '=', 'objectstatus.collection_id')
									->where('Collections_Projects.project_id', '=', $post['project_id'])
									->group_by('Collections_Projects.collection_id')
									->find_all();
				break;
			case 'status_id':
				$view->statusList = ORM::factory('statu')->join('objectstatus', 'INNER')
									->on('status.id', '=', 'objectstatus.status_id')
									->where('objectstatus.project_id', '=', $post['project_id'])
									->group_by('objectstatus.status_id')
									->find_all();

				break;			

			case 'supplier_id':
				$view->supplierList = ORM::factory('supplier')->join('objectstatus', 'INNER')
									->on('suppliers.id', '=', 'objectstatus.supplier_id')
									->where('objectstatus.project_id', '=', $post['project_id'])
									->group_by('objectstatus.supplier_id')
									->find_all();

				break;	
			case 'typeobject_id':
				$view->typeList = ORM::factory('typeobject')->join('objectstatus', 'INNER')
									->on('typeobjects.id', '=', 'objectstatus.typeobject_id')
									
									->group_by('objectstatus.typeobject_id')
									->find_all();

				break;			
			default:
				# code...
				break;
		}
		
		
		$view->objecList = ORM::factory('objectStatu')->where('fase', '=', '1')
					->where('project_id', '=', $post['project_id'])
					->where('reaproveitamento', '=', $post['origem'])
					->order_by('crono_date', 'ASC')
					->find_all();

		$view->organizar = $post['organizar'];


		return $view;
	}

	public function excel($data = NULL){
		/*Melhorar*/

		$filename = 'relatorio_'.date('d/m/Y').'.xls';

		header("Content-Type:   application/vnd.ms-excel; charset='utf-8'");
		header("Content-Disposition: attachment; filename='".$filename."'");  //File name extension was wrong
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);

		echo $data;
	}		
}