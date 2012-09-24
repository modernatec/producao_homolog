<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Site_Homeinvestidor extends Controller_Site_Template {
 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
	
	public function action_index()
	{
		$view = View::factory('site/home');
		echo "Com hifem";
	  	$this->template->content = $view;
	} 
}