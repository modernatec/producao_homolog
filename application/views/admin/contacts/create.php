<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/contacts" class="bar_button round">Voltar</a>
	</div>
        <?
        //print_r($errors);
        $nome = ($contact->nome) ? ($contact->nome) : (Arr::get($values, 'nome'));
        $email = ($contact->email) ? ($contact->email) : (Arr::get($values, 'email'));
        $telefone = ($contact->telefone) ? ($contact->telefone) : (Arr::get($values, 'telefone'));
        $site = ($contact->site) ? ($contact->site) : (Arr::get($values, 'site'));
        $empresa = ($contact->empresa) ? ($contact->empresa) : (Arr::get($values, 'empresa'));
        ?>
    <form name="frmContact" id="frmContact" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	    <dt>
	      <label for="nome">Contato</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="nome" id="nome" style="width:500px;" value="<?=$nome;?>"/>
	      <span class='error'><?=Arr::get($errors, 'nome');?></span>
	    </dd>
	    <dt>
	      <label for="email">E-mail</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="email" id="email" style="width:500px;" value="<?=$email;?>"/>
	      <span class='error'><?=Arr::get($errors, 'email');?></span>
	    </dd>
	    <dt>
	      <label for="telefone">Telefone</label>
	    </dt>	    
	    <dd>
                <input type="text" class="text round" name="telefone" id="telefone" style="width:80px;" value="<?=$telefone;?>" maxlength="10"/>
	      <span class='error'><?=Arr::get($errors, 'telefone');?></span>
	    </dd>
            <dt>
	      <label for="site">Site</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="site" id="site" style="width:500px;" value="<?=$site;?>"/>
	      <span class='error'><?=Arr::get($errors, 'site');?></span>
	    </dd>
            <dt>
	      <label for="empresa">Empresa</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="empresa" id="empresa" style="width:500px;" value="<?=$empresa;?>"/>
	      <span class='error'><?=Arr::get($errors, 'empresa');?></span>
	    </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
