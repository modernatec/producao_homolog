<a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a> 	
<ul class="list_item connect round sortable_workflow">
	<?foreach ($contatosList as $contato) {?>
		<li class="dd-item" id="contato-<?=$contato->id?>">
			<p><b><?=$contato->nome?></b></p>					
			<p><?=$contato->email?></p>
			<p><?=$contato->telefone?></p>
		</li>
	<?}?>
</ul>