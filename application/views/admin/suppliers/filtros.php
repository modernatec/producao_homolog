<div class="filters clear">
	<form action="<?=URL::base();?>admin/suppliers/getSuppliers" id="frm_suppliers" data-panel="#tabs_content" method="post" class="form">
		<input type="hidden" name="suppliers_filter" value="true">
			<div class="left" style="margin-bottom:4px;">
				<input type="text" class="round" style="width:310px" placeholder="empresa ou contato" name="empresa" value="<?=@$filter_empresa?>" >
	   		</div>
	   		<div class="filter" >
			    <ul>
			        <li class="round" >
			            <span class="round" id="team">time <?=(!empty($filter_team) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
			            <div class="filter_panel round" data-bottom="false">
				            <ul>
				                <? foreach ($teamList as $team) {?>
				                	<li>
				                		<input type="checkbox" name="filter_team[]" value="<?=$team->id?>" id="time_<?=$team->id?>" <?if(isset($filter_team)){ if(in_array($team->id, $filter_team)){ echo "checked";}}?>  />
				                		<label for="time_<?=$team->id?>" ><?=$team->name?></label>
				                	</li>
				                <?}?>
				                <p>
					                <input type="submit" class="round bar_button" value="OK" /> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
					            </p> 
				            </ul>
				        </div>
			        </li>
			    </ul>
			</div>
			<div class="filter" >
			    <ul>
			        <li class="round" >
			            <span class="round" id="team">status <?=(!empty($filter_status) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
			            <div class="filter_panel round" data-bottom="false">
				            <ul>
				                <li><input type="checkbox" class="filter_status" name="filter_status[]" value="1" id="o_1" <?if(isset($filter_status)){ if(in_array("1", $filter_status)){ echo "checked";}}?> ><label for="o_1">aprovados</label></li>
				                <li><input type="checkbox" class="filter_status" name="filter_status[]" value="0" id="o_0" <?if(isset($filter_status)){ if(in_array("0", $filter_status)){ echo "checked";}}?> ><label for="o_0">reprovados</label></li>
				                <p>
					                <input type="submit" class="round bar_button" value="OK" /> 
					                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
					            </p> 
				            </ul>
				        </div>
			        </li>
			    </ul>
			</div>
		<input type="submit" class="round bar_button left" value="buscar">        	
	</form>	
	<form action='<?=URL::base();?>admin/suppliers/getSuppliers' id="frm_reset_suppliers" data-panel="#tabs_content" method="post" class="form">
		<input type="hidden" name="suppliers_filter" value="true">
		<input type="submit" class="bar_button round" value="limpar filtros" />
	</form>

</div>