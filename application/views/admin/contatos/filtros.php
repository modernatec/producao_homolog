<div class="filters clear">
<form action="<?=URL::base();?>admin/contatos/getContatos" id="frm_suppliers" data-panel="#tabs_content" method="post" class="form">
	<input type="hidden" name="contatos" value="true">
		<div class="left" style="margin-bottom:4px;">
			<input type="text" class="round" style="width:310px" placeholder="nome ou email" name="nome" value="<?=@$filter_nome?>" >
   		</div>
   		<div class="filter" >
		    <ul>
		        <li class="round">
		            <span class="round" id="service_id">tipo <?=(!empty($filter_service_id) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
		            <div class="filter_panel round" data-bottom="false">
			            <ul>
			                <? foreach ($services as $service) {?>
			                	<li>
			                		<input type="checkbox" name="service_id[]" value="<?=$service->id?>" id="service_<?=$service->id?>" <?if(isset($filter_service_id)){ if(in_array($service->id, $filter_service_id)){ echo "checked";}}?>  />
			                		<label for="service_<?=$service->id?>" ><?=$service->name?></label>
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
	<input type="submit" class="round bar_button left" value="buscar">        	
</form>	
<form action='<?=URL::base();?>admin/contatos/getContatos' id="frm_reset_contatos" data-panel="#tabs_content" method="post" class="form">
	<input type="hidden" name="contatos" value="true">
	<input type="submit" class="bar_button round green" value="limpar filtros" />
</form>

</div>