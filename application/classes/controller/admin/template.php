<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Template extends Controller_Template {
 
      public $template = 'admin/template';
 
      // Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
      // Can be set to a string or an array, for example 'login' or array('login', 'admin')
      // Note that in second(array) example, user must have both 'login' AND 'admin' roles set in database
      public $auth_required = FALSE;
 
      // Controls access for separate actions
      // 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
      // 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
      public $secure_actions = FALSE;
 
 
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
				//var_dump("você nao tem acesso a este conteudo");
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
 
      /**
       * The after() method is called after your controller action.
       * In our template controller we override this method so that we can
       * make any last minute modifications to the template before anything
       * is rendered.
       */
      public function after()
      {
		if ($this->auto_render)
		{
			$styles = array(
				'public/css/common/reset.css' => 'screen',
				'public/css/admin/masterpage.css' => 'screen',
                                'public/css/admin/jGrowl.css' => 'screen',
			);
 
			$scripts = array(
				'public/javascript/common/jquery/jquery-1.5.2.min.js',
				'public/javascript/admin/admin.js',
                                'public/javascript/admin/jgrowl/jquery.ui.all.js',
                                'public/javascript/admin/jgrowl/jquery.jgrowl_minimized.js',
			);
 
			$this->template->styles 	= array_merge( $styles, $this->template->styles );
			$this->template->scripts 	= array_merge( $scripts, $this->template->scripts );
 			
		}
		
		$user 							= Auth::instance()->get_user();
                $userInfos = ORM::factory('userInfo')->where('user_id','=',$user->id)->find();
		//$this->template->header			= View::factory('admin/header');
                
		if($user){	
                        $this->template->menu = View::factory('admin/menu');
                        $this->template->menu->user = ($user) ? $user : '';
                        $this->template->menu->userInfo = ($userInfos) ? $userInfos : '';
			$user_roles = $user->roles->find_all();
			foreach($user_roles as $role){
				$this->template->menu->menuList = $role->menus->find_all();
			}
		}
                $this->template->mensagens = Utils_Helper::mensagens('print');
		//$this->template->area 			= $this->request->controller();
		//$this->template->user 			= Auth::instance()->get_user();
		parent::after();
      }
  }