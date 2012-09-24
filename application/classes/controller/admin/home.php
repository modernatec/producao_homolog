<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Home extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
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
		if(Auth::instance()->logged_in()== 0){	
			Request::current()->redirect('/login');
		}

		$view = View::factory('admin/home');
	  	$view->title = "Home";
                $view->taskList = ORM::factory('task')->find_all();
	  	$this->template->content = $view;
	} 
}