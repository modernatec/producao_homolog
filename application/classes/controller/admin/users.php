<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Users extends Controller_Admin_Template {
 
 	public $auth_required		= array('login'); //Auth is required to access this controller
 	
	public $secure_actions     	= array(
									'edit' => array('coordenador'),
									'delete' => array('admin'),
									'create' => array('admin'),	
                                    'inativate'	=> array('admin'),  									
								  );	
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);                
	}
	
    public function action_index()
	{	
        $view = View::factory('admin/users/list')
            ->bind('message', $message);
        
        //$view->filter_tipo = ($this->request->post('tipo') != "") ? json_encode($this->request->post('tipo')) : json_encode(array());
        $view->filter_nome = ($this->request->post('nome') != "") ? $this->request->post('nome') : "";
        $view->filter_email = ($this->request->post('email') != "") ? $this->request->post('email') : "";
			
        $this->template->content = $view;		
	} 
        
	/*
    * Editar usuarios *
    */
	public function action_edit($userInfo_id, $view = NULL)
    {
		if(!$view)
			$view = View::factory('admin/users/create');
    	            
		$view->bind('errors', $errors)
            ->bind('message', $message);
		
        $this->addValidateJs("public/js/admin/validateUsersEdit.js");
		$userInfo = ORM::factory('userInfo', $userInfo_id);
		$view->teamsList = ORM::factory('team')->find_all();
		$view->rolesList = ORM::factory('role')->where('id', ">", "1")->order_by('name', 'ASC')->find_all();
		
        $view->anexosView = View::factory('admin/files/anexos');
		$this->template->content = $view;			
		
		$roles = $userInfo->user->roles->find_all();
        $roles_arr = array();
		foreach($roles as $roleObj){
            if($roleObj->id != '1'){
    			array_push($roles_arr, $roleObj->id);
            }
		}	
		
		$view->userInfoVO = $this->setVO('userInfo', $userInfo);
		$view->userInfoVO['data_aniversario'] = (isset($values)) ? Arr::get($values, 'data_aniversario') : Utils_Helper::data($userInfo->data_aniversario, 'd/m');
        $view->userInfoVO['role_id'] = (isset($values)) ? Arr::get($values, 'role_id') : $roles_arr;
		$view->userInfoVO['username'] = (isset($values)) ? Arr::get($values, 'username') : $userInfo->user->username;
		
		if (HTTP_Request::POST == $this->request->method())
		{                                              
            $this->salvar($userInfo_id);
        }
    }

    /*
    * Criar usuarios *
    */   
    public function action_create()
    {
        $view = View::factory('admin/users/create')
            ->bind('errors', $errors)
            ->bind('message', $message);

        $this->addValidateJs("public/js/admin/validateUsers.js");
        $view->teamsList    = ORM::factory('team')->find_all();
        $view->rolesList    = ORM::factory('role')->where('id', ">", "1")->order_by('name', 'ASC')->find_all();
        $view->userInfoVO   = $this->setVO('userInfo');
        $this->template->content = $view;

        if (HTTP_Request::POST == $this->request->method()) 
        {                                              
            $this->salvar(); 
        }             
    }
	
	/*
	* Alterar infos cadastrais do user logado *
	*/
	public function action_editInfo(){
		$view = View::factory('admin/users/edit');
		$this->action_edit($userInfo_id = $this->current_user->userInfos->id, $view);
	}
	
	/*
	* Alterar senha *
	*/
	public function action_editPass(){
		$view = View::factory('admin/users/edit_login');
		
		$view->bind('errors', $errors)
            ->bind('message', $message);
		
		$view->userInfoVO = $this->setVO('user', $this->current_user);
		$this->template->content = $view;
		
		if (HTTP_Request::POST == $this->request->method()) 
        {                                              
           	/* Atualizando usuários */
			if($this->request->post('password')!== ''){				
				$this->current_user->values($this->request->post(), array(
					'username',
					'password'          
				))->save();
				
				Utils_Helper::mensagens('add',"Senha alterada com sucesso.");
			}
			
			Request::current()->redirect('admin');
        }             
		
	}
      

    protected function salvar($userInfo_id = null)
    {
        $db = Database::instance();
        $db->begin();
		
        try 
        {   
			$userinfo = ORM::factory('userInfo', $userInfo_id)->values($this->request->post(), array(
				'nome',
				'email',
				'data_aniversario',
				'team_id',
				'ramal',
				'telefone'
			));		
			
			$user = ORM::factory('user', $userinfo->user_id);	
			/* Criando usuários */
			if(!$userInfo_id){
                $user->values($this->request->post(), array(
                    'username',
                    'password'          
                ));
            }
			
			$user->save();
			$userinfo->user_id = $user->id;

            $resposta = Controller_Admin_Files::salvar($this->request, "public/upload/userinfos/", $userinfo->user_id, "userinfos", $this->current_user, 150);         
            
            if($resposta){
                $userinfo->foto = $resposta[0];
            }


            $userinfo->save();
			
            /* Fluxo para dar as permissões*/
            if($this->request->post('role_id')!== '')
            {
                $user->remove('roles');
                $user->add('roles', ORM::factory('role', array('name' => 'login')));
                foreach ($this->request->post('role_id') as $role_id) {
                    //echo $role_id . "<br/>";
                    $user->add('roles', ORM::factory('role', array('id' => $role_id)));                                
                }
            }
            
			$db->commit();
            Utils_Helper::mensagens('add',"Usuário salvo com sucesso.");       
            
            if($this->current_auth == "assistente"){
	            Request::current()->redirect('admin');
			}else{
	            Request::current()->redirect('admin/users');
			}
			

        } catch (ORM_Validation_Exception $e) {
            $message = 'Houveram alguns erros';
            $errors = $e->errors('models');

            if($errors['username']){
                $message .= '<br/><br/>'.$errors['username'];
            }
            if($errors['_external']){
                if($errors['_external']['password']){
                    $message .= '<br/><br/>'.$errors['_external']['password'];
                }
            }
            Utils_Helper::mensagens('add',$message);    
            $db->rollback();
        } catch (Database_Exception $e) {
            $message = 'Houveram alguns erros <br/><br/>'.$e->getMessage();
            Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

        return false;
    }

    public function action_inativate($inId)
    {
        try 
        {            
            $userinfo = ORM::factory('userInfo', $inId);
            $userinfo->status = "0";
            $userinfo->save();

            Utils_Helper::mensagens('add','Usuário inativado com sucesso.');
            Request::current()->redirect('admin/users');
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
            Utils_Helper::mensagens('add','Houveram alguns erros na validação dos dados.'); 
        }
    }
	
	public function action_delete($inId)
    {

        /*
        try 
        {            
            $userinfo = ORM::factory('userInfo', $inId);
            $user = ORM::factory('user', $userinfo->user_id);
            $userinfo->delete();
            $user->delete();
            Utils_Helper::mensagens('add','Usuário excluído com sucesso.');
            Request::current()->redirect('admin/users');
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
            Utils_Helper::mensagens('add','Houveram alguns erros na validação dos dados.'); 
        }
        */
    }

    
    /*
	* Login *
	*/ 
    public function action_login() 
    {
    	$styles = array('public/css/admin/login.css' => 'screen');
    	$this->template->styles 	= array_merge( $styles, $this->template->styles );
		
        $this->template->content 	= View::factory('admin/login')->bind('message', $message);
		    
        if (HTTP_Request::POST == $this->request->method()) 
        {
            // Attempt to login user
            $remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : FALSE;
            $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);
			
            // If successful, redirect user
            if ($user) 
            {
				Request::current()->redirect('admin/tasks');
            } 
            else
            {
				Utils_Helper::mensagens('add','Usuário ou senha desconhecidos');
            }
        }
		
    }
     
	 
	/*
	* Logout *
	*/ 
    public function action_logout() 
    {
        // Log user out
        Auth::instance()->logout();
         
        // Redirect to login page
        Request::current()->redirect('login');
    }
    
	/*
	* Mostrar aniversariantes *
	*/
    public function action_aniversariantes()
    {	
        $callback = $this->request->query('callback');        
        $dados = array();
        $userList = ORM::factory('userinfo')
                ->where('data_aniversario', '=', '2000-'.date('m-d')) //'2000-'.date('m-d')
                ->order_by('nome','ASC')
                ->find_all();
        foreach($userList as $user){
            $dado = array('nome'=>$user->nome);
            array_push($dados,$dado);
        }
        $arr = array('dados'=>$dados);
        print $callback.json_encode($arr);
        exit;
    } 
    
    public function action_equipe($id)
    {	
        $callback = $this->request->query('callback');        
        $dados = array();
        $team = ORM::factory('team',$id);
        $userList = $team->userInfos->find_all();
        foreach($userList as $userinfo){
            $dado = array('id'=>$userinfo->id,'nome'=>$userinfo->nome);
            array_push($dados,$dado);
        }
        $arr = array('dados'=>$dados);
        print $callback.json_encode($arr);
        exit;
    } 

    /********************************/
    public function action_getUsers(){
        $this->auto_render = false;
        $view = View::factory('admin/users/table');

        //$this->startProfilling();

        //$view->filter_tipo = json_decode($this->request->query('tipo'));
        $view->filter_nome = $this->request->query('nome');  
        $view->filter_email = $this->request->query('email');   


        $query = ORM::factory('userInfo');

        /***Filtros***/
        //(count($view->filter_tipo) > 0) ? $query->where('typeobject_id', 'IN', $view->filter_tipo) : '';
        (!empty($view->filter_nome)) ? $query->where('nome', 'LIKE', '%'.$view->filter_nome.'%') : '';
        (!empty($view->filter_email)) ? $query->where('email', 'LIKE', '%'.$view->filter_email.'%') : '';

        $view->userinfosList = $query->order_by('nome','ASC')->find_all();
        
        // $this->endProfilling();
        echo $view;
    }    
 
}