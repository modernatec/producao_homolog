<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Files extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array('post' => array('login','admin','coordenador', 'assistente'),
								   'edit' => array('login','admin'),
								   'delete' => array('login','admin'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
	
	public static function addJs(){
		/*
		return array(
			"public/plupload/js/plupload.js",
			"public/plupload/js/plupload.html5.js",
			"public/plupload/init.js",
		);
		*/
	}
        
	public static function salvar($request, $pasta, $model_id, $model, $user, $width = null)
	{
		$erro = array(
			1=>'Tipo incorreto de arquivo',
			2=>'Erro ao fazer o upload do arquivo',
			3=>'Upload concluído com sucesso.'
		);

		$uploadedFiles = array();
		
		$basedir = 'public/plupload/temporario/';
		$filesUploads = $request->post('filesUploads');
        $mimeUploads = $request->post('mimeUploads');
        if($filesUploads!='')
        {
			$arrFiles = explode(',',$filesUploads);
			$arrMimes = explode(',',$mimeUploads);
			//$newbasedir = 'public/upload/'.$pastaProjeto.'/'.$task->pasta.'/';
			foreach($arrFiles as $k=>$file){
				if($file!='empty'){
					$size = filesize($basedir.$file);
					
					$arquivo = ORM::factory('file');
					$arquivo->uri = $pasta.$file;
					$arquivo->model = $model;
					$arquivo->model_id = $model_id;
					$arquivo->mime_type = $arrMimes[$k];
					$arquivo->size = $size;
					$arquivo->userInfo_id = $user->userInfos->id;
					$arquivo->save();
					
					rename($basedir.$file, $pasta.$file);

					if($width != ''){
						$image = Image::factory($pasta.$file);
						$image->resize(NULL, $width);
						$image->crop($width, $width);
						$image->save();
					}

					array_push($uploadedFiles, $arquivo->uri);
				}
			}
		}

		return $uploadedFiles;
		
		/*
		if(Upload::type($file,array('doc','docx','ppt','pptx','xls','xlsx','zip','rar','pdf','txt')))
		{
			$fName = Utils_Helper::limparStr($file['name']);
			$basedir = 'public/upload/'.$pasta.'/';
			$rootdir = DOCROOT.$basedir;
			$ext = explode(".",$fName);
			$ext = end($ext);                
			$nomeArquivo = str_replace(".$ext","",$fName);

			$fileName = $nomeArquivo.'_'.(time()).'.'.$ext;
			if(Upload::save($file,$fileName,$rootdir,0777))
			{
				self::salvar($basedir.$fileName,$file['type'],$file['size'], $model_id,$model);

				return $erro[3];
			}else
			{
				return $erro[2];
			}
		}else
		{
			return $erro[1];
		}
		*/
	}
	
	public static function listar($model_id,$model)
	{
		return ORM::factory('file')->where('model_id','=',$model_id)->and_where('model','=',$model)->find_all();   
	}
        
    public function action_download($id)
	{	
		ini_set('memory_limit','500M'); 
		$file = ORM::factory('file',$id);
		if(file_exists($file->uri))
		{
			header('Content-disposition: attachment; filename='.basename($file->uri));
			header('Content-type: '.$file->mime_type);
			header('Content-Length: '.$file->size);
			readfile($file->uri); 
		}else{
			print "<h1>Arquivo não encontrado!</h1>";
		}
		exit;
	}
        
    public function action_preview($id)
	{
		$view = View::factory('admin/pop_preview');
		$view->file = ORM::factory('file',$id);                        
		foreach(Utils_Helper::getDefaultExtPreview() as $key=>$arr){
			if(in_array(Utils_Helper::getExt($view->file->uri),$arr)){
				$view->type_preview = $key;
				break;
			}
		}
		$this->template->lightbox = $view;
	}
}