	<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Template extends Controller_Template {
 
	public $template = 'admin/template';

	public $lightbox = '';

	// Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
	// Can be set to a string or an array, for example 'login' or array('login', 'admin')
	// Note that in second(array) example, user must have both 'login' AND 'admin' roles set in database
	public $auth_required = FALSE;

	// Controls access for separate actions
	// 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
	// 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
	public $secure_actions = FALSE;

	public $current_user;

	public $current_auth;

	protected $menus;
 
	/**
	* The before() method is called before your controller action.
	* In our template controller we override this method so that we can
	* set up default values. These variables are then available to our
	* controllers if they need to be modified.
	*/
	public function before()
	{
		parent::before();
		
		#Open session
		$this->session = Session::instance();
		
		#Check user auth and role
		$action_name = Request::current()->action();
		if (($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
				|| (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && 
				Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE))
		{
			if (Auth::instance()->logged_in()){
				//Request::instance()->redirect('account/noaccess');
				//Utils_Helper::mensagens('add',"você não tem acesso a este conteúdo");
				//Request::current()->redirect(URL::base().'/admin/#tasks/index/ajax');
				echo 'você não tem acesso a este conteúdo';
			}else{
				Request::current()->redirect('login');
				//echo 'login';
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
		
		$this->current_user = Auth::instance()->get_user();
		
		if($this->current_user){	
			$user_roles = $this->current_user->roles->where('id', '!=', '1')->order_by('id', 'DESC')->find_all();
			
			foreach($user_roles as $role){
				$this->current_auth = $role->name;
				$this->menus = $role->menus->order_by('ordem', 'ASC')->find_all()->as_array();
			}
		}		
  	}

	/**
	* The after() method is called after your controller action.
	* In our template controller we override this method so that we can
	* make any last minute modifications to the template before anything
	* is rendered.
	*/
	public function after(){
        if ($this->auto_render)
        {
        	$styles = array(
				'public/css/common/reset.css' => 'screen',
				'public/css/common/jquery-ui/jquery-ui.min.css' => 'screen',	
				'public/css/admin/nested.css' => 'screen',
				'public/css/admin/jquery.mCustomScrollbar.css' => 'screen',
				'public/css/common/jquery.jgrowl.css' => 'screen',
				
				'public/css/common/dropzone.css' => 'screen',
				
				'public/css/admin/jquery.minicolors.css' => 'screen',
				'public/css/admin/masterpage.css' => 'screen',
				'public/css/admin/login.css' => 'screen',

            );

            $scripts = array(
				'public/js/common/jquery/jquery-1.8.3.js',
				'public/js/common/jquery/jquery-ui.min.js',
				'public/js/common/jquery/jquery.validate.js',
				'public/js/common/jquery/jquery.cookie.js',
				//'public/js/common/jquery/jquery-dateFormat.min.js',
				
				'public/js/common/jquery/jquery.ui.datepicker-pt-br.js',

				'public/js/common/jgrowl/jquery.jgrowl.js',
				'public/js/common/jquery/jquery.maskedinput.min.js',
				
				'public/js/common/jquery/jquery.easing.min.js',
				'public/js/admin/jquery.mCustomScrollbar.min.js',
				'public/js/admin/jquery.minicolors.js',
				
				'public/js/common/ckeditor/ckeditor.js',
				'public/js/common/ckeditor/adapters/jquery.js',
				'public/js/common/autoNumeric.js',

				'https://www.google.com/jsapi',	

				'public/js/common/dropzone.js',

				'public/js/admin/admin.js',
				'public/js/admin/validateAjax.js',
				'public/js/common/Popup.js',
            );

            $this->template->styles 	= array_merge( $styles, $this->template->styles );
            $this->template->scripts 	= array_merge( $scripts, $this->template->scripts );
        }

        $this->template->title = " - ".ucfirst($this->request->controller());
        $this->template->current_auth = $this->current_auth;
        /*rever*/
        $this->template->menu = ($this->current_user) ? View::factory('admin/menu') : '';
		$this->template->bar = ($this->current_user) ? '<div id="taskBar"></div>' : '';
		
		$hollidays_arr = array();
		$hollidays = ORM::factory('feriado')->find_all();
		foreach ($hollidays as $holliday) {
			array_push($hollidays_arr, $holliday->data);
		}
		$this->template->hollidays = json_encode($hollidays_arr);

		/*
		styles team
		*/
		$css = '';
		$teams = ORM::factory('team')->find_all();
		
		foreach ($teams as $team) {
			$css.= '.team_'.$team->id.'{
				background:'.$team->color.';
				color:#fff;
				border: 2px solid '.$team->color.' !important;
			}
			';
		}	

		$status = ORM::factory('statu')->find_all();
		
		foreach ($status as $statu) {
			$css.= '.'.$statu->type.'_status'.$statu->id.'{
				background:'.$statu->color.';
				color:#fff;
			}
			.step_'.$statu->type.'_status'.$statu->id.'{
				border-left:5px solid '.$statu->color.' !important;
			}';
		}	

		$this->template->team_css = $css;

        if($this->current_user){	
			$this->template->user = $this->current_user;
			$this->template->menu->user = $this->current_user;
			
			$menuList = array();	
			foreach($this->menus as $key=>$menu_item){
				if($menu_item->sub == 0){
					$menuList[$key]['display'] = $menu_item->display;
					$menuList[$key]['link'] = $menu_item->link;
					
					foreach($this->menus as $menu_sub_item){
						if($menu_sub_item->sub == $menu_item->id){
							$sub_item = array(
								'display' =>  $menu_sub_item->display,
								'link' => $menu_sub_item->link
							);								
							$menuList[$key]['sub'][] = $sub_item;		
						}							
					}
				}
			}

			$this->template->menu->menuList = $menuList;			
        }


        $this->template->mensagens = Utils_Helper::mensagens('print');
        parent::after();
    }

    public function startProfilling(){
    	if (Kohana::$profiling === TRUE)
	    {
	        $benchmark = Profiler::start('Your Category', __FUNCTION__);
	        return $benchmark;
	    }
    }

    public function endProfilling(){
    	if (isset($benchmark))
	    {
	        // Stop the benchmark
	        Profiler::stop($benchmark);
	    }

	    echo View::factory('profiler/stats');
    }
	
	protected function setVO($table, $obj = null){
		$arr = array();
		$post = $this->request->post();	
		$fields = ORM::factory($table)->list_columns();
		
		foreach($fields as $key=>$value){
			if(Arr::get($post, $key)){
				$arr[$key] = $post[$key];	
			}else{
				if($fields[$key]['data_type'] == 'datetime' || $fields[$key]['data_type'] == 'timestamp' || $fields[$key]['data_type'] == 'date'){
					$f = ($obj) ? Utils_Helper::data($obj->$key) : '';
				}else{
					$f = ($obj) ? $obj->$key : '';	
				}
				
				$arr[$key] = ($obj) ? $f : '';
			}
		}
		return $arr;
	}

	protected function addValidateJs($js = null){
		$arr = Controller_Admin_Files::addJs();

		$validateArr = array();

		if($arr){
			foreach($arr as $item){
				array_push($validateArr, $item);	
			}
		}
		array_push($validateArr, $js);	
		
		$this->template->scripts = array_merge($validateArr, $this->template->scripts);		
	}
}