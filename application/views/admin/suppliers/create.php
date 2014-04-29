<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/suppliers" class="bar_button round">Voltar</a>
	</div>
    <form name="frmSupplier" id="frmSupplier" method="post" class="form" enctype="multipart/form-data">
	  <dl>              
            <dt>
	      <label for="empresa">Empresa</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="empresa" id="empresa" style="width:500px;" value="<?=@$contactVO['empresa'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'empresa');?></span>
	    </dd>
	    <div class="left">
		    <dt>
		      <label for="name1">Contato 1</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="name[]" id="name1" style="width:200px;" value="<?=@$contactVO0['name'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'name');?></span>
		    </dd>
		    <dt>
		      <label for="email1">E-mail</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="email[]" id="email1" style="width:200px;" value="<?=@$contactVO['email'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'email');?></span>
		    </dd>
		    <dt>
		      <label for="telefone1">Telefone</label>
		    </dt>	    
		    <dd>
	            <input type="text" class="text round" name="telefone[]" id="telefone1" style="width:100px;" value="<?=@$contactVO['telefone'];?>"/>
		      	<span class='error'><?=Arr::get($errors, 'telefone');?></span>
		    </dd>
		</div>

	    <div class="left">
		    <dt>
		      <label for="name2">Contato 2</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="name[]" id="name2" style="width:200px;" value="<?=@$contactVO['name'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'name');?></span>
		    </dd>
		    <dt>
		      <label for="email2">E-mail</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="email[]" id="email2" style="width:200px;" value="<?=@$contactVO['email'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'email');?></span>
		    </dd>
		    <dt>
		      <label for="telefone2">Telefone</label>
		    </dt>	    
		    <dd>
	                <input type="text" class="text round" name="telefone[]" id="telefone2" style="width:100px;" value="<?=@$contactVO['telefone'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'telefone');?></span>
		    </dd>
		</div>
		<div class="left">
		    <dt>
		      <label for="name3">Contato</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="name[]" id="name3" style="width:200px;" value="<?=@$contactVO['name'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'name');?></span>
		    </dd>
		    <dt>
		      <label for="email3">E-mail</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="email[]" id="email3" style="width:200px;" value="<?=@$contactVO['email'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'email');?></span>
		    </dd>
		    <dt>
		      <label for="telefone3">Telefone</label>
		    </dt>	    
		    <dd>
	                <input type="text" class="text round" name="telefone[]" id="telefone3" style="width:100px;" value="<?=@$contactVO['telefone'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'telefone');?></span>
		    </dd>
		</div>
		
		<div class="clear">
	        <dt>
		      <label for="trabalho">Trabalho</label>
		    </dt>
		    <dd>
		   		<? foreach ($formatos as $formato) {?>
					<input type="checkbox" name="formato[]" id="formato_<?=$formato->id?>" value="<?=$formato->id?>" /><label for="formato_<?=$formato->id?>"><?=$formato->name?></label> 
		   		<?}?>   

		      <span class='error'><?=Arr::get($errors, 'trabalho');?></span>
		    </dd>
	        <dt>
		      <label for="site">Site</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="site" id="site" style="width:200px;" value="<?=@$contactVO['site'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'site');?></span>
		    </dd>
	        <dt>
	            <label for="observacoes">observações</label>
	        </dt>
	        <dd>
	              <textarea class="text round" name="observacoes" id="observacoes" style="width:500px; height:200px;"><?=@$contactVO['observacoes'];?></textarea>
	              <span class='error'><?=Arr::get($errors, 'observacoes');?></span>
	        </dd>
		    <dd>
		      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
		    </dd>
		  </dl>
		</div>	
	</form>
</div>
