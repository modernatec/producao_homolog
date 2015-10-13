<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Users extends Controller_Admin_Template {
 
 	//public $auth_required		= array('login'); //Auth is required to access this controller
 	
	public $secure_actions     	= array(
                                    'index' => array('login'),
									'edit' => array('login'),
									'delete' => array('login', 'admin'),
									'create' => array('login', 'admin'),	
                                    'inativate'	=> array('login', 'admin'),  									
								  );	
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);  
        //var_dump($this->request->action());   
	}
	
    public function action_index()
	{	
        $this->auto_render = false;
        $view = View::factory('admin/users/list')->bind('message', $message);        

        header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
                array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getUsers(true)->render())),                
                array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
            )                       
        );
        return false;
	} 

    public function action_view($uid){
        $this->auto_render = false;
        $view = View::factory('admin/users/view');  
        $view->user = ORM::factory('userInfo', $uid);
        $view->current_auth = $this->current_auth;
        $view->current_user = $this->current_user;

        $container = $this->request->post('container');

        header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => $container, 'type'=>'html', 'content'=> json_encode($view->render())),
            )                       
        );
        return false;
    }
        
	/*
    * Editar usuarios *
    */
	public function action_edit($userInfo_id, $ajax = null)
    {
        $this->auto_render = false;
        if($userInfo_id != $this->current_user->userInfos->id && $this->current_auth != "admin"){
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('type'=>'msg', 'content'=> 'Você não tem permissão para alterar as infos deste usuário.' ),
                )                       
            );
        }else{	
   			$view = View::factory('admin/users/edit');        	            
    		$view->bind('errors', $errors)
                ->bind('message', $message);
    		
            $view->current_auth = $this->current_auth;      
            $userInfo = ORM::factory('userInfo', $userInfo_id);
    		$view->teamsList = ORM::factory('team')->find_all();
    		$view->rolesList = ORM::factory('role')->where('id', ">", "1")->order_by('name', 'ASC')->find_all();
    		
            //$view->anexosView = View::factory('admin/files/anexos');
    				    		
    		$roles = $userInfo->user->roles->find_all();
            $roles_arr = array();
    		foreach($roles as $roleObj){
                if($roleObj->id != '1'){
        			array_push($roles_arr, $roleObj->id);
                }
    		}	
    		
            $view->usuario = $userInfo;
    		$view->userInfoVO = $this->setVO('userInfo', $userInfo);
    		$view->userInfoVO['data_aniversario'] = (isset($values)) ? Arr::get($values, 'data_aniversario') : Utils_Helper::data($userInfo->data_aniversario, 'd/m');
            $view->userInfoVO['role_id'] = (isset($values)) ? Arr::get($values, 'role_id') : $roles_arr;
    		$view->userInfoVO['username'] = (isset($values)) ? Arr::get($values, 'username') : $userInfo->user->username;

            if($ajax != null){
                return $view;
            }else{
                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($view->render())),
                    )                       
                );
            }
            return false;
        }		
    }

    /*
    * Criar usuarios *
    */   
    public function action_create()
    {
        $this->auto_render = false;
        $view = View::factory('admin/users/create')
            ->bind('errors', $errors)
            ->bind('message', $message);

        $view->teamsList    = ORM::factory('team')->find_all();
        $view->rolesList    = ORM::factory('role')->where('id', ">", "1")->order_by('name', 'ASC')->find_all();
        $view->userInfoVO   = $this->setVO('userInfo');
        $view->anexosView = View::factory('admin/files/anexos');
        //$this->template->content = $view;
        header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($view->render())),
            )                       
        );        
    }


	
	/*
	* Alterar infos cadastrais do user logado *
	*/
	public function action_edituser($uid, $ajax = null){
        $this->auto_render = false;
        
        $view = View::factory('admin/users/userinfos');
        $view->user = ORM::factory('userInfo', $uid);

        if($ajax != null){
            return $view;
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
                    
                )                       
            );
            
            return false;   
        }
	}

    public function action_getinfo($userInfo_id, $ajax = null)
    {
        $this->auto_render = false;
        $view = View::factory('admin/users/edit_info');                      
        $view->bind('errors', $errors)
            ->bind('message', $message);
        
        $view->current_auth = $this->current_auth;      
        $userInfo = ORM::factory('userInfo', $userInfo_id);
        
        $view->userInfoVO = $this->setVO('userInfo', $userInfo);
        $view->userInfoVO['data_aniversario'] = (isset($values)) ? Arr::get($values, 'data_aniversario') : Utils_Helper::data($userInfo->data_aniversario, 'd/m');
        
        if($ajax != null){
            return $view;
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
                )                       
            );
        }
        return false;
    }
	
	public function action_editPass($uid, $ajax = null){
        $this->auto_render = false;
		$view = View::factory('admin/users/edit_login')->bind('errors', $errors)->bind('message', $message);
		
        $user = ORM::factory('user', $uid);
		$view->userInfoVO = $this->setVO('user', $user);
        $container = $this->request->post('container');

        if($ajax != null){
            return $view;
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => $container, 'type'=>'html', 'content'=> json_encode($view->render())),                    
                )                       
            );

            return false;	
        }	
	}

    public function action_savePass($uid){
        $this->auto_render = false;
        $container = $this->request->post('container');

        if($this->request->post('password')!== ''){ 
            $user = ORM::factory('user', $uid);
                        
            $user->values($this->request->post(), array(
                'username',
                'password'          
            ));
            $user->save();
            
            $msg = "senha alterada com sucesso.";
        }else{
            $msg = "ocorreu um erro";
        }

        header('Content-Type: application/json');
        echo json_encode(   
            array(
                array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_editPass($uid, true)->render())), 
                array('type'=>'msg', 'content'=> $msg),
                                    
            )                       
        );


        return false;
    }

    public function action_salvarinfos($userInfo_id = null)
    {
        $this->auto_render = false;
        $db = Database::instance();
        $db->begin();
        
        try 
        {   
            $userinfo = ORM::factory('userInfo', $userInfo_id)->values($this->request->post(), array(
                'nome',
                'email',
                'data_aniversario',
                'ramal',
                'telefone',   
                'foto',             
            ));     
            
            /*             
            $foto = Controller_Admin_Files::salvar($this->request, "public/upload/userinfos/", $userinfo->user_id, "userinfos", $this->current_user, 150);         
            
            if($foto){
                $userinfo->foto = $resposta[0];
            }
            */

            $userinfo->save();
            
            
            $db->commit();
            $msg = "Usuário salvo com sucesso.";
        } catch (ORM_Validation_Exception $e) {
            $msg = 'Houveram alguns erros';
            $errors = $e->errors('models');
            
            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros <br/><br/>'.$e->getMessage();
            
            $db->rollback();
        }


        header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getinfo($userInfo_id, true)->render())),        
                array('type'=>'msg', 'content'=> $msg),
            )                       
        );
        
        return false;   
    }

    public function action_salvar($userInfo_id = null)
    {
        $this->auto_render = false;
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
				'telefone',
                'status',
			));		
			
			$user = ORM::factory('user', $userinfo->user_id);	
			
            /* Criando usuários */
			if(!$userInfo_id){
                $user->values($this->request->post(), array(
                    'username',
                    'password'          
                ));
                $user->save();
            }
			
			$userinfo->user_id = $user->id;

            $foto = Controller_Admin_Files::salvar($this->request, "public/upload/userinfos/", $userinfo->user_id, "userinfos", $this->current_user, 150);         
            
            if($foto){
                $userinfo->foto = $resposta[0];
            }

            $userinfo->save();
			
            /* Fluxo para dar as permissões */
            if($this->request->post('role_id')!== '')
            {
                $user->remove('roles');
                $user->add('roles', ORM::factory('role', array('name' => 'login')));
                foreach ($this->request->post('role_id') as $role_id) {
                    $user->add('roles', ORM::factory('role', array('id' => $role_id)));                                
                }
            }            
            
			$db->commit();
            $msg = "Usuário salvo com sucesso.";
        } catch (ORM_Validation_Exception $e) {
            $msg = 'Houveram alguns erros';
            $errors = $e->errors('models');

            if($errors['username']){
                $msg .= '<br/><br/>'.$errors['username'];
            }
            if($errors['_external']){
                if($errors['_external']['password']){
                    $msg .= '<br/><br/>'.$errors['_external']['password'];
                }
            }
            
            $db->rollback();
        } catch (Database_Exception $e) {
            $msg = 'Houveram alguns erros <br/><br/>'.$e->getMessage();
            
            $db->rollback();
        }


        header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getUsers(true)->render())),
                array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_edit($userInfo_id, true)->render())),
                array('type'=>'msg', 'content'=> $msg),
            )                       
        );
        
        return false;   
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
        $this->auto_render = false;
        $view = View::factory('admin/login')->bind('message', $message);

        echo $view;
		    
        if (HTTP_Request::POST == $this->request->method()) 
        {
            // Attempt to login user
            $remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : TRUE;
            $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);
			
            // If successful, redirect user
            if ($user) 
            {
                if (Auth::instance()->logged_in("editor 1")){
                    Request::current()->redirect('admin/#acervo/index/ajax');
                }else{
                    Request::current()->redirect('admin/#tasks/index/ajax');
                }
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
        Session::instance()->delete('kaizen');
         
        // Redirect to login page
        Request::current()->redirect('login');
    }

    /********************************/
    public function action_upload($user_id){
        $this->auto_render = false;
        // A list of permitted file extensions
        $allowed = array('png','jpg', 'jpeg', 'gif','zip');

        if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if(!in_array(strtolower($extension), $allowed)){
                echo '0';
                exit();
            }

            $file = 'public/upload/userinfos/profile'.$user_id.'.'.$extension;

            if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){
                $image = Image::factory($file);
                $image->resize(NULL, '100');
                $image->save();
                chmod($file, 0777);

                echo $file;
                exit();
            }
        }else{
            echo '0';
            exit();
        }
    }  

    public function getFiltros(){
        $this->auto_render = false;
        $viewFiltros = View::factory('admin/users/filtros');

        $filtros = Session::instance()->get('kaizen')['filtros'];

        $viewFiltros->filter_team = array();
        
        if(!isset($viewFiltros->filter_status)){
            $viewFiltros->filter_status = array('1');
        }

        $viewFiltros->teamList = ORM::factory('team')->order_by('name', 'ASC')->find_all();

        foreach ($filtros as $key => $value) {
            $viewFiltros->$key = json_decode($value);
        }

        return $viewFiltros;
    }

    public function action_getUsers($ajax = null){
        $this->auto_render = false;
        $view = View::factory('admin/users/table');
        $view->current_auth = $this->current_auth;

        if(count($this->request->post()) > '0' || Session::instance()->get('kaizen')['model'] != 'users'){
            $kaizen_arr = Utils_Helper::setFilters($this->request->post(), '', "users");
        }else{
            $kaizen_arr = Session::instance()->get('kaizen');
        }

        Session::instance()->set('kaizen', $kaizen_arr);    

        //$this->startProfilling();

        $filtros = Session::instance()->get('kaizen')['filtros'];
        foreach ($filtros as $key => $value) {
            $view->$key = json_decode($value);
        }

        if(!isset($view->filter_status)){
            $view->filter_status = array('1');
        }

        $query = ORM::factory('userInfo');

        /***Filtros***/
        (isset($view->filter_search)) ? $query->where_open()->where('nome', 'LIKE', '%'.$view->filter_search.'%')->or_where('email', 'LIKE', '%'.$view->filter_search.'%')->where_close() : '';
        (isset($view->filter_status)) ? $query->and_where('status', 'IN', $view->filter_status) : '';
        $view->userinfosList = $query->order_by('nome','ASC')->find_all();
        
        // $this->endProfilling();
        if($ajax != null){
            return $view;
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
                    array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
                )                       
            );
           
            return false;
        }
    }   

    /*
    * Mostrar aniversariantes *
    
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
    */

    /*
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
    */
    
    /*
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
    } */ 
 
}