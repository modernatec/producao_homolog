<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cadastro extends Controller_frontEnd {

	public function action_index()
	{
		$layout 				= View::factory('site/cadastro');
		
		$this->template->layout 	= $layout;
		$this->template->nav_class 	= 'black';
		$this->template->bg_img		= 'cao.png';
	}

} // End Welcome
