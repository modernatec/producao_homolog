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
	    <dt>
	      <label for="nome">Contato</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="nome" id="nome" style="width:500px;" value="<?=@$contactVO['nome'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'nome');?></span>
	    </dd>
	    <dt>
	      <label for="email">E-mail</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="email" id="email" style="width:500px;" value="<?=@$contactVO['email'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'email');?></span>
	    </dd>
	    <dt>
	      <label for="telefone">Telefone</label>
	    </dt>	    
	    <dd>
                <input type="text" class="text round" name="telefone" id="telefone" style="width:80px;" value="<?=@$contactVO['telefone'];?>" maxlength="10"/>
	      <span class='error'><?=Arr::get($errors, 'telefone');?></span>
	    </dd>
        <dt>
	      <label for="trabalho">Trabalho</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="trabalho" id="trabalho" style="width:500px;" value="<?=@$contactVO['trabalho'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'trabalho');?></span>
	    </dd>
        <dt>
	      <label for="site">Site</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="site" id="site" style="width:500px;" value="<?=@$contactVO['site'];?>"/>
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
	</form>
</div>
