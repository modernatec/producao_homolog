	<? if(@$supplierVO['id'] != ""){?>
	<div class="bar">
		<a href="<?=URL::base();?>admin/suppliers/view/<?=@$supplierVO['id'];?>" rel="load-content" data-panel="#direita" class="bar_button round">Voltar</a>
	</div>
	<?}?>
    <form name="frmSupplier" id="frmSupplier" data-panel="#direita" action="<?=URL::base();?>admin/suppliers/edit/<?=$supplierVO['id']?>" method="post" class="form" enctype="multipart/form-data">
    	<dt>
			<label for="empresa">Empresa</label>
		</dt>
	    <dd>
	      <input type="text" class="text required round" name="empresa" id="empresa" style="width:300px;" value="<?=@$supplierVO['empresa'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'empresa');?></span>
	    </dd>
	    <div class="left">
		    <dt>
		    	<label for="name1">Contato 1</label>
		    </dt>
		    <dd>
			    <input type="text" class="text required round" name="nome[]" id="name1" style="width:200px;" value="<?=@$contactVO['0']['nome'];?>"/>
			    <span class='error'><?=Arr::get($errors, 'name');?></span>
		    </dd>
		    <dt>
		      	<label for="email1">E-mail</label>
		    </dt>
		    <dd>
			    <input type="text" class="text required round" name="email[]" id="email1" style="width:200px;" value="<?=@$contactVO['0']['email'];?>"/>
			    <span class='error'><?=Arr::get($errors, 'email');?></span>
		    </dd>
		    <dt>
		      	<label for="telefone1">Telefone</label>
		    </dt>	    
		    <dd>
	            <input type="text" class="text required round" name="telefone[]" id="telefone1" style="width:100px;" value="<?=@$contactVO['0']['telefone'];?>"/>
		      	<span class='error'><?=Arr::get($errors, 'telefone');?></span>
		    </dd>
		</div>

	    <div class="left">
		    <dt>
		      <label for="name2">Contato 2</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="nome[]" id="name2" style="width:200px;" value="<?=@$contactVO['1']['nome'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'name');?></span>
		    </dd>
		    <dt>
		      <label for="email2">E-mail</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="email[]" id="email2" style="width:200px;" value="<?=@$contactVO['1']['email'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'email');?></span>
		    </dd>
		    <dt>
		      <label for="telefone2">Telefone</label>
		    </dt>	    
		    <dd>
	                <input type="text" class="text round" name="telefone[]" id="telefone2" style="width:100px;" value="<?=@$contactVO['1']['telefone'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'telefone');?></span>
		    </dd>
		</div>
		<div class="left">
		    <dt>
		      <label for="name3">Contato</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="nome[]" id="name3" style="width:200px;" value="<?=@$contactVO['2']['nome'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'name');?></span>
		    </dd>
		    <dt>
		      <label for="email3">E-mail</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="email[]" id="email3" style="width:200px;" value="<?=@$contactVO['2']['email'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'email');?></span>
		    </dd>
		    <dt>
		      <label for="telefone3">Telefone</label>
		    </dt>	    
		    <dd>
	                <input type="text" class="text round" name="telefone[]" id="telefone3" style="width:100px;" value="<?=@$contactVO['2']['telefone'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'telefone');?></span>
		    </dd>
		</div>
		
		<div class="clear">
	        <dt>
		   		<label for="trabalho">Trabalho</label>
		    </dt>
		    <dd>
		   		<? foreach ($formatos as $formato) {?>
					<input type="checkbox" name="formato[]" id="formato_<?=$formato->id?>" value="<?=$formato->id?>" <?=(in_array($formato->id, $formats_arr))? 'checked' : ''?> /><label for="formato_<?=$formato->id?>"><?=$formato->name?></label> 
		   		<?}?>   

		      <span class='error'><?=Arr::get($errors, 'trabalho');?></span>
		    </dd>
		    <div class="left">
			    <dt>
			      <label for="team_id">equipe</label>
			    </dt>
			    <dd>
			   		<select name="team_id" id="team_id" class="required round" style="width:150px;">
		                <option value="">selecione</option>
		                <? foreach($teams as $team){?>
		                    <option value="<?=$team->id?>" <?=($supplierVO['team_id'] == $team->id) ? "selected" : ""?> ><?=$team->name?></option>
		                <?}?>
		            </select>
		            <span class='error'><?=Arr::get($errors, 'team_id');?></span>
			    </dd>
			</div>
	        <dt>
		      <label for="site">Site</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="site" id="site" style="width:200px;" value="<?=@$supplierVO['site'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'site');?></span>
		    </dd>
	        <dt>
	            <label for="observacoes">observações</label>
	        </dt>
	        <dd>
	              <textarea class="text round" name="observacoes" id="observacoes" style="width:500px; height:200px;"><?=@$supplierVO['observacoes'];?></textarea>
	              <span class='error'><?=Arr::get($errors, 'observacoes');?></span>
	        </dd>
		    <dd>
		      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
		    </dd>
		</div>	
	</form>
