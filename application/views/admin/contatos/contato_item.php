<div id="contato_<?=$key?>" class="clear contatos">
	
	<div class="left">
	    <dd>
		    <input type="text" class="text required round" name="nome[]" placeholder="nome" style="width:400px;" value="<?=@$contato->nome?>" />
		    <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>
	</div>
	<div class="left">
	    <a data-remove="contato_<?=$key?>" class="remover">remover</a>
	</div>
	<div class="clear left">
	    <dd>
		    <input type="text" class="text round" name="email[]" placeholder="e-mail" style="width:200px;" value="<?=@$contato->email?>" />
		    <span class='error'><?=Arr::get($errors, 'email');?></span>
	    </dd>
	</div>
	<div class="left">
	    <dd>
            <input type="text" class="text round" name="telefone[]" placeholder="telefone" style="width:100px;" value="<?=@$contato->telefone?>" />
	      	<span class='error'><?=Arr::get($errors, 'telefone');?></span>
	    </dd>
	</div>
</div>