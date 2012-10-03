<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Curriculums extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array(
								   	'edit' => array('login', 'coordenador'),
								   	'delete' => array('login', 'coordenador'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
        protected function addValidateJs(){
            $scripts =   array(
                "public/js/admin/validateCurriculums.js",
            );
            $this->template->scripts = array_merge( $scripts, $this->template->scripts );
        }
        
	public function action_index()
	{	
            $view = View::factory('admin/curriculums/list')
                ->bind('message', $message);
            $view->curriculumsList = ORM::factory('curriculum')->order_by('name','ASC')->find_all();
            $this->template->content = $view;             
	} 

	public function action_create()
        { 
            $view = View::factory('admin/curriculums/create')
                ->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());

            $this->addValidateJs();
            $this->template->content = $view;

            if (HTTP_Request::POST == $this->request->method()) 
            {           
                $this->salvar();
                //Request::current()->redirect(URL::base().'admin/projects');
            }    
	}
        
        public function action_delete($inId)
        {
            $view = View::factory('admin/curriculums/list')
            ->bind('errors', $errors)
            ->bind('message', $message);
            try 
            {            
                $curriculum = ORM::factory('curriculum', $inId);
                $curriculum->delete();
                $message = "Curriculum excluído com sucesso.";
            } catch (ORM_Validation_Exception $e) {
                $message = 'Houveram alguns erros na validação dos dados.';
                $errors = $e->errors('models');
            }
            $view->curriculumsList = ORM::factory('curriculum')->order_by('name','ASC')->find_all();
            $this->template->content = $view;
            Utils_Helper::mensagens('add',$message); 
        }

        public function action_edit($id)
        {
            
            $view = View::factory('admin/curriculums/create')
                ->bind('errors', $errors)
                ->bind('message', $message)
                ->set('values', $this->request->post());

            $view->curriculum = ORM::factory('curriculum', $id);
            $view->isUpdate = true;
            
            $this->addValidateJs();
            $this->template->content = $view;

            if (HTTP_Request::POST == $this->request->method()) 
            {                                              
                $this->salvar($id); 
                //Request::current()->redirect(URL::base().'admin/projects');
            }             
        }

        protected function salvar($id = null)
        {
            $this->template->content
                ->bind('errors', $errors)
                ->bind('message', $message);
            try 
            {            
                $curriculum = ORM::factory('curriculum', $id)->values($this->request->post(), array(
                    'name',
                    'objective',
                    'description'
                )); 
                $file = $_FILES['file'];
                if(Upload::valid($file)){
                    if(Upload::not_empty($file)){
                        $arquivo = Utils_Helper::uploadNoAssoc($file,'currirulums',array('doc','docx','pdf'));
                        if($arquivo!= 1 && $arquivo != 2){
                            $curriculum->file = $arquivo;
                        }
                    }
                }
                $curriculum->save();
                
                $message = "Curriculum '{$curriculum->name}' salvo com sucesso.";
                Utils_Helper::mensagens('add',$message);
                //return $projeto;
                Request::current()->redirect(URL::base().'admin/curriculums');

            } catch (ORM_Validation_Exception $e) {
                $message = 'Houveram alguns erros.';
                $errors = $e->errors('models');
                Utils_Helper::mensagens('add',$message);
            }
        }
        
        public function action_download($id)
	{	
            $curriculum = ORM::factory('curriculum',$id);
            if(file_exists($curriculum->file))
            {
                header('Content-disposition: attachment; filename='.basename($curriculum->file));
                header('Content-Length: '.filesize($curriculum->file));
                readfile($curriculum->file); 
            }else{
                print "<h1>Arquivo não encontrado!</h1>";
            }
            exit;
	}
}