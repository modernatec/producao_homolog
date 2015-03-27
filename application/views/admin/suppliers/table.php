<div class="fixed clear">
	<div class="list_header round">
		<div class="table_info round">
			<div class="left">			
				<?=count($suppliersList)?> objetos encontrados 
			</div>
			<div class="left">
				<form action='<?=URL::base();?>admin/suppliers/getSuppliers' id="frm_reset_suppliers" data-panel="#tabs_content" method="post" class="form">
					<input type="hidden" name="reset_form" value="true">
					<input type="submit" class="bar_button round green" value="limpar filtros" />
				</form>
			</div>
		</div>
		<form action="<?=URL::base();?>admin/suppliers/getSuppliers" id="frm_suppliers" data-panel="#tabs_content" method="post" class="form">
			<div class="filters">
				<div>
					<input type="text" class="round left" style="width:135px" placeholder="empresa ou contato" name="empresa" value="<?=@$filter_empresa?>" >
	       			<input type="submit" class="round bar_button left" value="OK"> 
	       		</div>

	       		<div class="clear filter" >

				    <ul>
				        <li class="round" >
				            <span class="round" id="team">time <?=(!empty($filter_team) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <div class="filter_panel round scrollable_content" data-bottom="false">
					            <ul>
					                <? foreach ($teams as $time) {?>
					                	<li>
					                		<input type="checkbox" name="team[]" value="<?=$time->id?>" id="time_<?=$time->id?>" />
					                		<label for="time_<?=$time->id?>" ><?=$time->name?></label>
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
			</div>
		</form>	
	</div>
	<div class="list_body scrollable_content">
	    <? 
		if(count($suppliersList) <= 0){
			echo '<span class="list_alert round">nenhum registro encontrado</span>';	
		}else{
		?>
		<ul class="list_item">
			<? foreach($suppliersList as $supplier){?>
			<li>
				<a href="<?=URL::base().'admin/suppliers/view/'.$supplier->id;?>" rel="load-content" data-panel="#direita" title="+ informações">
					<div>
						<p><span class="<?=$supplier->team->color?> round list_faixa"><?=$supplier->team->name?></span> <b><?=$supplier->empresa?></b></p>					
						<p><?=$supplier->contato->nome?> &bull; <?=$supplier->contato->telefone?></p>
						<p><?=$supplier->contato->email?></p>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		<?}?>
	</div>
</div>