<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Template extends Controller_Template 
{
     
	public $template = 'site/template';

    public $auth_required = FALSE;

    public $secure_actions = FALSE;

	public function before()
	{
		parent::before();

		#Open session
		$this->session= Session::instance();

		#Check user auth and role'
		$action_name = Request::current()->action();
		if (($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
		        || (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && 
		        Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE))
		{
			if (Auth::instance()->logged_in()){
				Request::current()->redirect('/admin/admin/noaccess');
			}else{
				Request::current()->redirect('/login');
			}
		}

		if ($this->auto_render)
		{
			// Initialize empty values
			$this->template->title   = '';
			$this->template->content = '';

			$this->template->styles = array();
			$this->template->scripts = array();   

		}

	}

	public function after()
	{
		if ($this->auto_render)
		{
			$styles = array(
				'public/css/common/reset.css' => 'all',
				'public/css/common/form.css' => 'all',
				'public/css/common/errors.css' => 'all',
				'public/javascript/site/nivo-slider/themes/default/default.css' => 'all',
				'public/javascript/site/nivo-slider/nivo-slider.css' => 'all',
				
				'public/css/site/4mypet.css' => 'all',
			);
			
			
			//<script language="javascript" type="text/javascript" src="niceforms.js"></script>
			//<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />

			$scripts = array(
				'public/javascript/site/jquery-1.5.1.min.js',
				'public/javascript/site/validation/jquery.validate.js',
				'public/javascript/site/validation/lib/jquery.metadata.js',
				'public/javascript/site/nivo-slider/jquery.nivo.slider.pack.js',
				'public/javascript/site/4mypet.js',
			);

			$this->template->styles 	= array_merge( $this->template->styles, $styles );
			$this->template->scripts 	= array_merge( $this->template->scripts, $scripts );
			
			if (Auth::instance()->logged_in()){
				$this->template->username	= Auth::instance()->get_user()->username;
			}
			
			$this->template->xml = '<?xml version="1.0" encoding="UTF-8"?>';
		}
		parent::after();
	}
	
}