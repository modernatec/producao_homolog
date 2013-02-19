<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Objects extends Controller_Admin_Template {
 
	public $auth_required = array('login'); //Auth is required to access this controller
 
	public $secure_actions = array(
                                    'create' => array('login', 'coordenador'),
                                    'edit' => array('login', 'coordenador'),
                                    'delete' => array('login', 'coordenador'),
                                 );
    const ITENS_POR_PAGINA = 20;
					 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);	
	}
        
	protected function addValidateJs(){
		$scripts =   array(
			"public/js/admin/validateObjects.js",
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
		$view = View::factory('admin/objects/list')
			->bind('message', $message);
		
		$query = ORM::factory('object');
						
		$count = $query->count_all();
		$pag = new Pagination( array( 'total_items' => $count, 'items_per_page' => self::ITENS_POR_PAGINA, 'auto_hide' => true ) );
		$view->page_links = $pag->render();
                
		$view->objectsList = $query->order_by('id','DESC')->limit($pag->items_per_page)->offset($pag->offset)->find_all();
		$view->tiposObj = ORM::factory('typeobject')->order_by('nome','ASC')->find_all();
		$view->segmentos = ORM::factory('segmento')->order_by('nome','ASC')->find_all();
		$view->colecaoList = DB::select('colecao')->from('objects')->group_by('colecao')->order_by('colecao','ASC')->as_object()->execute();
		$view->dataLancamentoList = DB::select('data_lancamento')->from('objects')->group_by('data_lancamento')->order_by('data_lancamento','ASC')->as_object()->execute();
		//$view->titulo = '';
		//$view->linkPage = ($this->assistente)?('view'):('edit');
		//$view->styleExclusao = ($this->assistente)?('style="display:none"'):('');
		$this->template->content = $view;             
	} 
        
    public function action_filter()
	{	
		$view = View::factory('admin/objects/list')
			->bind('message', $message);
                
		$typeobject_id = $this->request->post('typeobject_id');
		$segmento_id = $this->request->post('segmento_id');
		$colecao = $this->request->post('colecao');
		$ano = $this->request->post('ano');
		$titulo = $this->request->post('titulo');
		
		$query = ORM::factory('object');
		if($typeobject_id!=''){
			$query->and_where('typeobject_id','=',$typeobject_id);
		}
		if($segmento_id!=''){
			$query->and_where('segmento_id','=',$segmento_id);
		}
		if($colecao!=''){
			$query->and_where('colecao','=',$colecao);
		}
		if($ano!=''){
			$query->and_where('data_lancamento','like',"$ano-%");
		}
		if($titulo!=''){
			$query->and_where('nome_obj','like',"%$titulo%");
		}
		
		$count = $query->count_all();                
		$pag = new Pagination( array( 'total_items' => $count, 'items_per_page' => self::ITENS_POR_PAGINA, 'auto_hide' => true ) );
		$view->page_links = $pag->render();
		
		$view->objectsList = $query->order_by('id','DESC')->limit($pag->items_per_page)->offset($pag->offset)->find_all();
		
		$view->tiposObj = $this->getTypeObjetcs($typeobject_id);
		$view->segmentos = $this->getSegmentos($segmento_id);
		$view->colecaoList = $this->getColecoes($colecao);
		$view->dataLancamentoList = $this->getDataLancamento($ano);
		$view->titulo = $titulo;     
		$view->linkPage = ($this->assistente)?('view'):('edit');
		$view->styleExclusao = ($this->assistente)?('style="display:none"'):('');
		$this->template->content = $view;             
	} 

	public function action_create(){ 
		$view = View::factory('admin/objects/create')
			->bind('errors', $errors)
			->bind('message', $message);
			
		$view->objVO = $this->setVO('object');
        $view->typeObjects = ORM::factory('typeobject')->find_all();
		$view->countries = ORM::factory('country')->find_all();
		$view->suppliers = ORM::factory('supplier')->find_all();
		$view->segmentos = ORM::factory('segmento')->find_all();
		$view->softwares = ORM::factory('sfwprod')->order_by('nome', 'ASC')->find_all();
		$view->collections = ORM::factory('collection')->order_by('name', 'ASC')->find_all();
		$view->materias = ORM::factory('materia')->order_by('nome', 'ASC')->find_all();
		
		$this->template->content = $view;
                
		$this->addValidateJs(Controller_Admin_Files::addJs());
		
		
                
        /*        $tiposObj = $this->getTypeObjetcs(Arr::get($values, 'typeobject_id'));
                $segmentos = $this->getSegmentos(Arr::get($values, 'segmento_id'));                
                $countries = $this->getCountries(Arr::get($values, 'country_id'));   
                $sfwprodsList = $this->getSfwprodsList();
                $suppliersList = $this->getSupplierList();
                $materiasList = $this->getMateriasList();
                
                $objectpai = ORM::factory('object',Arr::get($values, 'objectpai_id'));
		*/		
		if (HTTP_Request::POST == $this->request->method()) 
		{           
                    $objeto = $this->salvar();
                    $filesList = $this->getFilesList($objeto->id);                    
                    $objVet = array(
                        'nome_obj' => ($objeto->nome_obj) ? ($objeto->nome_obj) : (Arr::get($values, 'nome_obj')),
                        'nome_arq' => ($objeto->nome_arq) ? ($objeto->nome_arq) : (Arr::get($values, 'nome_arq')),
                        'tipo_obj' => $tiposObj,
                        'colecao' => ($objeto->colecao) ? ($objeto->colecao) : (Arr::get($values, 'colecao')),
                        'segmento' => $segmentos,
                        'sfwprodsList' => $sfwprodsList,
                        'suppliersList' => $suppliersList,
                        'arq_aberto' => ($objeto->arq_aberto) ? ($objeto->arq_aberto) : (Arr::get($values, 'arq_aberto')),
                        'extensao_arq' => ($objeto->extensao_arq) ? ($objeto->extensao_arq) : (Arr::get($values, 'extensao_arq')),
                        'interatividade' => ($objeto->interatividade) ? ($objeto->interatividade) : (Arr::get($values, 'interatividade')),
                        'empresa' => ($objeto->empresa) ? ($objeto->empresa) : (Arr::get($values, 'empresa')),
                        'data_lancamento' => ($objeto->data_lancamento) ? ($objeto->data_lancamento) : (Arr::get($values, 'data_lancamento')),
                        'sinopse' => ($objeto->sinopse) ? ($objeto->sinopse) : (Arr::get($values, 'sinopse')),
                        'obs' => ($objeto->obs) ? ($objeto->obs) : (Arr::get($values, 'obs')),
                        'countries' => $countries,
                        'materiasList' => $materiasList,
                        'objectpai_id' => 0,
                        'objectpai_txt' => '',
                        'filesList' => $filesList
                    );
                    $view->objeto = $objeto;
		}
                else
                {
                    $objVet = array(
                        'nome_obj' => '',
                        'nome_arq' => '',
                        'tipo_obj' => $tiposObj,
                        'colecao' => '',
                        'segmento' => $segmentos,
                        'sfwprodsList' => $sfwprodsList,
                        'suppliersList' => $suppliersList,
                        'arq_aberto' => '',
                        'extensao_arq' => '',
                        'interatividade' => '',
                        'empresa' => '',
                        'data_lancamento' => '',
                        'sinopse' => '',
                        'obs' => '',
                        'countries' => $countries,
                        'materiasList' => $materiasList,
                        'objectpai_id' => 0,
                        'objectpai_txt' => '',
                        'filesList' => ''
                    );                    
                }
                $view->objVet = $objVet;
                
                $this->template->content = $view;
	}
        
	public function action_delete($id)
	{
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
	}

	public function action_edit($id)
        {           
		$view = View::factory('admin/objects/create')
			->bind('errors', $errors)
			->bind('message', $message)
			->set('values', $this->request->post());
                
                $this->addPlupload();
		$this->addValidateJs();

		$objeto = ORM::factory('object', $id);
		$view->objeto = $objeto;
		$view->isUpdate = true;                
                
                $this->template->content = $view;
                
		$tiposObj = $this->getTypeObjetcs($objeto->typeobject_id);
                $segmentos = $this->getSegmentos($objeto->segmento_id);
                $countries = $this->getCountries($objeto->country_id);
		$sfwprodsList = $this->getSfwprodsList($objeto->id);
                $suppliersList = $this->getSupplierList($objeto->id);
                $materiasList = $this->getMateriasList($objeto->id);
                $filesList = $this->getFilesList($objeto->id);
                $objectpai = ORM::factory('object', $objeto->objectpai_id);    
                
		if (HTTP_Request::POST == $this->request->method()) 
		{                                              
                    $objeto = $this->salvar($id);

                    $objVet = array(
                        'nome_obj' => ($objeto->nome_obj) ? ($objeto->nome_obj) : (Arr::get($values, 'nome_obj')),
                        'nome_arq' => ($objeto->nome_arq) ? ($objeto->nome_arq) : (Arr::get($values, 'nome_arq')),
                        'tipo_obj' => $tiposObj,
                        'colecao' => ($objeto->colecao) ? ($objeto->colecao) : (Arr::get($values, 'colecao')),
                        'segmento' => ($objeto->segmento) ? ($objeto->segmento) : (Arr::get($values, 'segmento')),
                        'sfwprodsList' => $sfwprodsList,
                        'suppliersList' => $suppliersList,
                        'arq_aberto' => ($objeto->arq_aberto) ? ($objeto->arq_aberto) : (Arr::get($values, 'arq_aberto')),
                        'extensao_arq' => ($objeto->extensao_arq) ? ($objeto->extensao_arq) : (Arr::get($values, 'extensao_arq')),
                        'interatividade' => ($objeto->interatividade) ? ($objeto->interatividade) : (Arr::get($values, 'interatividade')),
                        'empresa' => ($objeto->empresa) ? ($objeto->empresa) : (Arr::get($values, 'empresa')),
                        'data_lancamento' => ($objeto->data_lancamento) ? ($objeto->data_lancamento) : (Arr::get($values, 'data_lancamento')),
                        'sinopse' => ($objeto->sinopse) ? ($objeto->sinopse) : (Arr::get($values, 'sinopse')),
                        'obs' => ($objeto->obs) ? ($objeto->obs) : (Arr::get($values, 'obs')),
                        'countries' => $countries,
                        'materiasList' => $materiasList,
                        'objectpai_id' => ($objectpai->id) ? ($objectpai->id) : (Arr::get($values, 'objectpai_id')),
                        'objectpai_txt' => ($objectpai->nome_obj) ? ($objectpai->nome_obj) : '',
                        'filesList' => $filesList
                    );
                    $view->objeto = $objeto;
		}
                else
                {                    
                    $objVet = array(
                        'nome_obj' => ($objeto->nome_obj) ? ($objeto->nome_obj) : (Arr::get($values, 'nome_obj')),
                        'nome_arq' => ($objeto->nome_arq) ? ($objeto->nome_arq) : (Arr::get($values, 'nome_arq')),
                        'tipo_obj' => $tiposObj,
                        'colecao' => ($objeto->colecao) ? ($objeto->colecao) : (Arr::get($values, 'colecao')),
                        'segmento' => $segmentos,
                        'sfwprodsList' => $sfwprodsList,
                        'suppliersList' => $suppliersList,
                        'arq_aberto' => ($objeto->arq_aberto!='') ? ($objeto->arq_aberto) : (Arr::get($values, 'arq_aberto')),
                        'extensao_arq' => ($objeto->extensao_arq) ? ($objeto->extensao_arq) : (Arr::get($values, 'extensao_arq')),
                        'interatividade' => ($objeto->interatividade!='') ? ($objeto->interatividade) : (Arr::get($values, 'interatividade')),
                        'empresa' => ($objeto->empresa) ? ($objeto->empresa) : (Arr::get($values, 'empresa')),
                        'data_lancamento' => ($objeto->data_lancamento) ? ($objeto->data_lancamento) : (Arr::get($values, 'data_lancamento')),
                        'sinopse' => ($objeto->sinopse) ? ($objeto->sinopse) : (Arr::get($values, 'sinopse')),
                        'obs' => ($objeto->obs) ? ($objeto->obs) : (Arr::get($values, 'obs')),
                        'countries' => $countries,
                        'materiasList' => $materiasList,
                        'objectpai_id' => ($objectpai->id) ? ($objectpai->id) : (Arr::get($values, 'objectpai_id')),
                        'objectpai_txt' => ($objectpai->nome_obj) ? ($objectpai->nome_obj) : '',
                        'filesList' => $filesList
                    );
                    $view->objVet = $objVet;
                }

                $this->template->content = $view;
	}
        
        public function action_view($id)
        {           
		$view = View::factory('admin/objects/view');

		$this->addValidateJs();

		$objeto = ORM::factory('object', $id);
                                
		$tiposObj = $this->getTypeObjetcs($objeto->typeobject_id);
                $segmentos = $this->getSegmentos($objeto->segmento_id);
                $countries = $this->getCountries($objeto->country_id);
		$sfwprodsList = $this->getSfwprodsList($objeto->id,true);
                $suppliersList = $this->getSupplierList($objeto->id,true);
                $materiasList = $this->getMateriasList($objeto->id,true);
                $filesList = $this->getFilesList($objeto->id);
                $objectpai = ORM::factory('object', $objeto->objectpai_id);                
		                
                $objVet = array(
                    'nome_obj' => $objeto->nome_obj,
                    'nome_arq' => $objeto->nome_arq,
                    'tipo_obj' => $tiposObj,
                    'colecao' => $objeto->colecao,
                    'segmento' => $segmentos,
                    'sfwprodsList' => $sfwprodsList,
                    'suppliersList' => $suppliersList,
                    'arq_aberto' => $objeto->arq_aberto,
                    'extensao_arq' => $objeto->extensao_arq,
                    'interatividade' => $objeto->interatividade,
                    'empresa' => $objeto->empresa,
                    'data_lancamento' => $objeto->data_lancamento,
                    'sinopse' => $objeto->sinopse,
                    'obs' => $objeto->obs,
                    'countries' => $countries,
                    'materiasList' => $materiasList,
                    'objectpai_id' => $objectpai->id,
                    'objectpai_txt' => $objectpai->nome_obj,
                    'filesList' => $filesList
                );
                $view->objVet = $objVet;

                $this->template->content = $view;
	}

	protected function salvar($id = null)
	{
		$db = Database::instance();
        $db->begin();
		
		try 
		{            
			$objeto = ORM::factory('object', $id)->values($this->request->post(), array( 'nome_obj', 'nome_arq', 'typeobject_id', 'colecao', 'segmento_id', 'arq_aberto', 'extensao_arq', 'interatividade', 'empresa', 'data_lancamento', 'sinopse', 'obs', 'country_id', ));
			                
			if(!$id)
			{
				$objeto->data_ins = date('Y-m-d H:i:s');
				$objeto->status = 1;
			}
                        
			if($this->request->post('objectpai_id') != ''){
				$objeto->objectpai_id = $this->request->post('objectpai_id');
			}else{
				$objeto->objectpai_id = 0;
			}
                        
			$objeto->data_alt = date('Y-m-d H:i:s');
			$objeto->save();
                        
			$basedir = 'public/upload/objetos';
			$rootdir = DOCROOT.$basedir;
			if($objeto->data_lancamento != ''){
				$ano = Utils_Helper::data($objeto->data_lancamento,'Y');
				$rootdir .= '/'.$ano;
				if(!file_exists($rootdir))
				{                                
					mkdir($rootdir,0777);
				}
				
				if($objeto->colecao != ''){
					$colecao = Utils_Helper::limparStr($objeto->colecao);
					$rootdir .= '/'.$colecao;
					if(!file_exists($rootdir))
					{   
						mkdir($rootdir,0777);
					}
					
					if($objeto->nome_arq != ''){
						$nome_arq = Utils_Helper::limparStr($objeto->nome_arq);
						$rootdir .= '/'.$nome_arq;
						if(!file_exists($rootdir))
						{                                        
							mkdir($rootdir,0777);
						}
					}
				}
			}
							   
			$filesUploads = $this->request->post('filesUploads');
			$mimeUploads = $this->request->post('mimeUploads');
			if($filesUploads!='')
			{
				$arrFiles = explode(',',$filesUploads);
				$arrMimes = explode(',',$mimeUploads);
				$basedir = 'public/plupload/temporario/';
				$newbasedir = str_replace(DOCROOT,'',$rootdir).'/';
				foreach($arrFiles as $k=>$file){
					if($file!='empty'){
						$size = filesize($basedir.$file);

						Controller_Admin_Files::salvar($newbasedir.$file,$arrMimes[$k],$size,$objeto->id,'object');

						rename($basedir.$file, $newbasedir.$file);
					}
				}
			}
			
			$software_producao = $this->request->post('software_producao');
			if(count($software_producao)>0)
			{
				$objeto->remove('sfwprods');
				foreach($software_producao as $sfwprod_id){
					$objeto->add('sfwprods', ORM::factory('sfwprod', array('id' => $sfwprod_id)));
				}
			}
			
			$produtora = $this->request->post('produtora');
			if(count($produtora)>0)
			{
				$objeto->remove('suppliers');
				foreach($produtora as $supplier_id){
					$objeto->add('suppliers', ORM::factory('supplier', array('id' => $supplier_id)));
				}
			}
                        
			$materia = $this->request->post('materia');
			if(count($materia)>0)
			{
				$objeto->remove('materias');
				foreach($materia as $materia_id){
					$objeto->add('materias', ORM::factory('materia', array('id' => $materia_id)));
				}
			}
			
			Utils_Helper::mensagens('add','Objeto '.$objeto->nome_obj.' salvo com sucesso.');
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
    
	/*    
        protected function getTypeObjetcs($id = null){
            $tiposObj = '';
            
            foreach($typeObjectsjsList as $tol){
                $sld = '';
                if($id == $tol->id) $sld = 'selected="selected"';
                $tiposObj .= '<option value="'.$tol->id.'" '.$sld.'>'.$tol->nome.'</option>';
            }
            return $tiposObj;
        }
       
        protected function getSegmentos($id = null){
            $segmentos = '';                
            $segmentosList = 
            foreach($segmentosList as $tol){
                $sld = '';
                if($id == $tol->id) $sld = 'selected="selected"';
                $segmentos .= '<option value="'.$tol->id.'" '.$sld.'>'.$tol->nome.'</option>';
            }
            return $segmentos;
        }
         
        protected function getCountries($id = null){
            $countries = '';                
            $countriesList = ORM::factory('country')->order_by('nome','ASC')->find_all();
            foreach($countriesList as $tol){
                $sld = '';
                if($id == $tol->id) $sld = 'selected="selected"';
                $countries .= '<option value="'.$tol->id.'" '.$sld.'>'.$tol->nome.'</option>';
            }
            return $countries;
        }
        
        protected function getSfwprodsList($id = null, $disabled = false){
            $sfwprods = '';
            $objectsSfwprods = array();
            $results = DB::select('sfwprod_id')->from('objects_sfwprods')->where('object_id', '=',$id)->execute();
            foreach($results->as_array('sfwprod_id') as $id => $o){
                array_push($objectsSfwprods,$id);
            }
            $sfwprodsList = ORM::factory('sfwprod')->order_by('nome','ASC')->find_all();
            foreach($sfwprodsList as $tol){
                $ckd = $dsb = '';
                if($disabled) $dsb = 'disabled="disabled';
                if(in_array($tol->id, $objectsSfwprods)) $ckd = 'checked="checked"';
                $sfwprods .= '<p><input type="checkbox" name="software_producao[]" '.$ckd.' '.$dsb.' value="'.$tol->id.'" />'.$tol->nome.'</p>';
            }
            return $sfwprods;
        }
        
        protected function getSupplierList($id = null, $disabled = false){
            $suppliers = '';
            $objectsSuppliers = array();
            $results = DB::select('supplier_id')->from('objects_suppliers')->where('object_id', '=',$id)->execute();
            foreach($results->as_array('supplier_id') as $id => $o){
                array_push($objectsSuppliers,$id);
            }
            $suppliersList = ORM::factory('supplier')->order_by('empresa','ASC')->find_all();
            foreach($suppliersList as $tol){
                $ckd = $dsb = '';
                if($disabled) $dsb = 'disabled="disabled';
                if(in_array($tol->id, $objectsSuppliers)) $ckd = 'checked="checked"';
                $suppliers .= '<p><input type="checkbox" name="produtora[]" '.$ckd.' '.$dsb.' value="'.$tol->id.'" />'.$tol->empresa.'</p>';
            }
            return $suppliers;
        }
        
        protected function getColecoes($txt = ''){
            $colecoes = '';                
            $colecoesList = '';
            foreach($colecoesList as $cl){
                $sld = '';
                if($txt == $cl->colecao) $sld = 'selected="selected"';
                $colecoes .= '<option value="'.$cl->colecao.'" '.$sld.'>'.$cl->colecao.'</option>';
            }
            return $colecoes;
        }
        
        protected function getDataLancamento($txt = ''){
            $dataLancamentos = '';                
            $dataLancamentosList = '';
            foreach($dataLancamentosList as $dl){
                $sld = '';
                $ano = Utils_Helper::data($dl->data_lancamento,'Y');
                if($txt == $ano) $sld = 'selected="selected"';
                $dataLancamentos .= '<option value="'.$ano.'" '.$sld.'>'.$ano.'</option>';
            }
            return $dataLancamentos;
        }
        
        protected function getMateriasList($id = null, $disabled = false){
            $materias = '';
            $objectsMaterias = array();
            $results = DB::select('materia_id')->from('objects_materias')->where('object_id', '=',$id)->execute();
            foreach($results->as_array('materia_id') as $id => $o){
                array_push($objectsMaterias,$id);
            }
            $materiasList = ORM::factory('materia')->order_by('nome','ASC')->find_all();
            foreach($materiasList as $tol){
                $ckd = $dsb = '';
                if($disabled) $dsb = 'disabled="disabled';
                if(in_array($tol->id, $objectsMaterias)) $ckd = 'checked="checked"';
                $materias .= '<p><input type="checkbox" name="materia[]" '.$ckd.' '.$dsb.' value="'.$tol->id.'" />'.$tol->nome.'</p>';
            }
            return $materias;
        }
        */
        protected function getFilesList($id){
            $filesList = ORM::factory('file')->where('model','=','object')->and_where('model_id','=',$id)->find_all(); 
            $files = '';
            foreach($filesList as $file){
                $files .= '<li><a href="'.URL::base().'admin/files/download/'.$file->id.'" title="Download" target="_blank">'.basename($file->uri).'</a></li>';
            }
            return $files;
        }
        
        public function action_popload()
        {	
            $callback = $this->request->query('callback');
           
            $country_id = $this->request->query('country_id');
            $colecao = $this->request->query('colecao');
            $ano = $this->request->query('ano');
            
            $dados = array();
            if($country_id != '' && $colecao == '' && $ano == ''){
                $list = DB::select('colecao')->from('objects')->where('country_id','=',$country_id)->group_by('colecao')->order_by('colecao','ASC')->as_object()->execute();                
                foreach($list as $l){
                    $dado = array('id'=>$l->colecao,'title'=>$l->colecao);
                    array_push($dados,$dado);
                }
            }elseif($country_id != '' && $colecao != '' && $ano == ''){
                $list = DB::select('data_lancamento')->from('objects')->where('country_id','=',$country_id)->where('colecao','=',$colecao)->group_by('data_lancamento')->order_by('data_lancamento','DESC')->as_object()->execute();                
                foreach($list as $l){
                    $ano = Utils_Helper::data($l->data_lancamento,'Y');
                    $dado = array('id'=>$ano,'title'=>$ano);
                    array_push($dados,$dado);
                }
            }elseif($country_id != '' && $colecao != '' && $ano != ''){
                $list = DB::select('id','nome_obj')->from('objects')->where('country_id','=',$country_id)->where('colecao','=',$colecao)->where('data_lancamento','like',"$ano-%")->order_by('nome_obj','ASC')->as_object()->execute();                
                foreach($list as $l){
                    $dado = array('id'=>$l->id,'title'=>$l->nome_obj);
                    array_push($dados,$dado);
                }
            }else{
                $list = ORM::factory('country')->order_by('nome','ASC')->find_all();
                foreach($list as $l){
                    $dado = array('id'=>$l->id,'title'=>$l->nome);
                    array_push($dados,$dado);
                }
            }
            $arr = array('dados'=>$dados);
            print $callback.json_encode($arr);
            exit;
        } 
}