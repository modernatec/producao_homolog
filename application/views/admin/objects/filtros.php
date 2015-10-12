<div class="second_filter filters clear">
<form action='<?=URL::base();?>admin/objects/getObjects' id="frm_oeds" data-panel="#tabs_content" method="post" class="form">
		<input type="hidden" name="objects" value="1">
		<div class="left">
			<input type="text" class="round left" style="width:135px" name="filter_taxonomia" placeholder="tax. ou título" value="<?=@$filter_taxonomia?>" >
   		</div>
   		<div class="filter" >
		    <ul>
		        <li class="round" >
		            <span class="round" id="projects">projetos <div class="icon_filtros <?=(!empty($filter_project)) ? 'icon_filter_active': 'icon_filter';?>"></div></span>
		            <span class="filter_panel_arrow"/>
		            <div class="filter_panel round " >
		            	<ul style="width:200px;">
			                <li ><input type="checkbox" class="checkAll" id="filter_project" /><label for="filter_project" class="text_cyan">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
			            	<ul>
				                <?foreach ($projectsList as $project) {?>
				                	<li>
				                		<input class="filter_project" type="checkbox" name="filter_project[]" value="<?=$project->id?>" id="proj_<?=$project->id?>" <?if(isset($filter_project)){ if(in_array($project->id, $filter_project)){ echo "checked";}}?> />
				                		<label for="proj_<?=$project->id?>"><?=$project->name?></label>
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
		            <span class="round" id="materia">matéria <div class="icon_filtros <?=(!empty($filter_materia)) ? 'icon_filter_active': 'icon_filter';?>"></div></span>
		            <span class="filter_panel_arrow"/>
		            <div class="filter_panel round " >
		            	<ul style="width:200px;">
			                <li><input type="checkbox" class="checkAll" id="filter_materia" /><label for="filter_materia" class="text_cyan">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
			            	<ul>
				                <?foreach ($materiasList as $materia) {?>
				                	<li>
				                		<input class="filter_materia" type="checkbox" name="filter_materia[]" value="<?=$materia->id?>" id="mat_<?=$materia->id?>" <?if(isset($filter_materia)){ if(in_array($materia->id, $filter_materia)){ echo "checked";}}?> />
				                		<label for="mat_<?=$materia->id?>"><?=$materia->name?></label>
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
		            <span class="round" id="colecao">coleção <div class="icon_filtros <?=(!empty($filter_collection)) ? 'icon_filter_active': 'icon_filter';?>"></div></span>
		            <span class="filter_panel_arrow"/>
		            <div class="filter_panel round">
			            <ul style="width:550px;">
			                <li><input type="checkbox" class="checkAll" id="filter_collection" /><label for="filter_collection" class="text_cyan">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
				            <ul>
				                <? foreach ($collectionList as $collection){?>
				                	<li>
				                		<input class="filter_collection" type="checkbox" name="filter_collection[]" value="<?=$collection->id?>" id="col_<?=$collection->id?>" <?if(isset($filter_collection)){ if(in_array($collection->id, $filter_collection)){ echo "checked";}}?> />
				                		<label for="col_<?=$collection->id?>"><?=$collection->name?></label>
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
		            <span class="round" id="status">status <div class="icon_filtros <?=(!empty($filter_status)) ? 'icon_filter_active': 'icon_filter';?>"></div></span>
		            <span class="filter_panel_arrow"/>
		            <div class="filter_panel round" >
			            <ul>
			            	<li><input type="checkbox" class="checkAll" id="filter_status" /><label for="filter_status" class="text_cyan">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
				            <ul >
				                <? foreach ($statusList as $status) {?>
				                	<li>
				                		<input type="checkbox" class="filter_status" name="filter_status[]" value="<?=$status->id?>" id="sta_<?=$status->id?>" <? if(isset($filter_status)){ if(in_array($status->id, $filter_status)){ echo "checked";}}?> />
				                		<label for="sta_<?=$status->id?>" ><?=$status->status?></label>
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
		            <span id="supplier">produtora <div class="icon_filtros <?=(!empty($filter_supplier)) ? 'icon_filter_active': 'icon_filter';?>"></div></span>
		            <span class="filter_panel_arrow"/>
		            <div class="filter_panel round " >
			            <ul>
			            	<li><input type="checkbox" class="checkAll" id="filter_supplier" /><label for="filter_supplier" class="text_cyan">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
				            <ul>
				                <? foreach ($suppliersList as $supplier) {?>
				                <li>
				                	<input class="filter_supplier" type="checkbox" name="filter_supplier[]" value="<?=$supplier->id?>" id="s_<?=$supplier->id?>" <?if(isset($filter_supplier)){ if(in_array($supplier->id, $filter_supplier)){ echo "checked";}}?> />
				                	<label for="s_<?=$supplier->id?>"><?=$supplier->empresa?></label>
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
		        	<span id="tipo">tipo <div class="icon_filtros <?=(!empty($filter_tipo)) ? 'icon_filter_active': 'icon_filter';?>"></div></span>
		            <span class="filter_panel_arrow"/>
		            <div class="filter_panel round " >
		            	<ul style="width:300px;">	
			            	<li><input type="checkbox" class="checkAll" id="filter_tipo" /><label for="filter_tipo" class="text_cyan">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
			            	<ul>	
				                <? foreach ($typeObjectsList as $typeobject) {?>
				                	<li><input class="filter_tipo" type="checkbox" name="filter_tipo[]" value="<?=$typeobject->id?>" id="t_<?=$typeobject->id?>" <?if(isset($filter_tipo)){ if(in_array($typeobject->id, $filter_tipo)){ echo "checked";}}?> ><label for="t_<?=$typeobject->id?>"><?=$typeobject->name?></label></li>
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
		            <span id="reaproveitamento">origem <div class="icon_filtros <?=(!empty($filter_origem)) ? 'icon_filter_active': 'icon_filter';?>"></div></span>
		            <span class="filter_panel_arrow"/>
		            <div class="filter_panel round " >
			            <ul>
			            	<li><input type="checkbox" class="checkAll" id="filter_origem" /><label for="filter_origem" class="text_cyan">selecionar tudo</label></li>
			            </ul>
			            <div class="scrollable_content" data-bottom="false">
				            <ul>
				                <li><input type="checkbox" class="filter_origem" name="filter_origem[]" value="0" id="o_0" <?if(isset($filter_origem)){ if(in_array("0", $filter_origem)){ echo "checked";}}?> ><label for="o_0">novo</label></li>
				                <li><input type="checkbox" class="filter_origem" name="filter_origem[]" value="1" id="o_1" <?if(isset($filter_origem)){ if(in_array("1", $filter_origem)){ echo "checked";}}?> ><label for="o_1">reap.</label></li>
				                <li><input type="checkbox" class="filter_origem" name="filter_origem[]" value="2" id="o_2" <?if(isset($filter_origem)){ if(in_array("2", $filter_origem)){ echo "checked";}}?> ><label for="o_2">reap. integral</label></li>
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
		<input type="submit" class="round bar_button left" value="buscar"> 
	</form>		
	<div class="left">
		<form action='<?=URL::base();?>admin/objects/getObjects' id="frm_reset_oeds" data-panel="#tabs_content" method="post" class="form">
			<input type="hidden" name="objects" value="1">
			<input type="submit" class="bar_button round" value="limpar filtros" />
		</form>
	</div>
</div>