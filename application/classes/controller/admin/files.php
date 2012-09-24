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
        
 	
	public static function subir($file,$task)
        {
            $erro = array(
                1=>'Tipo incorreto de arquivo',
                2=>'Erro ao fazer o upload do arquivo',
                3=>'Upload concluído com sucesso.'
            );
            
            if(Upload::type($file,array('doc','docx','ppt','pptx','xls','xlsx','zip','rar','pdf','txt')))
            {
                $fName = Utils_Helper::limparStr($file['name']);
                $basedir = 'public/upload/'.$task->pasta.'/';
                $rootdir = DOCROOT.$basedir;
                $ext = explode(".",$fName);
                $ext = end($ext);                
                $nomeArquivo = str_replace(".$ext","",$fName);

                $fileName = $nomeArquivo.'_'.(time()).'.'.$ext;
                if(Upload::save($file,$fileName,$rootdir,0777))
                {
                    $arquivo = ORM::factory('file');
                    $arquivo->uri = $basedir.$fileName;
                    $arquivo->task_id = $task->id;
                    $arquivo->mime_type = $file['type'];
                    $arquivo->size = $file['size'];
                    $arquivo->user_id = Auth::instance()->get_user()->id;
                    $arquivo->save();

                    return $erro[3];
                }else
                {
                    return $erro[2];
                }
            }else
            {
                return $erro[1];
            }
        }

	public static function listar($taskId)
        {
            return ORM::factory('file')->where('task_id','=',$taskId)->find_all();   
        }
        
        public function action_download($id)
	{	
            $file = ORM::factory('file',$id);
            header('Content-disposition: attachment; filename='.basename($file->uri));
            header('Content-type: '.$file->mime_type);
            readfile($file->uri);          
	}
}