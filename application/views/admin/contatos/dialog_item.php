<div class="filters clear">
	<form action="<?=URL::base();?>admin/contatos/getListContatos" id="frm_listContatos" data-panel="#contatosList" method="post" class="form">
		<input type="hidden" name="contatos" value="true">
			<div class="left" style="margin-bottom:4px;">
				<input type="text" class="round" style="width:150px" placeholder="nome ou email" name="filter_nome" value="<?=@$filter_nome?>" >
	   		</div>
	   		<div class="filter" >
	            <ul>
	                <li class="round">
	                    <span class="round" id="tipo">tipo 2 <div class="icon_filtros <?=(!empty($filter_service_id)) ? 'icon_filter_active': 'icon_filter';?>"></span>
	                    <span class="filter_panel_arrow"/>
	                    <div class="filter_panel round">
	                        <ul>
                                <li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_tipo" /><label for="filter_tipo">selecionar tudo</label></li>
                            </ul>
	                        <div class="scrollable_content" data-bottom="false">
	                            <ul>
	                                <?foreach ($services as $service) {?>
	                                <li>
	                                    <input class="filter_tipo" type="checkbox" name="filter_service_id[]" value="<?=$service->id?>" id="col_<?=$service->id?>" <?if(isset($filter_service_id)){ if(in_array($service->id, $filter_service_id)){ echo "checked";}}?>  />
	                                    <label for="col_<?=$service->id?>"><?=$service->name?></label>
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
	   		
	   		
		<input type="submit" class="round bar_button left" value="buscar">        	
	</form>	
	<form action='<?=URL::base();?>admin/contatos/getListContatos' id="frm_reset_listContatos" data-panel="#contatosList" method="post" class="form">
		<input type="hidden" name="contatos" value="true">
		<input type="submit" class="bar_button round" value="limpar filtros" />
	</form>

</div>

<div id="contatosList" class="clear">
	<!---->
	<div class="scrollable_content">
		<ul class="list_item round sortable_creditos" style="border:none;">
			<?foreach ($contatosList as $contato) {?>
				<li class="dd-item" id="contato-<?=$contato->id?>">
					<div>
						 <b><?=$contato->nome?></b><br/>
						<?=$contato->service->name?> | <?=$contato->email?>
					</div>
				</li>
			<?}?>
		</ul>
	</div>
</div>