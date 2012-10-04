<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Users extends Controller_Admin_Template {
 
    public function action_index()
	{	
        $view = View::factory('admin/users/list')
            ->bind('message', $message);
        $view->userinfosList = ORM::factory('userInfo')->order_by('nome','ASC')->find_all();
        $this->template->content = $view;    
        
        //Utils_Helper::debug(ORM::factory('user')->where('username','=','teste')->find_all());
	} 
        
    protected function addValidateJs(){
        $scripts =   array(
            "public/js/admin/validateUsers.js",
        );
        $this->template->scripts = array_merge( $scripts, $this->template->scripts );
    }

	public function action_delete($inId)
    {
        try 
        {            
            $userinfo = ORM::factory('userInfo', $inId);
            $user = ORM::factory('user', $userinfo->user_id);
            $userinfo->delete();
            $user->delete();
            $message = "Usuário excluído com sucesso.";
            Utils_Helper::mensagens('add',$message); 
            Request::current()->redirect(URL::base().'admin/users');
        } catch (ORM_Validation_Exception $e) {
            $message = 'Houveram alguns erros na validação dos dados.';
            $errors = $e->errors('models');
            Utils_Helper::mensagens('add',$message); 
        }
    }

	public function action_edit($id)
    {
        $view = View::factory('admin/users/create')
            ->bind('errors', $errors)
            ->bind('message', $message)
            ->set('values', $this->request->post());

        $this->addValidateJs();
        $view->userinfo = ORM::factory('userInfo', $id);
        $view->user = ORM::factory('user',$view->userinfo->user_id);
        $view->teamsList = ORM::factory('team')->find_all();
        $view->isUpdate = 1;
        $this->template->content = $view;
        
        if (HTTP_Request::POST == $this->request->method()) 
        {                                              
            $this->salvar($id);
        }             
    }
        
    public function action_create()
    {
        $view = View::factory('admin/users/create')
            ->bind('errors', $errors)
            ->bind('message', $message)
            ->set('values', $this->request->post());

        $this->addValidateJs();
        $view->teamsList = ORM::factory('team')->find_all();
        $this->template->content = $view;

        if (HTTP_Request::POST == $this->request->method()) 
        {                                              
            $this->salvar(); 
        }             
    }

    protected function salvar($id = null)
    {
        $db = Database::instance();
        $db->begin();
        try 
        {   
            if(!$id)
            {
                $user = ORM::factory('user')->create_user($this->request->post(), array(
                    'username',
                    'password'          
                ));           	
            }                
                                         
            $userinfo = ORM::factory('userInfo', $id)->values($this->request->post(), array(
                'nome',
                'email',
                'data_aniversario',
                'ramal',
                'telefone'
            ));
            if($user){
            	$userinfo->user_id = $user->id;
            }
            
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
            if($this->request->post('role')!='')
            {
                $user = ORM::factory('user',$userinfo->user_id);

                $user->remove('roles');
                $user->add('roles', ORM::factory('role', array('name' => 'login')));
                $user->add('roles', ORM::factory('role', array('id' => $this->request->post('role'))));            
            }
            
            /* Fluxo para gravar a equipe*/
            if($this->request->post('team')!='')
            {
                $userinfo->remove('team');
                $userinfo->add('team', ORM::factory('team', array('id' => $this->request->post('team'))));            
            }
            
            $message = "Contato '{$userinfo->nome}' salvo com sucesso.";
            
            Utils_Helper::mensagens('add',$message);
            $db->commit();
            
            return $userinfo;
            Request::current()->redirect(URL::base().'admin/users');

        } catch (ORM_Validation_Exception $e) {
            $message = 'Houveram alguns erros';
            $errors = $e->errors('models');
            //print_r($errors);
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
            $message = 'Houveram alguns erros: '.$e->getMessage();
            Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

        return false;
    }
    
     
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
                Request::current()->redirect('admin/home');
            } 
            else
            {
                $message = 'Login failed';
            	var_dump($message);
            }
        }
    }
     
    public function action_logout() 
    {
        // Log user out
        Auth::instance()->logout();
         
        // Redirect to login page
        Request::current()->redirect('login');
    }
    
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
        $userList = $team->user->find_all();
        foreach($userList as $userinfo){
            $dado = array('id'=>$userinfo->user->id,'nome'=>$userinfo->nome);
            array_push($dados,$dado);
        }
        $arr = array('dados'=>$dados);
        print $callback.json_encode($arr);
        exit;
    } 
 
}