<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Site_Canal extends Controller_Site_Template {
 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
	
	public function action_index($canal)
	{
		$layout 					= View::factory('site/canal');
		
		$this->template->layout 	= $layout;
		$this->template->header 	= View::factory('site/header/canal');
		$this->template->nav_class 	= 'black';
	} 
	
	public function action_list($canal)
	{
		var_dump("LISTA ".$canal);	
		$layout 					= View::factory('site/canal');
		
		$this->template->layout 	= $layout;
		$this->template->header 	= View::factory('site/header/canal');
		$this->template->nav_class 	= 'black';
	} 
}