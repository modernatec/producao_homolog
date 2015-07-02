<div class="filters clear">
	<form action="<?=URL::base();?>admin/contatos/getListContatos" id="frm_listContatos" data-panel="#contatosList" method="post" class="form">
		<input type="hidden" name="contatos" value="true">
			<div class="left" style="margin-bottom:4px;">
				<input type="text" class="round" style="width:200px" placeholder="nome ou email" name="nome" value="<?=@$filter_nome?>" >
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
		<ul class="list_item connect round sortable_workflow">
			<?foreach ($contatosList as $contato) {?>
				<li class="dd-item" id="contato-<?=$contato->id?>">
					<div>
						<b><?=$contato->nome?></b>
					</div>
					<div>
						<?=$contato->email?>
					</div>
					<div>
						<?=$contato->telefone?>
					</div>
				</li>
			<?}?>
		</ul>
	</div>
</div>