<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Medias extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array(
										'create' => array('login', 'coordenador'),
										'delete' => array('login', 'coordenador'),
                                   );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	protected function addValidateJs($arr){
		$scripts =   array(
			"public/js/admin/validateMedias.js",
		);
		
		if($arr){
			foreach($arr as $item){
				array_push($scripts, $item);	
			}
		}
		
		$this->template->scripts = array_merge( $scripts, $this->template->scripts );
	}
        
	public function action_index()
	{	
		$view = View::factory('admin/medias/list')
			->bind('message', $message);
		$view->tags = ORM::factory('media')->group_by('tag')->order_by('tag','ASC')->find_all();		
		$this->template->content = $view;             
	} 

	public function action_create()
	{ 
		$view = View::factory('admin/medias/create')
			->bind('errors', $errors)
			->bind('message', $message)
			->set('values', $this->request->post());
		
		$this->addValidateJs(Controller_Admin_Files::addJs());
		$view->mediaVO = $this->setVO('media');
		$view->anexosView = View::factory('admin/files/anexos');
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar();
		}    
	}
	
	public function action_edit($id)
	{ 
		$view = View::factory('admin/medias/create')
			->bind('errors', $errors)
			->bind('message', $message);
		
		$this->addValidateJs(Controller_Admin_Files::addJs());
		$media = ORM::factory('media', $id);
		
		$view->mediaFiles = $media->getFiles($id);
		$view->mediaVO = $this->setVO('media', $media);
		
		$view->anexosView = View::factory('admin/files/anexos');
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar($id);
		}    
	}
	
       
	protected function salvar($id)
	{
		$media = ORM::factory('media', $id);
		$media->tag = $this->request->post('tag');
		$media->userInfo_id = $this->current_user->userInfos->id;
		$media->save();
				
		$folder = 'public/upload/medias/';
		Controller_Admin_Files::salvar($this->request, $folder, $media->id, "media", $this->current_user);
		
		Request::current()->redirect('admin/medias/edit/'.$media->id);		
	}
	
	public function action_alterartag($str)
	{
		if($this->current_auth == 'coordenador' || $this->current_auth == 'admin'){                
			list($old_tag,$new_tag) = explode("@@@",$str);
			if($old_tag!='' && $new_tag!=''){
				$q = DB::query(Database::UPDATE,'UPDATE `producao`.`moderna_media` SET `tag`="'.$new_tag.'" WHERE `tag`="'.$old_tag.'"');
				print $q->execute();
			}else{
				print 'ERR';
			}
		}else{
			print 'DENIED';
		}
		exit;
	}
	
	public function action_delete($inId)
	{
		try {            
			$media = ORM::factory('media', $inId);
			$media->delete();
			$message = "Media excluída com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$message = 'Houveram alguns erros. Veja à seguir:';
			$errors = $e->errors('models');
		}
		
		Utils_Helper::mensagens('add',$message); 
		Request::current()->redirect('admin/medias');
	}

}