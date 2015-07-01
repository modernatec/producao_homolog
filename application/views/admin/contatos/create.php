	<? if(@$VO['id'] != ""){?>
	<div class="bar">
		<a href="<?=URL::base();?>admin/contatos/view/<?=@$VO['id'];?>" rel="load-content" data-panel="#direita" class="bar_button round">Voltar</a>
	</div>
	<?}?>
	<div class="scrollable_content">
	    <form name="frmContato" id="frmContato" action="<?=URL::base();?>admin/contatos/salvar/<?=$VO['id']?>" method="post" class="form">
	    	<div class="left">
			    <label for="nome">nome</label>
			    <dd>
				    <input type="text" class="text required round" name="nome[]" placeholder="nome" style="width:400px;" value="<?=$VO['nome']?>" />
				    <span class='error'><?=Arr::get($errors, 'nome');?></span>
			    </dd>
			</div>
			<div class="clear left">
			    <label for="email">email</label>
			    <dd>
				    <input type="text" class="text round" name="email[]" placeholder="e-mail" style="width:200px;" value="<?=$VO['email']?>" />
				    <span class='error'><?=Arr::get($errors, 'email');?></span>
			    </dd>
			</div>
			<div class="left">
			    <label for="telefone">telefone</label>
			    <dd>
		            <input type="text" class="text round" name="telefone[]" placeholder="telefone" style="width:100px;" value="<?=$VO['telefone']?>" />
			      	<span class='error'><?=Arr::get($errors, 'telefone');?></span>
			    </dd>
			</div>
			<div class="left">
			    <label for="celular">celular</label>
			    <dd>
		            <input type="text" class="text round" name="celular[]" placeholder="celular" style="width:100px;" value="<?=$VO['celular']?>" />
			      	<span class='error'><?=Arr::get($errors, 'celular');?></span>
			    </dd>
			</div>
			<div class="clear left">
			    <label for="tipo">principal atividade</label>
			    <dd>				    
				    <select class="required round" name="tipo" id="tipo" >
                        <option value='' >selecione</option>
                        <option value='1' <?=(($VO['tipo']== '1')?('selected="selected"'):(''))?>>atendimento</option>
                        <option value='2' <?=(($VO['tipo']== '2')?('selected="selected"'):(''))?>>locutor</option>
                        <option value='3' <?=(($VO['tipo']== '3')?('selected="selected"'):(''))?>>ilustrador</option>
                        <option value='4' <?=(($VO['tipo']== '4')?('selected="selected"'):(''))?>>roteirista</option>
                        <option value='5' <?=(($VO['tipo']== '5')?('selected="selected"'):(''))?>>tradutor</option>
                    </select>
				    <span class='error'><?=Arr::get($errors, 'tipo');?></span>
			    </dd>
			</div>
			<dd class="clear">
				<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="salvar" />		      
		    </dd>
		</form>
	</div>
