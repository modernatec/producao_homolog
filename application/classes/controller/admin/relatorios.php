<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Relatorios extends Controller_Admin_Template {
 
	public $auth_required		= array('login','admin', 'coordenador'); //Auth is required to access this controller
 
	public $secure_actions     	= array('post' => array('login','admin','coordenador', 'assistente'),
								   'edit' => array('login','admin'),
								   'delete' => array('login','admin'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
	
	public function action_index()
	{	
		echo "ok";
		//$user = ORM::factory('user', 1);
		//$view = View::factory('admin/tasks/list');
	  	//$this->template->content = $view;
	} 

	public function action_edit(){
		$teste = "TESTE";
	}
	
}