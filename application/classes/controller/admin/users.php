<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Users extends Controller_Admin_Template {
 
    public function action_index()
	{	
        $view = View::factory('admin/users/list')
            ->bind('message', $message);
        $view->userinfosList = ORM::factory('userInfo')->order_by('nome','ASC')->find_all();
        $this->template->content = $view;             
	} 

	public function action_delete($inId)
    {
        try 
        {            
            $userinfo = ORM::factory('userInfo', $inId);
            $userinfo->delete();
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

        $view->userinfo = ORM::factory('userInfo', $id);
        $this->template->content = $view;
        $this->template->isUpdate = 1;
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

        $this->template->content = $view;

        if (HTTP_Request::POST == $this->request->method()) 
        {                                              
            $this->salvar(); 
        }             
    }

    protected function salvar($id = null)
    {
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
                'data_aniversaril',
                'ramal',
                'telefone'
            ));
            if($user){
            	$userinfo->user_id = $user->id;
            }
            
            /* Fluxo para dar as permissões*/
            if($this->request->post('role')!='')
            {
                $user = ORM::factory('user',$userinfo->user_id);

                $user->remove('roles');
                $user->add('roles', ORM::factory('role', array('name' => 'login')));
                $user->add('roles', ORM::factory('role', array('id' => $this->request->post('role'))));            
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
            	

            $message = "Contato '{$userinfo->nome}' salvo com sucesso.";
            
            Utils_Helper::mensagens('add',$message);
            return $userinfo;
            Request::current()->redirect(URL::base().'admin/users');

        } catch (ORM_Validation_Exception $e) {
            $message = 'Houveram alguns erros';
            $errors = $e->errors('models');
            Utils_Helper::mensagens('add',$message);
            print_r($errors);
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
 
}