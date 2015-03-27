<div class="filters clear">
<form action='<?=URL::base();?>admin/objects/getObjects/<?=$project_id?>' id="frm_oeds" data-panel="#tabs_content" method="post" class="form">
		<input type="hidden" name="project_id" value="<?=$project_id?>">
		<div class="left">
			<input type="text" class="round left" style="width:135px" name="taxonomia" placeholder="tax. ou título" value="<?=@$filter_taxonomia?>" >
   			<input type="submit" class="round bar_button left" value="buscar"> 
   		</div>
   		<div class="left">
				<form action='<?=URL::base();?>admin/objects/getObjects/<?=$project_id?>' id="frm_reset_oeds" data-panel="#tabs_content" method="post" class="form">
					<input type="hidden" name="reset_form" value="true">
					<input type="submit" class="bar_button round green" value="limpar filtros" />
				</form>
			</div>
   		<div class="filter" >
		    <ul>
		        <li class="round" >
		            <span class="round" id="colecao">coleção <?=(isset($filter_collection) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
		            <div class="filter_panel round">
			            <ul style="width:320px;">
			                <li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_collection" /><label for="filter_collection">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
				            <ul style="width:320px;">
				                <? foreach ($collectionList as $json_collection) { $collection = json_decode($json_collection);?>
				                	<li>
				                		<input class="filter_collection" type="checkbox" name="collection[]" value="<?=$collection->collection_id?>" id="col_<?=$collection->collection_id?>" <?if(isset($filter_collection)){ if(in_array($collection->collection_id, $filter_collection)){ echo "checked";}}?> />
				                		<label for="col_<?=$collection->collection_id?>"><?=$collection->collection_name?></label>
				                	</li>
				                <?}?>						                
				            </ul>
			            </div>
			            <p>
			                <input type="submit" class="round bar_button" value="buscar" /> 
                        	<input type="button" class="round bar_button cancelar" value="cancelar" />  
			            </p> 
			        </div>
		        </li>
		    </ul>
		</div>
		<div class="filter" >
		    <ul>
		        <li class="round" >
		            <span class="round" id="colecao">matéria <?=(isset($filter_materia) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
		            <div class="filter_panel round " >
		            	<ul>
			                <li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_materia" /><label for="filter_materia">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
			            	<ul>
				                <?foreach ($materiasList as $json_materia) { $materia = json_decode($json_materia);?>
				                	<li>
				                		<input class="filter_materia" type="checkbox" name="materia[]" value="<?=$materia->materia_id?>" id="mat_<?=$materia->materia_id?>" <?if(isset($filter_materia)){ if(in_array($materia->materia_id, $filter_materia)){ echo "checked";}}?> />
				                		<label for="mat_<?=$materia->materia_id?>"><?=$materia->materia_name?></label>
				                	</li>
				                <?}?>
			            	</ul>
			            </div>
		            	<p>
			                <input type="submit" class="round bar_button" value="buscar" /> 
                        	<input type="button" class="round bar_button cancelar" value="cancelar" />  
			            </p>
		            </div>
		        </li>
		    </ul>
		</div>
		<div class="filter" >
		    <ul>
		        <li class="round" >
		            <span class="round" id="status">status <?=(isset($filter_status) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
		            <div class="filter_panel round" >
			            <ul>
			            	<li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_status" checked /><label for="filter_status">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
				            <ul >
				                <? foreach ($statusList as $json_status) { $status = json_decode($json_status);?>
				                	<li>
				                		<input type="checkbox" class="filter_status" name="status[]" value="<?=$status->status_id?>" id="sta_<?=$status->status_id?>" <? if(isset($filter_status)){ if(in_array($status->status_id, $filter_status)){ echo "checked";}}?> />
				                		<label for="sta_<?=$status->status_id?>" ><?=$status->statu_status?></label>
				                	</li>
				                <?}?>						                
				            </ul>
				        </div>
			            <p>
			                <input type="submit" class="round bar_button" value="buscar" /> 
                        	<input type="button" class="round bar_button cancelar" value="cancelar" /> 
			            </p> 
		            </div>
		        </li>
		    </ul>
		</div>

		<div class="filter" >
		    <ul>
		        <li class="round" >
		            <span id="supplier">produtora <?=(isset($filter_supplier) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
		            <div class="filter_panel round " >
			            <ul>
			            	<li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_supplier" /><label for="filter_supplier">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
				            <ul>
				                <? foreach ($suppliersList as $json_supplier) { $supplier = json_decode($json_supplier);?>
				                <li>
				                	<input class="filter_supplier" type="checkbox" name="supplier[]" value="<?=$supplier->supplier_id?>" id="s_<?=$supplier->supplier_id?>" <?if(isset($filter_supplier)){ if(in_array($supplier->supplier_id, $filter_supplier)){ echo "checked";}}?> />
				                	<label for="s_<?=$supplier->supplier_id?>"><?=$supplier->supplier_empresa?></label>
				                </li>
				                <?}?>					                
				            </ul>
			            </div>
			            <p>
			                <input type="submit" class="round bar_button" value="buscar" /> 
                        	<input type="button" class="round bar_button cancelar" value="cancelar" />  
			            </p>
		            </div>
		        </li>
		    </ul>
		</div>

		<div class="filter" >
		    <ul>
		        <li class="round" >
		        	<span id="tipo">tipo <?=(isset($filter_tipo) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
		            <div class="filter_panel round " >
		            	<ul>	
			            	<li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_tipo" /><label for="filter_tipo">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
			            	<ul>	
				                <? foreach ($typeObjectsList as $json_typeobject) {
				                	$typeobject = json_decode($json_typeobject);
				                ?>
				                	<li><input class="filter_tipo" type="checkbox" name="tipo[]" value="<?=$typeobject->typeobject_id?>" id="t_<?=$typeobject->typeobject_id?>" <?if(isset($filter_tipo)){ if(in_array($typeobject->typeobject_id, $filter_tipo)){ echo "checked";}}?> ><label for="t_<?=$typeobject->typeobject_id?>"><?=$typeobject->typeobject_name?></label></li>
				                <?}?>
				                
			            	</ul>
		            	</div>
		            	<p>
			                <input type="submit" class="round bar_button" value="buscar" /> 
                        	<input type="button" class="round bar_button cancelar" value="cancelar" />  
			            </p>
		            </div>
		        </li>
		    </ul>
		</div>

		<div class="filter" >
		    <ul>
		        <li class="round" >
		            <span id="reaproveitamento">origem <?=(isset($filter_origem) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
		            <div class="filter_panel round " >
			            <ul>
			            	<li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_origem" /><label for="filter_origem">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
				            <ul>
				                <li><input type="checkbox" class="filter_origem" name="origem[]" value="0" id="o_0" <?if(isset($filter_origem)){ if(in_array("0", $filter_origem)){ echo "checked";}}?> ><label for="o_0">novo</label></li>
				                <li><input type="checkbox" class="filter_origem" name="origem[]" value="1" id="o_1" <?if(isset($filter_origem)){ if(in_array("1", $filter_origem)){ echo "checked";}}?> ><label for="o_1">reap.</label></li>
				                <li><input type="checkbox" class="filter_origem" name="origem[]" value="2" id="o_2" <?if(isset($filter_origem)){ if(in_array("2", $filter_origem)){ echo "checked";}}?> ><label for="o_2">reap. integral</label></li>
				            </ul>
			            </div>
			            <p>
			                <input type="submit" class="round bar_button" value="buscar" /> 
                        	<input type="button" class="round bar_button cancelar" value="cancelar" />  
			            </p>
		            </div>
		        </li>
		    </ul>
		</div>
	
</form>	
</div>