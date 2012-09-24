<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Template {
	
	public $template = 'layout';
	
	public function __construct(Request $request, Response $response)
	{ 
	    parent::__construct($request,$response);	
	}
	
	public function action_create(){
		$this->template->content	= View::factory('create');
		
		if($_POST){
			$user = User::create_user($_POST['username'], $_POST['password'], $_POST['password_confirm'],  $_POST['email'],'admin');				
				#create the account
			if($user->save()){
				#Add the login role to the user
				//$login_role = Role::find_by_name('login');
				//$adin_role	= new Role(array('name')=>'admin');
				//AR::create_association('User', $login_role);
				//$user->roles = $login_role;
				
			}else{
				$this->template->content->errors = $user->errors;				
			}
		}
	}
	
	public function action_index()
	{
		$this->template->content	= View::factory('login');
		if(Auth::instance()->logged_in()){
			Request::current()->redirect(Session::instance()->get('requested_uri', 'admin'));
		}else{

			$this->template->styles 	= array('public/css/admin.css' => 'screen',);
			
			if($_POST)
			{
				$remember 	= isset($_POST['remember']) ? TRUE : FALSE;
				
				if(Auth::instance()->login($_POST['username'], $_POST['password'], $remember))
				{
					Request::current()->redirect(Session::instance()->get('requested_uri', 'admin'));
				}else{
					$this->template->content->errors = 'Login ou senha inválidos';
				}
			}
		}
		
	}
}
