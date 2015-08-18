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
	}
	
    public function action_index($ajax = null)
	{	
        $view = View::factory('admin/users/list')
            ->bind('message', $message);
        
        $view->filter_nome = ($this->request->post('nome') != "") ? $this->request->post('nome') : "";
        $view->filter_email = ($this->request->post('email') != "") ? $this->request->post('email') : "";
		$view->current_auth = $this->current_auth;    

        if($ajax == null){
            //$this->template->content = $view;             
        }else{
            $this->auto_render = false;
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
                    //array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_edit($this->current_user->userInfos->id, true)->render())),
                )                       
            );
            return false;
        }  	
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
                    //array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_edit($this->current_user->userInfos->id, true)->render())),
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
    		
            $view->anexosView = View::factory('admin/files/anexos');
    				
    		
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
	public function action_editInfo(){
        $this->auto_render = false;
        /*
        header('Content-Type: application/json');
        echo json_encode(array(
            'content' => URL::base().'admin/users/index/ajax',              
            'direita' => URL::base().'admin/users/edit/'.$this->current_user->userInfos->id, 
        ));
        */

        header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => '#content', 'type'=>'url', 'content'=> URL::base().'admin/users/index/ajax'),
                
            )                       
        );
        
        return false;   
	}
	
	/*
	* Alterar senha *
	*/
	public function action_editPass(){
        $this->auto_render = false;
		$view = View::factory('admin/users/edit_login');
		
		$view->bind('errors', $errors)
            ->bind('message', $message);
		
		$view->userInfoVO = $this->setVO('user', $this->current_user);

        header('Content-Type: application/json');
        echo json_encode(
            array(
                array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($view->render())),                    
            )                       
        );


        return false;		
	}

    public function action_savePass(){
        $this->auto_render = false;
        if($this->request->post('password')!== ''){             
            $this->current_user->values($this->request->post(), array(
                'username',
                'password'          
            ))->save();
            
            $msg = "senha alterada com sucesso.";
        }else{
            $msg = "ocorreu um erro";
        }

        header('Content-Type: application/json');
        echo json_encode(   
            array(
                array('container' => '#direita', 'type'=>'url', 'content'=> URL::base().'admin/users/index/ajax'),
                array('type'=>'msg', 'content'=> $msg),
                                    
            )                       
        );


        return false;
    }
      
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
                'foto',
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



            //echo '{"status":"error"}';

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
                array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getUsers("", true)->render())),
                array('container' => '#direita', 'type'=>'html', 'content'=> json_encode($this->action_edit($userInfo_id, true)->render())),
                array('type'=>'msg', 'content'=> $msg),
            )                       
        );
        
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

        /*
        if (Auth::instance()->logged_in())
        {
            // User is logged in, continue on
        }
        else
        {
            // User isn't logged in, redirect to the login form.
        }
        */
		
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
    public function action_getUsers($status_id, $ajax = null){
        $this->auto_render = false;
        $view = View::factory('admin/users/table');

        $status_id = ($status_id != "") ? $status_id : Session::instance()->get('kaizen')['parameters'];


        if(count($this->request->post()) > '0' || Session::instance()->get('kaizen')['model'] != 'users'){
            $kaizen_arr = Utils_Helper::setFilters($this->request->post(), $status_id, "users");
        }else{
            $kaizen_arr = Session::instance()->get('kaizen');
        }

        Session::instance()->set('kaizen', $kaizen_arr);    

        //$this->startProfilling();

        $filtros = Session::instance()->get('kaizen')['filtros'];
        foreach ($filtros as $key => $value) {
            $view->$key = json_decode($value);
        }

        $query = ORM::factory('userInfo');

        /***Filtros***/
        (isset($view->filter_search)) ? $query->where_open()->where('nome', 'LIKE', '%'.$view->filter_search.'%')->or_where('email', 'LIKE', '%'.$view->filter_search.'%')->where_close() : '';
        $view->userinfosList = $query->where('status', '=', $status_id)->order_by('nome','ASC')->find_all();
        
        // $this->endProfilling();
        if($ajax != null){
            return $view;
        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
                )                       
            );
           
            return false;
        }
    }    
 
}