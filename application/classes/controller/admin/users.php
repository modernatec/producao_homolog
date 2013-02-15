<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Users extends Controller_Admin_Template {
 
 	//public $auth_required		= array('login'); //Auth is required to access this controller
 	
	public $secure_actions     	= array(
									'index' => array('login'),
									'create' => array('login','coordenador'),
									'edit' => array('login','coordenador'),
									'delete' => array('login','admin'),
									'create' => array('login','admin'),											
								  );	
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);                
	}
	
	protected function addValidateJs(){
        $scripts =   array(
            "public/js/admin/validateUsers.js",
        );
        $this->template->scripts = array_merge( $scripts, $this->template->scripts );
    }
	
    public function action_index()
	{	
        $view = View::factory('admin/users/list')
            ->bind('message', $message);
			
        $view->userinfosList = ORM::factory('userInfo')->order_by('nome','ASC')->find_all();
        $this->template->content = $view;		
	} 
        
	
	public function action_edit($userInfo_id, $view = NULL)
    {
		if(!$view)
			$view = View::factory('admin/users/create');
    	            
		$view->bind('errors', $errors)
            ->bind('message', $message);
		
		$userInfo = ORM::factory('userInfo', $userInfo_id);
		$view->teamsList = ORM::factory('team')->find_all();
		$view->rolesList = ORM::factory('role')->where('id', ">", "2")->order_by('name')->find_all();
		$view->isUpdate = true;
		$this->template->content = $view;			
		
		$roles = $userInfo->user->roles->find_all();
		foreach($roles as $roleObj){
			$roleId = $roleObj->id;	
		}	
		
		$view->userInfoVO = $this->setVO('userInfo', $userInfo);
		$view->userInfoVO['data_aniversario'] = (isset($values)) ? Arr::get($values, 'data_aniversario') : Utils_Helper::data($userInfo->data_aniversario, 'd/m');
        $view->userInfoVO['role_id'] = (isset($values)) ? Arr::get($values, 'role_id') : $roleId;
		$view->userInfoVO['username'] = (isset($values)) ? Arr::get($values, 'username') : $userInfo->user->username;
		
		if (HTTP_Request::POST == $this->request->method())
		{                                              
            $this->salvar($userInfo_id);
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
      
	/*
	* Criar usuarios *
	*/   
    public function action_create()
    {
        $view = View::factory('admin/users/create')
            ->bind('errors', $errors)
            ->bind('message', $message);

        $this->addValidateJs();
        $view->teamsList 	= ORM::factory('team')->find_all();
		$view->rolesList 	= ORM::factory('role')->where('id', ">", "2")->find_all();
		$view->userInfoVO 	= $this->setVO('userInfo');
        $this->template->content = $view;

        if (HTTP_Request::POST == $this->request->method()) 
        {                                              
            $this->salvar(); 
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
			           
            $file = $_FILES['arquivo'];
            if(Upload::valid($file))
            {
                if(Upload::not_empty($file))
                {                
                    $userinfo->foto = Utils_Helper::uploadNoAssoc($_FILES['arquivo'],'userinfos');
                }
            }			
			
            $userinfo->save();
			
            /* Fluxo para dar as permissões*/
            if($this->request->post('role_id')!== '')
            {
                $user->remove('roles');
                $user->add('roles', ORM::factory('role', array('name' => 'login')));
                $user->add('roles', ORM::factory('role', array('id' => $this->request->post('role_id'))));            
            }
            
			$db->commit();
            Utils_Helper::mensagens('add',"Contato {$userinfo->nome} salvo com sucesso.");       
            
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
	
	public function action_delete($inId)
    {
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
 
}