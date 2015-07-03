<span class='list_alert light_blue round'>contatos</span>
<div class="filters clear">
	<form action="<?=URL::base();?>admin/contatos/getListContatos" id="frm_listContatos" data-panel="#contatosList" method="post" class="form">
		<input type="hidden" name="contatos" value="true">
			<div class="left" style="margin-bottom:4px;">
				<input type="text" class="round" style="width:200px" placeholder="nome ou email" name="nome" value="<?=@$filter_nome?>" >
	   		</div>
	   		<div class="left filter" >
                <ul>
                    <li class="round" >
                        <span class="round" id="service_id">tipo <?=(!empty($filter_service_id) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
                        <div class="filter_panel round scrollable_content" data-bottom="false">
                            <ul>
                                <li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_tipo" /><label for="filter_tipo">selecionar tudo</label></li>
                                <?foreach ($services as $service) {?>
                                <li>
                                    <input class="filter_tipo" type="checkbox" name="service_id[]" value="<?=$service->id?>" id="col_<?=$service->id?>" <?if(isset($filter_service_id)){ if(in_array($service->id, $filter_service_id)){ echo "checked";}}?>  />
                                    <label for="col_<?=$service->id?>"><?=$service->name?></label>
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
	<form action='<?=URL::base();?>admin/contatos/getListContatos' id="frm_reset_listContatos" data-panel="#contatosList" method="post" class="form">
		<input type="hidden" name="contatos" value="true">
		<input type="submit" class="bar_button round green" value="limpar filtros" />
	</form>

</div>

<div id="contatosList">
	<!---->
	<div class="scrollable_content" data-bottom="false" style="overflow:auto; height:600px;padding:10px 0;">
		<ul class="list_item connect round sortable_workflow" style="border:none;">
			<?foreach ($contatosList as $contato) {?>
				<li class="dd-item" id="contato-<?=$contato->id?>">
					<div class="left" style="width:90px;">
						<span class="list_faixa round blue"><?=$contato->service->name?></span>
					</div>
					<div>
						 <b><?=$contato->nome?></b><br/>
						<?=$contato->email?>
					</div>
				</li>
			<?}?>
		</ul>
	</div>
</div>