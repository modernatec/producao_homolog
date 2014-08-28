<div class="list_header round">
	<div class="table_info round">
		<?=count($suppliersList)?> objetos encontrados 
		<a class="bar_button round green" href='<?=URL::base();?>admin/suppliers/getSuppliers' rel="load-content" data-panel="#tabs_content">limpar filtros</a>
	</div>
	<form action="<?=URL::base();?>admin/suppliers/getSuppliers" id="frm_suppliers" data-panel="#tabs_content" method="post" class="form">
		<div class="filters">
			<div class="left">
				<input type="text" class="round left" style="width:135px" placeholder="empresa" name="empresa" value="<?=$filter_empresa?>" >
       		</div>
			<div class="left">
				<input type="text" class="round left" style="width:135px" placeholder="contato" name="contato" value="<?=$filter_contato?>" >
       			<input type="submit" class="round bar_button left" value="OK"> 
       		</div>
		</div>
	</form>	
</div>
<div class="list_body">
    <? 
	if(count($suppliersList) <= 0){
		echo '<span class="list_alert round">nenhum registro encontrado</span>';	
	}else{
	?>
	<ul class="list_item">
		<? foreach($suppliersList as $supplier){?>
		<li>
			<a href="<?=URL::base().'admin/suppliers/view/'.$supplier->id;?>" rel="load-content" data-panel="#direita" title="+ informações">
				<div class="left" style="width:30%">
					<p><b><?=$supplier->empresa?></b></p>
					<p><?=$supplier->contato->nome?> &bull; <?=$supplier->contato->telefone?></p>
					<p><?=$supplier->contato->email?></p>
				</div>
				<div class="left" style="width:40%">
					<p><?=$supplier->team->name?></p>
					<p><?=$supplier->getFormats($supplier->id)?></p>
				</div>
			</a>
		</li>
		<?}?>
	</ul>
	<?}?>
</div>