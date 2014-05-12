<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Custos extends Controller_Admin_Template {
 
	public $auth_required = array('login', 'coordenador'); //Auth is required to access this controller
 	public $secure_actions = array(
                                    'create' => array('login', 'coordenador'),
                                    'edit' => array('login', 'coordenador'),
                                    'delete' => array('login', 'coordenador'),
                                 );
    const ITENS_POR_PAGINA = 20;
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->check_login();	
	}
	
	/*        
	public function action_index($fase = null)
	{	
		$view = View::factory('admin/objects/list')
			->bind('message', $message);
		
		$view->filter_tipo = ($this->request->post('tipo') != "") ? json_encode($this->request->post('tipo')) : json_encode(array());

		$status_init = ORM::factory('statu')->where('type', '=', 'object')->where('status', '!=', 'finalizado')->find_all(); 
		$status_arr = array();
		foreach ($status_init as $status) {
			array_push($status_arr, $status->id);
		}

		$view->filter_status = ($this->request->post('status') != "") ? json_encode($this->request->post('status')) : json_encode($status_arr);
		$view->filter_collection = ($this->request->post('collection') != "") ? json_encode($this->request->post('collection')) : json_encode(array());
		$view->filter_supplier = ($this->request->post('supplier') != "") ? json_encode($this->request->post('supplier')) : json_encode(array());

		$view->filter_origem = ($this->request->post('origem') != "") ? json_encode($this->request->post('origem')) : json_encode(array());		
		$view->filter_materia = ($this->request->post('materia') != "") ? json_encode($this->request->post('materia')) : json_encode(array());

		$view->filter_taxonomia = ($this->request->post('taxonomia') != "") ? $this->request->post('taxonomia') : "";
		$view->fase = (empty($fase)) ? 1 : $fase;
		
		//$query = ORM::factory('object');						
		//$count = $query->count_all();
		//$pag = new Pagination( array( 'total_items' => $count, 'items_per_page' => self::ITENS_POR_PAGINA, 'auto_hide' => true ) );
		//$view->page_links = $pag->render();
        $view->projectList = ORM::factory('project')->where('status', '=', '1')->order_by('name', 'ASC')->find_all(); 


		//$view->objectsList = $query->order_by('id','DESC')->limit($pag->items_per_page)->offset($pag->offset)->find_all();
		//$view->linkPage = ($this->assistente)?('view'):('edit');
		//$view->styleExclusao = ($this->assistente)?('style="display:none"'):('');
		$this->template->content = $view;             
	} 
	*/
    
	public function action_create(){ 		
        $view = View::factory('admin/objects/create')
			->bind('errors', $errors)
			->bind('message', $message);
		
		$view->isUpdate = false; 
		$this->addValidateJs('public/js/admin/validateObjects.js');
		$view->objVO = $this->setVO('object');
        
        $view->typeObjects = ORM::factory('typeobject')->order_by('name', 'ASC')->find_all();
        $view->countries = ORM::factory('country')->find_all();
        $view->suppliers = ORM::factory('supplier')->order_by('order', 'ASC')->order_by('empresa', 'ASC')->find_all();
        $view->collections = ORM::factory('collection')->order_by('name', 'ASC')->find_all();
        $view->formats = ORM::factory('format')->order_by('name', 'ASC')->find_all();
		
		       
        if (HTTP_Request::POST == $this->request->method()) 
		{           
            $this->salvar();
        }    
        
        $this->template->content = $view;                     
	}
      
	public function action_delete($id)
	{
		/*
		$view = View::factory('admin/objects/list')
			->bind('errors', $errors)
			->bind('message', $message);
		
		try 
		{            
			$objeto = ORM::factory('object', $id);
			$objeto->delete();
			Utils_Helper::mensagens('add','Objeto excluído com sucesso.'); 
		} catch (ORM_Validation_Exception $e) {
			Utils_Helper::mensagens('add','Houveram alguns erros na exclusão dos dados.'); 
			$errors = $e->errors('models');
		}
		
		Request::current()->redirect('admin/objects');
		*/
	}

	public function action_edit($id)
    {           
		$view = View::factory('admin/objects/create')
			->bind('errors', $errors)
			->bind('message', $message)
			->set('values', $this->request->post());
                
        $this->addValidateJs('public/js/admin/validateObjects.js');

		$objeto = ORM::factory('object', $id);
        $view->objVO = $this->setVO('object', $objeto);
		$view->isUpdate = true;                             
                
		$view->typeObjects = ORM::factory('typeobject')->order_by('name', 'ASC')->find_all();
        $view->countries = ORM::factory('country')->find_all();
        $view->suppliers = ORM::factory('supplier')->order_by('order', 'ASC')->order_by('empresa', 'ASC')->find_all();        
        $view->collections = ORM::factory('collection')->order_by('name', 'ASC')->find_all();  
        $view->formats = ORM::factory('format')->order_by('name', 'ASC')->find_all(); 
                
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
            $this->salvar($id);
        }

        $this->template->content = $view;
	}
        
    public function action_view($id, $task_id = null)
    {       
        $view = View::factory('admin/custos/view')
            ->bind('errors', $errors)
            ->bind('message', $message);

		$this->addValidateJs('public/js/admin/validateTasks.js');

		$objeto = ORM::factory('object', $id);
        $view->obj = $objeto;   
        $view->user = $this->current_user->userInfos;                          
		
        
        $view->form_custo = View::factory('admin/custos/form_custo');
        $view->form_custo->obj = $objeto;
        $view->form_custo->teamList = ORM::factory('team')->find_all();
        
 		$view->current_auth = $this->current_auth;
        
        $this->template->content = $view;
        
        return true;
	}


	protected function salvar($id = null)
	{
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$object = ORM::factory('object', $id)->values($this->request->post(), array( 
                    'title', 
                    'taxonomia', 
                    'typeobject_id', 
                    'collection_id', 
                    'supplier_id', 
                    'audiosupplier_id',
                    'country_id',
                    'format_id',
                    'reaproveitamento', 
                    'interatividade',
                    'fase', 
                    'crono_date', 
                    'obs', 
                    'uni', 
                    'cap', 
                    'pagina',
                    'status',
                    'tamanho',
                    'duracao',
                    'cessao',
                    'sinopse',
                    'taxonomia_reap',
                    'arq_aberto',
                    'speaker',

                     ));

			
			if($this->request->post('taxonomia_reap') != ""){
				$object_source = ORM::factory('object')->where('taxonomia', '=', $this->request->post('taxonomia_reap'))->find();
				
				$object->object_id = $object_source->id;	
			}else{
				$object->object_id = null;
			}
			
			$object->save();

			if(is_null($id)){
				$objectStatus = ORM::factory('objects_statu');
		        $objectStatus->object_id = $object->id;
		        $objectStatus->status_id = '1';
		        $objectStatus->crono_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->request->post('ini_date'))));
				$objectStatus->userInfo_id = $this->current_user->userInfos->id;	
				$objectStatus->save();
			}

			Utils_Helper::mensagens('add','Objeto salvo com sucesso.');
			$db->commit();
			Request::current()->redirect('admin/objects');

		}  catch (ORM_Validation_Exception $e) {
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

    /********************************/
    public function action_getSuppliers($team_id){
    	$this->auto_render = false;
    	$query = ORM::factory('supplier')->where('team_id', '=', $team_id)->find_all();

    	$result = array('dados' => array());
    	foreach ($query as $supplier) {
    		array_push($result['dados'], array('id' => $supplier->id, 'display' => $supplier->empresa));
    	}

    	print json_encode($result);
    }


 
}