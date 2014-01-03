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


		$XLSX = new Spreadsheet();
		/*
		$data = array(
			'Users' => array(
				1 => array('ID', 'Name'),
				2 => array(1, 'Jane Doe'),
				3 => array(2, 'Fred Smith')
			),
			'Products' => array(
				1 => array('ID', 'Name'),
				2 => array(1, 'Torch'),
				3 => array(2, 'Hat')
			),
		);
		$XLSX->setData( $data, 1 );
		$XLSX->save(array('name'=>$name));
		*/
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
		$view->stepsList = array();
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

		//$json = '[{"id":14,"children":[{"id":16,"children":[{"id":18}]}]},{"id":17},{"id":15}]';
		//var_dump(json_decode($json, true));
				
		$projeto = ORM::factory('project', $id);
		$view->projectVO = $this->setVO('project', $projeto);
		$view->stepsList = ORM::factory('projects_step')->where('project_id', '=', $id)->find_all();
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
			//$stepsList = json_decode($this->request->post("list_order"), true);
			foreach ($this->request->post('passo') as $key => $value) {
				$project_step = ORM::factory('projects_step', $this->request->post('id_step')[$key]);
				$project_step->project_id = $projeto->id;
				$project_step->step = $this->request->post('passo')[$key];
				$project_step->time = $this->request->post('tempo')[$key];	
				$project_step->save();		
			}
			
			$db->commit();
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
			$steps = ORM::factory('projects_step')->where('project_id', '=', $id)->find_all();
			foreach ($steps as $step) {
				$step->delete();
			}

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

	public function action_collections($id)
    {	
        $callback = $this->request->query('callback');        
        $dados = array();
        $collectionList = ORM::factory('collection')->where('project_id', '=', $id)->find_all();
        foreach($collectionList as $collection){
            $dado = array('id'=>$collection->id,'name'=>$collection->name);
            array_push($dados,$dado);
        }
        $arr = array('dados'=>$dados);
        print $callback.json_encode($arr);
        exit;
    } 
}