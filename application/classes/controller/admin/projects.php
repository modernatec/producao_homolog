<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Projects extends Controller_Admin_Template {
 
	public $auth_required		= array('login', 'admin');
 	
	/*
	public $secure_actions     	= array(
								   	'create' => array('login', 'coordenador'),
									'edit' => array('login', 'coordenador'),
								   	'delete' => array('login', 'coordenador'),
								 );
	*/
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	protected function addValidateJs(){
		$scripts =   array(
			"public/js/admin/validateProjects.js",
		);
		$this->template->scripts = array_merge( $scripts, $this->template->scripts );
	}
        
	public function action_index()
	{	
		$view = View::factory('admin/projects/list')
			->bind('message', $message);
		
		$view->projectsList = ORM::factory('project')->order_by('name','ASC')->find_all();
		$this->template->content = $view;    
	} 

	public function action_create()
    { 
		$view = View::factory('admin/projects/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs();
		$view->isUpdate = false;
		
		$view->projectVO = $this->setVO('project');		
		$view->segmentosList = ORM::factory('segmento')->find_all();
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar();
		}    
	}

	public function action_edit($id)
    {        
		$view = View::factory('admin/projects/create')
				->bind('errors', $errors)
				->bind('message', $message);
	
		$this->addValidateJs();
		$view->isUpdate = true;
				
		$projeto = ORM::factory('project', $id);
		$view->projectVO = $this->setVO('project', $projeto);
		$view->segmentosList = ORM::factory('segmento')->find_all();
		$this->template->content = $view;	
	   
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
			$this->salvar($id); 
		} 
	}

	protected function salvar($id = null)
	{
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$projeto = ORM::factory('project', $id)->values($this->request->post(), array(
				'name',
				'segmento_id',
				'description'
			));
			                
			if(!$id)
			{
				$pastaProjeto = Utils_Helper::limparStr($projeto->name);
				$basedir = 'public/upload/projetos/';
				$rootdir = DOCROOT.$basedir;
				
				if(!file_exists($rootdir.$pastaProjeto)){
					mkdir($rootdir.$pastaProjeto,0777);
				}
				$projeto->pasta = $pastaProjeto;                    
			}
			
			$projeto->save();
			
			Utils_Helper::mensagens('add','Projeto '.$projeto->name.' salvo com sucesso.');
			Request::current()->redirect('admin/projects');

		} catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
			$erroList = '';
			foreach($errors as $erro){
				$erroList.= $erro.'<br/>';	
			}
            $message = 'Houveram alguns erros na validação <br/><br/>'.$erroList;

		    Utils_Helper::mensagens('add',$message);    
            $db->rollback();
        } catch (Database_Exception $e) {
            $message = 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
            Utils_Helper::mensagens('add',$message);
            $db->rollback();
        }

        return false;
	}
	
	public function action_delete($id)
	{
		$view = View::factory('admin/projects/list')
			->bind('errors', $errors)
			->bind('message', $message);
		/*
		try 
		{            
			$projeto = ORM::factory('project', $id);
			$projeto->delete();
			Utils_Helper::mensagens('add','Projeto excluído com sucesso.'); 
		} catch (ORM_Validation_Exception $e) {
			Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$errors = $e->errors('models');
		}
		*/
		Request::current()->redirect('admin/projects');
	}
}