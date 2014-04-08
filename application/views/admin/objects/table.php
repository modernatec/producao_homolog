
<table class="list">
		<thead>
			<form action="<?=URL::base();?>admin/objects" method="post" class="form">
			<th width="250">
				<div class="filter" >
				    <ul>
				        <li class="round" >
				            <span id="tipo">taxonomia <?=(!empty($filter_taxonomia) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <ul class="round" >
				            		<li><input type="text" class="round" style="width:135px" name="taxonomia" value="<?=$filter_taxonomia?>" ></li>
					                
					                <input type="submit" class="round bar_button" value="OK"> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>

				</div>
			</th>
            <th width="50">
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
					                <input type="submit" class="round bar_button" value="OK"> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>

				</div>
            </th>
            <th width="20">
            	<div class="filter" >
				    <ul>
				        <li class="round" >
				            <span id="reaproveitamento">origem <?=(!empty($filter_origem) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <ul class="round" >
				                <li><input type="checkbox" name="origem[]" value="0" id="o_0" <?=(in_array("0", $filter_origem)) ? "checked" : ""?>><label for="o_0">novo</label></li>
				                <li><input type="checkbox" name="origem[]" value="1" id="o_1" <?=(in_array("1", $filter_origem)) ? "checked" : ""?>><label for="o_1">reap.</label></li>
				                
				                <input type="submit" class="round bar_button" value="OK"> 
				                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>
				</div>
			</th>
            <th width="100">
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
					                <input type="submit" class="round bar_button" value="OK" /> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
				            </ul>
				        </li>
				    </ul>

				</div>
            </th>
            <th width="50">
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
					                <input type="submit" class="round bar_button" value="OK"> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>
				</div>
            </th>
            <th width="300">
            	<div class="filter" >
				    <ul>
				        <li class="round" >
				            <span class="round" id="colecao">coleção <?=(!empty($filter_collection) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <ul class="round" >
					                <? foreach ($collectionList as $json_collection) { $collection = json_decode($json_collection);?>
					                	<li style="width:300px">
					                		<input type="checkbox" name="collection[]" value="<?=$collection->collection_id?>" id="col_<?=$collection->collection_id?>" <?=(in_array($collection->collection_id, $filter_collection)) ? "checked" : ""?> />
					                		<label for="col_<?=$collection->collection_id?>"><?=$collection->collection_name?></label>
					                	</li>
					                <?}?>
					                <input type="submit" class="round bar_button" value="OK"> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>
				</div>
            </th>
            <th width="50">
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
					                <input type="submit" class="round bar_button" value="OK"> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>
				</div>
			</th>
			<th width="50">retorno</th>
            <th width="50">fechamento</th>
            </form>
		</thead>
		<tbody>
            <? foreach($objectsList as $objeto){?>
            <tr>
            	<? 
            		switch($objeto['status_id']){
            			case 1:
            				if(strtotime($objeto['retorno']) < strtotime(date("Y-m-d H:i:s"))){
		            			$class_obj = "object_late";
		            		}else{
	            				$class_obj 	= $objeto['statu_class'];
	            			}
            				break;
            			case 2:
            				$mod = "";
            				if($objeto['supplier_id'] != 10){//producao externa
            					$mod = "_out";	
            				}else{
            					$mod = "_in"; 
            				}

            				if(strtotime($objeto['retorno']) < strtotime(date("Y-m-d H:i:s"))){
		            			$class_obj = "object_late";
		            		}else{
	            				$class_obj 	= $objeto['statu_class'].$mod;
	            			}
           				
            				break;
            			case 8://finalizado
            				$class_obj 	= $objeto['statu_class'];
            				$class 		= $objeto['statu_class'];
            				break;	
            			default:
            				if(strtotime($objeto['retorno']) < strtotime(date("Y-m-d H:i:s"))){
		            			$class_obj = "object_late";
		            		}else{
	            				$class_obj 	= $objeto['statu_class'];
	            			}
            		}
            	?>
                <td class="<?=$class_obj?>">
                    <a href="<?=URL::base().'admin/objects/view/'.$objeto['id'];?>" title="Editar"><?=$objeto['taxonomia']?> <br/><?=$objeto['title']?></a>
                </td>
                <td class="<?=$class_obj?>"><?=$objeto['typeobject_name']?></td>
                <td class="<?=$class_obj?>"><?=($objeto['reaproveitamento'] == '1') ? "reap." : "novo"?></td>
                <td class="<?=$class_obj?>"><?=$objeto['supplier_empresa']?></td>
                <td class="<?=$class_obj?>"><?=$objeto['materia_name']?></td>
                <td class="<?=$class_obj?>"><?=$objeto['collection_name']?></td>
                <td class="<?=$class_obj?>"><?=$objeto['statu_status']?></td>                
                <td class="<?=$class_obj?>"><?=Utils_Helper::data($objeto['retorno'],'d/m/Y')?></td>
                
                <td class="<?=$class_obj?>"><?=Utils_Helper::data($objeto['crono_date'],'d/m/Y')?></td>
			</tr>
            <?}?>
		</tbody>
	</table>