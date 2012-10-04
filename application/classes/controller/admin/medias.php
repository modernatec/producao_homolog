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
        
        protected function addValidateJs(){
            $scripts =   array(
                "public/js/admin/validateMedias.js",
            );
            $this->template->scripts = array_merge( $scripts, $this->template->scripts );
        }
        
        protected function addPlupload(){
            $scripts =   array(
                //"http://bp.yahooapis.com/2.4.21/browserplus-min.js",
                "public/plupload/js/plupload.js",
                /*"public/plupload/js/plupload.gears.js",
                "public/plupload/js/plupload.silverlight.js",
                "public/plupload/js/plupload.flash.js",
                "public/plupload/js/plupload.browserplus.js",
                "public/plupload/js/plupload.html4.js",*/
                "public/plupload/js/plupload.html5.js",
                "public/plupload/init.js",
            );
            $this->template->scripts = array_merge( $scripts, $this->template->scripts );
        }
        
	public function action_index()
	{	
            $view = View::factory('admin/medias/list')
                ->bind('message', $message);
            $view->tags = ORM::factory('media')->group_by('tag')->order_by('tag','ASC')->find_all()->as_array('id','tag');
            $view->mediasList = array();
            foreach($view->tags as $tag){
                $view->mediasList[$tag] = ORM::factory('media')->where('tag','=',$tag)->order_by('uri','ASC')->find_all();
            }
            
            $this->template->content = $view;             
	} 

	public function action_create()
        { 
            $view = View::factory('admin/medias/create')
                ->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());
            
            $this->addPlupload();
            $this->addValidateJs();
            
            $this->template->content = $view;

            if (HTTP_Request::POST == $this->request->method()) 
            {           
                $filesUploads = $this->request->post('filesUploads');
                $mimeUploads = $this->request->post('mimeUploads');
                $tag = $this->request->post('tag');
                if($filesUploads!='')
                {
                    $arrFiles = explode(',',$filesUploads);
                    $arrMimes = explode(',',$mimeUploads);
                    $basedir = 'public/plupload/temporario/';
                    $newbasedir = 'public/upload/medias/';
                    foreach($arrFiles as $k=>$file){
                        if($file!='empty'){
                            $size = filesize($basedir.$file);

                            $this->salvar($newbasedir.$file,$arrMimes[$k],$size,$tag);

                            rename($basedir.$file, $newbasedir.$file);
                        }
                    }
                }
                Request::current()->redirect(URL::base().'admin/medias');
            }    
	}
        
        public function action_delete($inId)
        {
            $view = View::factory('admin/medias/list')
            ->bind('errors', $errors)
            ->bind('message', $message);
                       
            $media = ORM::factory('media', $inId);
            $media->delete();
            $message = "Media excluída com sucesso.";
            
            $view->tags = ORM::factory('media')->group_by('tag')->order_by('tag','ASC')->find_all()->as_array('id','tag');
            $view->mediasList = array();
            foreach($view->tags as $tag){
                $view->mediasList[$tag] = ORM::factory('media')->where('tag','=',$tag)->order_by('uri','ASC')->find_all();
            }
            $this->template->content = $view;
            Utils_Helper::mensagens('add',$message); 
        }

        public static function salvar($uri,$type,$size,$tag)
        {
            $arquivo = ORM::factory('media');
            $arquivo->uri = $uri;
            $arquivo->tag = $tag;
            $arquivo->mime_type = $type;
            $arquivo->size = $size;
            $arquivo->user_id = Auth::instance()->get_user()->id;
            $arquivo->save();
        }
        
        public function action_download($id)
	{	
            ini_set('memory_limit','500M'); 
            $media = ORM::factory('media',$id);
            if(file_exists($media->uri))
            {
                header('Content-disposition: attachment; filename='.basename($media->uri));
                header('Content-type: '.$media->mime_type);
                header('Content-Length: '.$media->size);
                readfile($media->uri); 
            }else{
                print "<h1>Arquivo não encontrado!</h1>";
            }
            exit;
	}
        
        public function action_alterartag($str)
        {
            if(in_array('coordenador', $this->user->roles->find_all()->as_array('id','name'))){                
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
}