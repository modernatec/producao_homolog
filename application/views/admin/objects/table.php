
<table class="list">
		<thead>
			<form action="<?=URL::base();?>admin/objects" method="post" class="form">
			<th width="250" colspan="2">
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
				            	
					                <? foreach ($typeObjectsjsList as $typeobject) {?>
					                <li><input type="checkbox" name="tipo[]" value="<?=$typeobject->typeobject->id?>" id="t_<?=$typeobject->typeobject->id?>" <?=(in_array($typeobject->typeobject->id, $filter_tipo)) ? "checked" : ""?>><label for="t_<?=$typeobject->typeobject->id?>"><?=$typeobject->typeobject->name?></label></li>
					                <?}?>
					                <input type="submit" class="round bar_button" value="OK"> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>

				</div>
            </th>
            <th >
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
					                <? foreach ($suppliersList as $supplier) {?>
					                <li><input type="checkbox" name="supplier[]" value="<?=$supplier->supplier->id?>" id="s_<?=$supplier->supplier->id?>" <?=(in_array($supplier->supplier->id, $filter_supplier)) ? "checked" : ""?>><label for="s_<?=$supplier->supplier->id?>"><?=$supplier->supplier->empresa?></label></li>
					                <?}?>
					                <input type="submit" class="round bar_button" value="OK"> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>

				</div>
            </th>
            <th>
            	<div class="filter" >
				    <ul>
				        <li class="round" >
				            <span class="round" id="colecao">matéria <?=(!empty($filter_materia) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <ul class="round" >
					                <? foreach ($materiasList as $materia) {?>
					                <li ><input type="checkbox" name="materia[]" value="<?=$materia->materia_id?>" id="=m_<?=$materia->id?>" <?=(in_array($materia->materia_id, $filter_materia)) ? "checked" : ""?>><label for="m_<?=$materia->id?>"><?=$materia->collection->materia->name?></label></li>
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
					                <? foreach ($collectionList as $collection) {?>
					                <li style="width:400px"><input type="checkbox" name="collection[]" value="<?=$collection->id?>" id="c_<?=$collection->id?>" <?=(in_array($collection->id, $filter_collection)) ? "checked" : ""?>><label for="c_<?=$collection->id?>"><?=$collection->collection->name?></label></li>
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
					                <? foreach ($statusList as $status) {?>
					                <li><input type="checkbox" name="status[]" value="<?=$status->statu->id?>" id="s_<?=$status->statu->id?>" <?=(in_array($status->statu->id, $filter_status)) ? "checked" : ""?>><label for="s_<?=$status->statu->id?>" ><?=$status->statu->status?></label></li>
					                <?}?>
					                <input type="submit" class="round bar_button" value="OK"> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>
				</div>
			</th>
			<th>retorno</th>
            
            
            <th>fechamento</th>
            </form>
		</thead>
		<tbody>
            <? foreach($objectsList as $objeto){?>
            <tr>
            	<? if($objeto->task_open > 0 or $objeto->statu->id == 1){
            			$class="task_open";
            			$value = $objeto->task_open;
            		}elseif($objeto->task_init > 0){
        				$class="task_started";
        				$value = $objeto->task_init;            			
            		}elseif($objeto->task_init == 0 && $objeto->task_open == 0 && $objeto->statu->id == 2){
            			$class="task_finished";
        				$value = "0";   
            		}

            		if($objeto->statu->id == 8){
            			$class_obj = $objeto->statu->class;
            			$class= $objeto->statu->class;;
        				$value = ""; 
            		}elseif($objeto->statu->id == 3){
            			if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
	            			$class_obj = "object_late";
	            			$class = "object_late";
	            		}else{
	            			$class_obj = $objeto->statu->class;
	            			$class= $objeto->statu->class;
	        				$value = ""; 
	            		}

            		}elseif(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
            			$class_obj = "object_late";
            		}else{
            			$class_obj = "";
            		}
            	?>
            	<td style="width:5px" class="<?=$class?>"><?=$value?></td>
                <td class="<?=$class_obj?>">
                    <a href="<?=URL::base().'admin/objects/view/'.$objeto->id;?>" title="Editar"><?=$objeto->taxonomia?> <br/><?=$objeto->title?></a>
                </td>
                <td class="<?=$class_obj?>"><?=$objeto->typeobject->name?></td>
                <td class="<?=$class_obj?>"><?=($objeto->reaproveitamento == '1') ? "reap." : "novo"?></td>
                <td class="<?=$class_obj?>"><?=$objeto->supplier->empresa?></td>
                <td class="<?=$class_obj?>"><?=$objeto->collection->materia->name?></td>
                <td class="<?=$class_obj?>"><?=$objeto->collection->name?></td>
                <td class="<?=$class_obj?>"><?=$objeto->statu->status?></td>                
                <td class="<?=$class_obj?>"><?=Utils_Helper::data($objeto->retorno,'d/m/Y')?></td>
                
                <td class="<?=$class_obj?>"><?=Utils_Helper::data($objeto->crono_date,'d/m/Y')?></td>
			</tr>
            <?}?>
		</tbody>
	</table>