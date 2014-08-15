<div class="list_header round">
	<div class="table_info round">
		<?=count($objectsList)?> objetos encontrados 
		<a class="bar_button round green" href='<?=URL::base();?>admin/objects/'>limpar filtros</a>
	</div>
	<form action="<?=URL::base();?>admin/objects" method="post" class="form">
		<div class="filters">
			<!--div class="left">
				<input type="text" class="round left" style="width:135px" name="taxonomia" placeholder="taxonomia" value="<?=$filter_taxonomia?>" >
       			<input type="submit" class="round bar_button left" value="OK"> 
       		</div-->

       		<div class="filter" >
			    <ul>
			        <li class="round" >
			            <span class="round" id="colecao">coleção <?=(!empty($filter_collection) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
			            <ul class="round" style="width:400px;" >
			                <? foreach ($collectionList as $json_collection) { $collection = json_decode($json_collection);?>
			                	<li>
			                		<input type="checkbox" name="collection[]" value="<?=$collection->collection_id?>" id="col_<?=$collection->collection_id?>" <?=(in_array($collection->collection_id, $filter_collection)) ? "checked" : ""?> />
			                		<label for="col_<?=$collection->collection_id?>"><?=$collection->collection_name?></label>
			                	</li>
			                <?}?>
			                <p>
				                <input type="submit" class="round bar_button" value="OK" /> 
				                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
				            </p> 
			            </ul>
			        </li>
			    </ul>
			</div>

			<div class="filter" >
			    <ul>
			        <li class="round" >
			            <span class="round" id="colecao">matéria <?=(!empty($filter_materia) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
			            <ul class="round" >
				                <?foreach ($materiasList as $json_materia) { $materia = json_decode($json_materia);?>
				                	<li>
				                		<input type="checkbox" name="materia[]" value="<?=$materia->materia_id?>" id="mat_<?=$materia->materia_id?>" <?=(in_array($materia->materia_id, $filter_materia)) ? "checked" : ""?> />
				                		<label for="mat_<?=$materia->materia_id?>"><?=$materia->materia_name?></label>
				                	</li>
				                <?}?>
				                <p>
					                <input type="submit" class="round bar_button" value="OK" /> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
					            </p>
			            </ul>
			        </li>
			    </ul>
			</div>

			

			<div class="filter" >
			    <ul>
			        <li class="round" >
			            <span class="round" id="status">status <?=(!empty($filter_status) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
			            <ul class="round" >
			                <? foreach ($statusList as $json_status) { $status = json_decode($json_status);?>
			                	<li>
			                		<input type="checkbox" name="status[]" value="<?=$status->status_id?>" id="sta_<?=$status->status_id?>" <?=(in_array($status->status_id, $filter_status)) ? "checked" : ""?> />
			                		<label for="sta_<?=$status->status_id?>" ><?=$status->statu_status?></label>
			                	</li>
			                <?}?>
			                <p>
				                <input type="submit" class="round bar_button" value="OK" /> 
				                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
				            </p> 
			            </ul>
			        </li>
			    </ul>
			</div>

			<div class="filter" >
			    <ul>
			        <li class="round" >
			            <span id="supplier">produtora <?=(!empty($filter_supplier) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
			            <ul class="round" >
			                <? foreach ($suppliersList as $json_supplier) { $supplier = json_decode($json_supplier);?>
			                <li>
			                	<input type="checkbox" name="supplier[]" value="<?=$supplier->supplier_id?>" id="s_<?=$supplier->supplier_id?>" <?=(in_array($supplier->supplier_id, $filter_supplier)) ? "checked" : ""?> />
			                	<label for="s_<?=$supplier->supplier_id?>"><?=$supplier->supplier_empresa?></label>
			                </li>
			                <?}?>
			                <p>
				                <input type="submit" class="round bar_button" value="OK" /> 
				                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
				            </p>
			            </ul>
			        </li>
			    </ul>
			</div>

			<div class="filter" >
			    <ul>
			        <li class="round" >
			        	<span id="tipo">tipo <?=(!empty($filter_tipo) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
			            <ul class="round" >				            	
				                <? foreach ($typeObjectsList as $json_typeobject) {
				                	$typeobject = json_decode($json_typeobject);
				                ?>
				                	<li><input type="checkbox" name="tipo[]" value="<?=$typeobject->typeobject_id?>" id="t_<?=$typeobject->typeobject_id?>" <?=(in_array($typeobject->typeobject_id, $filter_tipo)) ? "checked" : ""?>><label for="t_<?=$typeobject->typeobject_id?>"><?=$typeobject->typeobject_name?></label></li>
				                <?}?>
				                <p>
					                <input type="submit" class="round bar_button" value="OK" /> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
					            </p>
			            </ul>
			        </li>
			    </ul>
			</div>

			<div class="filter" >
			    <ul>
			        <li class="round" >
			            <span id="reaproveitamento">origem <?=(!empty($filter_origem) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
			            <ul class="round" >
			                <li><input type="checkbox" name="origem[]" value="0" id="o_0" <?=(in_array("0", $filter_origem)) ? "checked" : ""?>><label for="o_0">novo</label></li>
			                <li><input type="checkbox" name="origem[]" value="1" id="o_1" <?=(in_array("1", $filter_origem)) ? "checked" : ""?>><label for="o_1">reap.</label></li>
			                
			                <p>
				                <input type="submit" class="round bar_button" value="OK" /> 
				                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
				            </p>
			            </ul>
			        </li>
			    </ul>
			</div>
		</div>
	</form>	
</div>
<div class="list_body">
    <? 
	if(count($objectsList) <= 0){
		echo '<span class="list_alert round">nenhum registro encontrado</span>';	
	}else{
	?>
	<ul class="list_item">
		<?foreach($objectsList as $objeto){
			$status = "";
    		$tag = "";
			
			switch($objeto->status_id){
    			case 1:
    				if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
            			$class_obj = "object_late";
            		}else{
        				$class_obj 	= $objeto->statu_class;
        			}
    				break;
    			case 2:
    				$mod = "";
    				if($objeto->supplier_id != 10){//producao externa
    					$mod = "_out";	
    				}else{
    					$mod = "_in"; 
    				}

    				if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
            			$class_obj = "object_late";
            		}else{
        				$class_obj 	= $objeto->statu_class.$mod;
        			}


        			if(is_object($objeto->getStatus($objeto->object_status_id))){
		    			$obj_taskView = $objeto->getStatus($objeto->object_status_id); 
		    			
		    			if($obj_taskView->tag->id == '7' && $obj_taskView->status->id == '7'){
		    				$status = "";
		    				$tag = "";
				    	}else{
				    		$status = '<span class="round '.$obj_taskView->status->class.' list_faixa">'.$obj_taskView->status->status.'</span>';
			    			$tag = '<span class="round list_faixa '.$obj_taskView->tag->class.'">'.$obj_taskView->tag->tag.'</span>';	
			    		}
		    		}
   				
    				break;
    			case 8://finalizado
    				$class_obj 	= $objeto->statu_class;
    				$class 		= $objeto->statu_class;
    				break;	
    			default:
    				if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
            			$class_obj = "object_late";
            		}else{
        				$class_obj 	= $objeto->statu_class;
        			}
    		}
    		//href="
		?>
		<li>

			<a class="load" href="#" data-url="<?=URL::base().'admin/objects/view/'.$objeto->id?>" title="Editar">
				<div>
					<p><b><?=$objeto->taxonomia?></b></p>
					<p><?=$objeto->title?></p>
					<p>retorno: <?=Utils_Helper::data($objeto->retorno,'d/m/Y')?> - fechamento: <?=Utils_Helper::data($objeto->collection_fechamento,'d/m/Y')?></p>
					<p><?=$objeto->supplier_empresa?></p>
					<p>
						<span class="<?=$class_obj?> round list_faixa"><?=$objeto->statu_status?> &bull; <?=$objeto->prova?></span>
						
						
						<?=$tag;?>
						<?=$status;?>
					</p>
				</div>
			</a>
		</li>
		<?}?>
	</ul>
	<?}?>
</div>