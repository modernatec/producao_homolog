<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Acervo extends Controller_Admin_Template {
 
	public $auth_required = array('login'); //Auth is required to access this controller
 	
	public $secure_actions = array(
                                    'create' => array('login', 'assistente 2'),
                                    'edit' => array('login', 'assistente 2'),
                                    'delete' => array('login', 'coordenador'),
                                 );
                                 
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
	}

	public function action_path()
	{	
		$this->auto_render = false;
		$objctList = ORM::factory('object')->where('object_id', '!=', '')->and_where('fase', '=', '1')->find_all();
		var_dump(count($objctList));
		foreach ($objctList as $object) {
			$obj = ORM::factory('objects_path');
			$obj->object_id = $object->id;
			$obj->object_reap_id = $object->object_id;
			$obj->save();
		}
		echo 'ok';
	} 
	        
	public function action_index($page = null)
	{	
		$view = View::factory('admin/acervo/list')
			->bind('message', $message);

		//if($ajax == null){
			//$this->template->content = $view;             
		//}else{
			$this->auto_render = false;

			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($this->action_getObjects($page, true)->render())),
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
				)						
			);
	        return false;
		//}           
	} 
     
	public function action_view($id, $ajax = null)
    {       
    	$this->auto_render = false;
        $view = View::factory('admin/acervo/view')
            ->bind('errors', $errors)
            ->bind('message', $message);

		$objeto = ORM::factory('object', $id);
        $view->objeto = $objeto;   
        $view->user = $this->current_user->userInfos;    

        $array_path = array();
        if($objeto->object_id != ""){        	
            $this->searchPathBehind($array_path, $objeto->object_id);  
        }      
        $view->array_path = $array_path;  

        $array_pathFoward = array();
        $this->searchPathFoward($array_pathFoward, $objeto->id);             
        $view->array_pathFoward = $array_pathFoward;                  
		
        //ALTERAR APOS INCLUSAO DAS TASKS NO STATUS
        $view->objects_status = ORM::factory('objects_statu')->where('object_id', '=', $id)->order_by('created_at', 'DESC')->find_all();
        $last_status = $view->objects_status[0];
        
 		$view->current_auth = $this->current_auth;

 		echo $view;
	}

	public function searchPathFoward(&$array, $id){
		$object_path = ORM::factory('object')->where('object_id', '=', $id)->find_all();
		if(count($object_path) > 0){
			foreach ($object_path as $value) {
				array_push($array, $value);
				$this->searchPathFoward($array, $value->id);
			}
		}
	}

	public function searchPathBehind(&$array, $id){
		$object_path = ORM::factory('object', $id);
		array_push($array, $object_path);

		if($object_path->object_id != ''){
			$this->searchPathBehind($array, $object_path->object_id)[0];
		}
	}

    /********************************/
    public function getFiltros(){
    	$this->auto_render = false;
    	$viewFiltros = View::factory('admin/acervo/filtros');

    	$filtros = Session::instance()->get('kaizen')['filtros'];

  		$viewFiltros->filter_segmento = array();
		$viewFiltros->filter_collection = array();
		$viewFiltros->filter_project = array();
		$viewFiltros->filter_typeobject = array();
  		$viewFiltros->filter_supplier = array();
  		$viewFiltros->filter_origem = array();
  		$viewFiltros->filter_tipo = array();

  		foreach ($filtros as $key => $value) {
  			$viewFiltros->$key = json_decode($value);
  		}

  		$tax_coloum = "";
		$tax_order = "";
		$order_by = "";

		if(isset($viewFiltros->filter_taxonomia)){
    		$list = explode(' ',addslashes($viewFiltros->filter_taxonomia));
    		$string = join('* +*',$list);

			$tax_coloum = ", MATCH (title, keywords) AGAINST ('+*".$string."*') AS relevance";
			$tax_order = "AND MATCH (title, keywords) AGAINST ('+*".$string."*')";
			$order_by = "ORDER BY relevance DESC";
		}

    	$segmento = (count($viewFiltros->filter_segmento) > 0) ? "AND b.segmento_id IN ('".implode(',', $viewFiltros->filter_segmento)."')" : "";
    	$supplier = (count($viewFiltros->filter_supplier) > 0) ? "AND a.supplier_id IN ('".implode("','",$viewFiltros->filter_supplier)."')" : '';
    	$origem = (count($viewFiltros->filter_origem) > 0) ? "AND a.reaproveitamento IN ('".implode("','",$viewFiltros->filter_origem)."')" : '';
    	$project = (count($viewFiltros->filter_project ) > 0) ? "AND a.project_id IN ('".implode("','",$viewFiltros->filter_project)."')" : '';
    	$collection = (count($viewFiltros->filter_collection ) > 0) ? "AND a.collection_id IN ('".implode("','",$viewFiltros->filter_collection)."')" : '';
    	$tipo = (count($viewFiltros->filter_tipo) > 0) ? "AND a.typeobject_id IN ('".implode(',',$viewFiltros->filter_tipo)."')" : '';
    	
		$sql = "SELECT 
					a.*, 
					b.id as collection_id, 
					b.name as collection_name, 
					b.segmento_id as segmento_id, 
					b.ano as collection_ano, 
					c.name as tipo
					".$tax_coloum."       				
				FROM moderna_objects a 
				INNER JOIN moderna_collections b ON a.collection_id = b.id
				INNER JOIN moderna_typeobjects c ON a.typeobject_id = c.id
				INNER JOIN moderna_objects_status d ON a.id = d.object_id
				WHERE fase = '1' AND d.status_id = '8' 
				".$segmento." 
				 
				".$origem." 
				".$project." 
				".$collection." 
				".$tipo." 
				".$tax_order.
				" GROUP BY a.id ".$order_by;

		$result = DB::query(Database::SELECT, $sql)->as_object(true)->execute();

		$collections_arr = array();
		$segmentos_arr = array();
		$projects_arr = array();
		$type_arr = array();

		foreach ($result as $value) {
			array_push($collections_arr, $value->collection_id);
			array_push($segmentos_arr, $value->segmento_id);
			array_push($projects_arr, $value->project_id);
			array_push($type_arr, $value->typeobject_id);
		}

  		$viewFiltros->segmentoList = ORM::factory('segmento')->where('id', 'IN', array_unique($segmentos_arr))->order_by('name', 'ASC')->find_all();
		$viewFiltros->collectionList = ORM::factory('collection')->where('id', 'IN', array_unique($collections_arr))->order_by('name', 'ASC')->find_all();
		$viewFiltros->projectList = ORM::factory('project')->where('id', 'IN', array_unique($projects_arr))->order_by('name', 'ASC')->find_all();
		$viewFiltros->typeList = ORM::factory('typeobject')->where('id', 'IN', array_unique($type_arr))->order_by('name', 'ASC')->find_all();
		$viewFiltros->suppliersList = array();//= ORM::factory('supplier')->order_by('empresa', 'ASC')->find_all();		

  		return $viewFiltros;
    }

    public function action_getObjects($page, $ajax = null){
    	$this->auto_render = false;

    	//$this->startProfilling();
    	
		$view = View::factory('admin/acervo/table');		       	

		if(count($this->request->post('acervo')) > '0' || Session::instance()->get('kaizen')['model'] != 'acervo'){
			$kaizen_arr = Utils_Helper::setFilters($this->request->post(), 1, "acervo");
		}else{
			$kaizen_arr = Session::instance()->get('kaizen');
		}
		
		if(Session::instance()->get('kaizen')['model'] == 'acervo' && $page != 'ajax'){
    		$kaizen_arr['parameters'] = $page;
    	}

  		Session::instance()->set('kaizen', $kaizen_arr);

  		$filtros = Session::instance()->get('kaizen')['filtros'];
  		
  		foreach ($filtros as $key => $value) {
  			$view->$key = json_decode($value);
  		}

		/************************/
		$tax_coloum = "";
		$tax_order = "";
		$order_by = "";

		if(isset($view->filter_taxonomia)){
    		$list = explode(' ',addslashes($view->filter_taxonomia));
    		$string = join('* +*',$list);

			$tax_coloum = ", MATCH (title, keywords) AGAINST ('+*".$string."*') AS relevance";
			$tax_order = "AND MATCH (title, keywords) AGAINST ('+*".$string."*')";
			$order_by = "ORDER BY relevance DESC";
		}

    	$segmento = (isset($view->filter_segmento)) ? "AND b.segmento_id IN ('".implode(',', $view->filter_segmento)."')" : "";
    	$supplier = (isset($view->filter_supplier)) ? "AND a.supplier_id IN ('".implode("','",$view->filter_supplier)."')" : '';
    	$origem = (isset($view->filter_origem)) ? "AND a.reaproveitamento IN ('".implode("','",$view->filter_origem)."')" : '';
    	$project = (isset($view->filter_project )) ? "AND a.project_id IN ('".implode("','",$view->filter_project)."')" : '';
    	$collection = (isset($view->filter_collection )) ? "AND a.collection_id IN ('".implode("','",$view->filter_collection)."')" : '';
    	$tipo = (isset($view->filter_tipo)) ? "AND a.typeobject_id IN ('".implode(',',$view->filter_tipo)."')" : '';
    	

		$sql = "SELECT 
					a.*, 
					b.name as collection_name, 
					b.ano as collection_ano, 
					c.name as tipo
					".$tax_coloum."       				
				FROM moderna_objects a 
				INNER JOIN moderna_collections b ON a.collection_id = b.id
				INNER JOIN moderna_typeobjects c ON a.typeobject_id = c.id
				INNER JOIN moderna_objects_status d ON a.id = d.object_id
				WHERE fase = '1' AND d.status_id = '8' 
				".$segmento." 
				".$supplier." 
				".$origem." 
				".$project." 
				".$collection." 
				".$tipo." 
				".$tax_order.
				" GROUP BY a.id ".$order_by;

		$result = DB::query(Database::SELECT, $sql)->as_object(true)->execute();
		
		// count number of objects
		$total_objects = count($result);//$query->count_all();
		$view->total_objects = $total_objects;

		//var_dump(Session::instance()->get('kaizen')['parameters']);
		// set-up the pagination
		$view->items_per_page = 60;

		$pagination = Pagination::factory(array(
		    'total_items' => $total_objects,
		    'items_per_page' => $view->items_per_page, // this will override the default set in your config
		    'current_page' => array('source' => 'route', 'key' => 'page', 'page' => Session::instance()->get('kaizen')['parameters']),
		));

		$sql .= ' LIMIT '.$pagination->offset.', '.$pagination->items_per_page;
		

		$result = DB::query(Database::SELECT, $sql)->as_object(true)->execute();

		$view->objectsList = $result; //$query->order_by('title', 'ASC')->offset($pagination->offset)->limit($pagination->items_per_page)->find_all();
		$view->pagination = $pagination;

		//$this->endProfilling();
		if($ajax != null){
			return $view;
		}else{
			header('Content-Type: application/json');
			echo json_encode(
				array(
					array('container' => '#tabs_content', 'type'=>'html', 'content'=> json_encode($view->render())),
					array('container' => '#filtros', 'type'=>'html', 'content'=> json_encode($this->getFiltros()->render())),
					
				)						
			);
	       
	        return false;
	    }
	    
	}    


	public function action_preview($object_id, $ajax = null){
		$this->auto_render = false;

		$view = View::factory('admin/acervo/preview');
		$object = ORM::factory('object', $object_id);
		$view->object = $object;

		$file = (strpos($object->format->ext, 'index') !== FALSE ) ? $object->format->ext : $object->taxonomia.$object->format->ext;
		$file_path = '/public/upload/projetos/'.$object->project->segmento->pasta.'/'.$object->project->pasta.'/'.$object->pasta.'/'.$file;
		//var_dump($file_path);
		if (file_exists(DOCROOT.$file_path)) {
			if($ajax != null){
				echo URL::base().$file_path;
			}else{
				$view->src = URL::base().$file_path;
				echo $view->render();
			}
		} else {
		    echo 0;
		}
	}

	/*
	public function action_acervoPreview($object_id){
		echo $this->action_preview($object_id, true);
	}
	*/

	public function action_download($object_id){
		$this->auto_render = false;

		//$view = View::factory('admin/acervo/preview');
		$object = ORM::factory('object', $object_id);

		$file = (strpos($object->format->ext, 'index') !== FALSE ) ? $object->format->ext : $object->taxonomia.$object->format->ext;
		$file_path = '/public/upload/projetos/'.$object->project->segmento->pasta.'/'.$object->project->pasta.'/'.$object->pasta.'/';
		
		if (file_exists(DOCROOT.$file_path)) {
			$rootPath = realpath(DOCROOT.$file_path);
			
			$zipfilename = $object->taxonomia.'.zip';
			$zip = new ZipArchive();
			$zip->open(DOCROOT.$file_path.'/'.$zipfilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

			// Create recursive directory iterator
			/** @var SplFileInfo[] $files */
			$files = new RecursiveIteratorIterator(
			    new RecursiveDirectoryIterator($rootPath),
			    RecursiveIteratorIterator::LEAVES_ONLY
			);

			foreach ($files as $name => $file)
			{
			    // Skip directories (they would be added automatically)
			    if (!$file->isDir())
			    {
			        // Get real and relative path for current file
			        $filePath = $file->getRealPath();
			        $relativePath = substr($filePath, strlen($rootPath) + 1);

			        // Add current file to archive
			        $zip->addFile($filePath, $relativePath);
			    }
			}

			// Zip archive will be created only after closing object
			$zip->close();

			header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename(DOCROOT.$file_path.'/'.$zipfilename));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize(DOCROOT.$file_path.'/'.$zipfilename));
            ob_clean();
            flush();
            readfile(DOCROOT.$file_path.'/'.$zipfilename);

            unlink(DOCROOT.$file_path.'/'.$zipfilename);

            /*
			header("Content-type: application/zip"); 
			header("Content-Disposition: attachment; filename=$zipfilename");
			header("Content-length: ".filesize(DOCROOT.$file_path.'/'.$zipfilename));
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			readfile(DOCROOT.$file_path.'/'.$zipfilename);
			*/

			//unlink(DOCROOT.$file_path.'/'.$zipfilename);

			/*$filename = "Inferno.zip";
			//$filepath = "/var/www/domain/httpdocs/download/path/";

			// http headers for zip downloads
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"".$zipfilename."\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize(DOCROOT.$file_path.'/'.$zipfilename));
			ob_end_flush();
			@readfile(DOCROOT.$file_path.'/'.$zipfilename);
			*/
		} else {
		    echo 0;
		    return false;
		}		
	}

	public function action_loadKeyWords(){
		$this->auto_render = false;
		ini_set('auto_detect_line_endings',TRUE);
		//get the csv file
	    $file = "planilha_keywords.csv";//$_FILES[csv][tmp_name];
	    $file_path = "public/".$file;

	    if(file_exists(DOCROOT.$file_path)){
	    	$this->auto_render = false;
			$db = Database::instance();
	        $db->begin();
			
			try 
			{    
		    	$fp = fopen($file_path, 'r');

				// get the first (header) line
				$header = fgetcsv($fp,0,";",'"');

				// get the rest of the rows
				$data = array();
				while ($row = fgetcsv($fp,0,";",'"')) {
				  $arr = array();
				  foreach ($header as $i => $col)
				    $arr[$col] = $row[$i];
				  $data[] = $arr;
				}

				foreach ($data as $key => $value) {
					if(strpos($data[$key]['taxonomia'], 'pdf') === false){
						//$objectList = ORM::factory('object')->where('title', '=', $data[$key]['titulo'])->where('keywords', 'IS', NULL)->find();
						$objectList = ORM::factory('object')->where('title', '=', $data[$key]['titulo'])->find();
						if($objectList->id != ''){
							$objectList->sinopse = $data[$key]['descricao'];
							$objectList->keywords = $data[$key]['tema'].','.$data[$key]['keywords'];
							$objectList->save();
							//echo $data[$key]['titulo'].'<br/>';
						}else{
							echo $data[$key]['titulo'].' --- '.$data[$key]['taxonomia'].'<br/>';
						}
					}
				}

				$db->commit();
			}  catch (ORM_Validation_Exception $e) {
	            $errors = $e->errors('models');
				$erroList = '';
				foreach($errors as $erro){
					$erroList.= $erro.'<br/>';	
				}
	            echo 'Houveram alguns erros na validação <br/><br/>'.$erroList;
	            $db->rollback();
	        } catch (Database_Exception $e) {
	            echo 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
	            $db->rollback();
	        }
	    }
	}

	public function action_loadCollections(){
		$this->auto_render = false;
		ini_set('auto_detect_line_endings',TRUE);
		//get the csv file
	    $file = "listas_acervo_moderna_plus_2011.csv";//$_FILES[csv][tmp_name];

	    
	    $file_path = "public/".$file;

	    if(file_exists(DOCROOT.$file_path)){
	    	$db = Database::instance();
	        $db->begin();
			
			try 
			{    
		    	$row = 1;
				$handle = fopen ($file_path,"r");
				while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				    $num = count ($data);
				    echo "<p> $num campos na linha $row: <br /></p>\n";
				    $row++;

				    $new_object = ORM::factory('object');
				    for ($c=0; $c < $num; $c++) {
				    	switch ($c) {
				    		case '0':
				    			$new_object->title = $data[$c];
				    			break;
				    		case '1':
				    			$new_object->taxonomia = $data[$c];
				    			$new_object->pasta = $data[$c];
				    			break;
				    		case '2':
				    			$new_object->project_id = trim(explode('-', $data[$c])[0]);
				    			break;
				    		case '3':
				    			$new_object->collection_id = trim(explode('-', $data[$c])[0]);
				    			break;
				    		case '4':
				    			$new_object->typeobject_id = trim(explode('-', $data[$c])[0]);
				    			break;	
				    		case '5':
				    			$new_object->reaproveitamento = trim(explode('-', $data[$c])[0]);
				    			break;	
				    		case '6':
				    			$new_object->format_id = trim(explode('-', $data[$c])[0]);
				    			break;	
				    		case '7':
				    			$new_object->arq_aberto = trim(explode('-', $data[$c])[0]);
				    			break;
				    		case '8':
				    			$new_object->interatividade = trim(explode('-', $data[$c])[0]);
				    			break;
				    		case '9':
				    			$new_object->cap = trim($data[$c]);
				    			break;
				    		case '10':
				    			$new_object->uni = trim($data[$c]);
				    			break;	
				    		case '11':
				    			$new_object->tamanho = trim($data[$c]);
				    			break;														
				    		case '12':
				    			$new_object->duracao = trim($data[$c]);
				    			break;
				    		case '13':
				    			if(trim($data[$c]) != ''){
				    				$object_source = ORM::factory('object')->where('taxonomia', '=', trim($data[$c]))->find();				
									$new_object->object_id = $object_source->id;	
									$new_object->taxonomia_reap = trim($data[$c]);
				    			};
				    			break;									
				    	}
				    }

				    $new_object->country_id = '1';
				    $new_object->workflow_id = '1';//novos
				    $new_object->uploaded = '1';
				    $new_object->fase = '1';

				    $new_object->crono_date = date("Y-m-d H:i:s"); //date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '18/08/2015')));
			        $new_object->planned_date = date("Y-m-d H:i:s"); //date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '18/08/2015')));
			        $new_object->delivered_date = date("Y-m-d H:i:s");

				    $new_object->save();


					$ini_objectStatus = ORM::factory('objects_statu');
			        $ini_objectStatus->object_id = $new_object->id;
			        $ini_objectStatus->status_id = '1'; //não iniciado
			        $ini_objectStatus->crono_date = date("Y-m-d H:i:s"); //date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '18/08/2015')));
			        $ini_objectStatus->planned_date = date("Y-m-d H:i:s"); //date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '18/08/2015')));
			        $ini_objectStatus->delivered_date = date("Y-m-d H:i:s");
					$ini_objectStatus->userInfo_id = $this->current_user->userInfos->id;	
					$ini_objectStatus->save();

					$objectStatus = ORM::factory('objects_statu');
			        $objectStatus->object_id = $new_object->id;
			        $objectStatus->status_id = '8'; //finalizado
			        $objectStatus->crono_date = date("Y-m-d H:i:s"); //date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '18/08/2015')));
			        $objectStatus->planned_date = date("Y-m-d H:i:s"); //date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '18/08/2015')));
			        $objectStatus->delivered_date = date("Y-m-d H:i:s");
					$objectStatus->userInfo_id = $this->current_user->userInfos->id;	
					$objectStatus->save();
					
					echo $new_object->taxonomia . "<br/>\n";
				}
				fclose ($handle);
				$db->commit();

			}  catch (ORM_Validation_Exception $e) {
	            $errors = $e->errors('models');
				$erroList = '';
				foreach($errors as $erro){
					$erroList.= $erro.'<br/>';	
				}
	            echo 'Houveram alguns erros na validação <br/><br/>'.$erroList;
	            $db->rollback();
	        } catch (Database_Exception $e) {
	            echo 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
	            $db->rollback();
	        }
	    	/*
			$db = Database::instance();
	        $db->begin();
			
			try 
			{    
		    	$fp = fopen($file_path, 'r');

				// get the first (header) line
				$header = fgetcsv($fp,0,";",'"');

				// get the rest of the rows
				$data = array();
				while ($row = fgetcsv($fp,0,";",'"')) {
				  $arr = array();
				  foreach ($header as $i => $col)
				    $arr[$col] = $row[$i];
				  $data[] = $arr;
				}

				foreach ($data as $key => $value) {
					if(strpos($data[$key]['taxonomia'], 'pdf') === false){
						//$objectList = ORM::factory('object')->where('title', '=', $data[$key]['titulo'])->where('keywords', 'IS', NULL)->find();
						$objectList = ORM::factory('object')->where('title', '=', $data[$key]['titulo'])->find();
						if($objectList->id != ''){
							$objectList->sinopse = $data[$key]['descricao'];
							$objectList->keywords = $data[$key]['tema'].','.$data[$key]['keywords'];
							$objectList->save();
							//echo $data[$key]['titulo'].'<br/>';
						}else{
							echo $data[$key]['titulo'].' --- '.$data[$key]['taxonomia'].'<br/>';
						}
					}
				}

				$db->commit();
			}  catch (ORM_Validation_Exception $e) {
	            $errors = $e->errors('models');
				$erroList = '';
				foreach($errors as $erro){
					$erroList.= $erro.'<br/>';	
				}
	            echo 'Houveram alguns erros na validação <br/><br/>'.$erroList;
	            $db->rollback();
	        } catch (Database_Exception $e) {
	            echo 'Houveram alguns erros na base <br/><br/>'.$e->getMessage();
	            $db->rollback();
	        }
	        */
	    }
	}
}