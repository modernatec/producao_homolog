<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Curriculums extends Controller_Admin_Template {
 
	public $auth_required		= array('login'); //Auth is required to access this controller
 
	public $secure_actions     	= array(
								   	'create' => array('login', 'coordenador'),
									'edit' => array('login', 'coordenador'),
								   	'delete' => array('login', 'coordenador'),
								 );
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	protected function addValidateJs($arr = null){
		$scripts =   array(
			"public/js/admin/validateCurriculums.js",
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
		$view = View::factory('admin/curriculums/list')
			->bind('message', $message);
		$view->curriculumsList = ORM::factory('curriculum')->order_by('name','ASC')->find_all();
		$this->template->content = $view;             
	} 

	public function action_create()
	{ 
		$view = View::factory('admin/curriculums/create')
			->bind('errors', $errors)
			->bind('message', $message);

		$this->addValidateJs(Controller_Admin_Files::addJs());

		$view->isUpdate = false;  
		$view->curriculumVO = $this->setVO('curriculum');
		$view->anexosView = View::factory('admin/files/anexos');
		$this->template->content = $view;

		if (HTTP_Request::POST == $this->request->method()) 
		{           
			$this->salvar();
		}
	}

	public function action_edit($id)
	{
		$view = View::factory('admin/curriculums/create')
			->bind('errors', $errors)
			->bind('message', $message);
		
		$this->addValidateJs(Controller_Admin_Files::addJs());
		$view->isUpdate = true;
		$view->anexosView = View::factory('admin/files/anexos');
		$curriculum = ORM::factory('curriculum', $id);
		$view->curriculumVO = $this->setVO('curriculum', $curriculum);
		$view->curriculumVO["file"] = ORM::factory('file')->where('model', '=', 'curriculum')->and_where('model_id', '=', $id)->find_all();
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
			$curriculum = ORM::factory('curriculum', $id)->values($this->request->post(), array(
				'name',
				'objective',
				'description'
			)); 
			
			$curriculum->save();
			Controller_Admin_Files::salvar($this->request, "public/upload/curriculum/", $curriculum->id, "curriculum", $this->current_user);			
			$db->commit();
			
			$message = "Curriculum '{$curriculum->name}' salvo com sucesso.";
			Utils_Helper::mensagens('add',$message);
			Request::current()->redirect('admin/curriculums');

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
        
    
	
	public function action_delete($inId)
	{
		try 
		{            
			$curriculum = ORM::factory('curriculum', $inId);
			$curriculum->delete();
			$message = "Curriculum excluído com sucesso.";
		} catch (ORM_Validation_Exception $e) {
			$message = 'Houveram alguns erros na validação dos dados.';
			$errors = $e->errors('models');
		}
		Utils_Helper::mensagens('add',$message); 
		Request::current()->redirect('admin/curriculums');
	}
}