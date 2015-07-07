<span class='list_alert light_blue round'>fornecedores</span>
<div class="filters clear">
	<form action="<?=URL::base();?>admin/suppliers/getListSuppliers" id="frm_listSuppliers" method="post" class="form">
		<input type="hidden" name="suppliers" value="true">
		<div class="left" style="margin-bottom:4px;">
			<input type="text" class="round" style="width:200px" placeholder="nome" name="empresa" value="<?=@$filter_empresa?>" >
   		</div>
		<input type="submit" class="round bar_button left" value="buscar">        	
	</form>	
	<form action='<?=URL::base();?>admin/suppliers/getListSuppliers' id="frm_reset_listSuppliers" method="post" class="form">
		<input type="hidden" name="suppliers" value="true">
		<input type="submit" class="bar_button round green" value="limpar filtros" />
	</form>

</div>

<div id="contatosList">
	<!---->
	<div class="scrollable_content" data-bottom="false" style="overflow:auto; height:600px;padding:10px 0;">
		<ul class="list_item connect_suppliers round sortable_produtoras form" style="border:none;">
			<?foreach ($suppliersList as $supplier) {?>
				<li class="dd-item" id="supplier-<?=$supplier->id?>">
					<div><p><b><?=$supplier->empresa?></b></p></div>
					<div class="infos hide">
						<div class="clear left">
							<div><label>serviço</label></div>
							<select class="required round" name="services[]" style="width:100px;">
		                        <option value=''>serviço</option>
		                        <? foreach($services as $service){?>
		                            <option value='<?=$service->id?>' ><?=$service->name?></option>
		                        <?}?>
		                    </select>
						</div>
						<?if($current_auth != "assistente" && $current_auth != "assistente 2"){?>
						<div class="left">
							<div><label>valor</label></div>
							<input type="text" name="valores[]" placeholder="valor" class="required money round" data-a-sep="." data-a-dec="," />
						</div>
						<div class="left">
							<div><label>obs:</label></div>
							<input type="text" name="produtora_obs[]" placeholder="valor" class="round" />
						</div>
						<?}?>
					</div>
				</li>
			<?}?>
		</ul>
	</div>
</div>