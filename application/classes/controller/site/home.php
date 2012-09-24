<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Site_Home extends Controller_Site_Template {
 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
	
	public function action_index()
	{			
		$layout 					= View::factory('site/home');
		//$amigo = ORM::factory('amigo');
		
		$this->template->layout 	= $layout;
		$this->template->header 	= View::factory('site/header/home');
		$this->template->nav_class 	= 'black';
	} 
}