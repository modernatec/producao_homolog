<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/users" class="bar_button round">Voltar</a>
	</div>
        <?
        
        $nome = ($userinfo->nome) ? ($userinfo->nome) : (Arr::get($values, 'nome'));
        $email = ($userinfo->email) ? ($userinfo->email) : (Arr::get($values, 'email'));
        $data_aniversario = ($userinfo->data_aniversario) ? ($userinfo->data_aniversario) : (Arr::get($values, 'data_aniversario'));
        $ramal = ($userinfo->ramal) ? ($userinfo->ramal) : (Arr::get($values, 'ramal'));
        $telefone = ($userinfo->telefone) ? ($userinfo->telefone) : (Arr::get($values, 'telefone'));
        $foto = ($userinfo->foto) ? ($userinfo->foto) : ('');
        ?>
    <form name="frmCreateProject" id="frmCreateProject" method="post" class="form" enctype="multipart/form-data" autocomplete="off">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
              <dt>
	      <label for="username">Username</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="username" id="username" style="width:100px;" value="<?=$username;?>"/>
	      <span class='error'><?=Arr::get($errors, 'username');?></span>
	    </dd>
	    <dt>
	      <label for="password">Senha</label>
	    </dt>
	    <dd>
	      <input type="password" class="text round" name="password" id="password" style="width:100px;" value="<?=$password;?>"/>
	      <span class='error'><?=Arr::get($errors, 'password');?></span>
	    </dd>
	    <dt>
	      <label for="password_confirm">Confirme a senha</label>
	    </dt>
	    <dd>
	      <input type="password" class="text round" name="password_confirm" id="password_confirm" style="width:100px;" value="<?=$password_confirm;?>"/>
	      <span class='error'><?=Arr::get($errors, 'password_confirm');?></span>
	    </dd>
	        	    
	    <dt>
	      <label for="role">Permissão</label>
	    </dt>
	    <dd>
                <select name="role" id="role">
                    <option value="">Selecione</option>
                    <option value="3">Coordenador</option>
                    <option value="4">Assistente</option>
                </select>
	      <span class='error'><?=Arr::get($errors, 'role');?></span>
	    </dd>
	    <dt>
	      <label for="nome">Nome</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="nome" id="nome" style="width:500px;" value="<?=$nome;?>"/>
	      <span class='error'><?=Arr::get($errors, 'nome');?></span>
	    </dd>
	    <dt>
	      <label for="email">Email</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="email" id="email" style="width:500px;" value="<?=$email;?>"/>
	      <span class='error'><?=Arr::get($errors, 'email');?></span>
	    </dd>	    
	    
        <dt>
	      <label for="telefone">Telefone</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="telefone" id="telefone" style="width:100px;" value="<?=$telefone;?>" maxlength="12"/>
	      <span class='error'><?=Arr::get($errors, 'telefone');?></span>
	    </dd>
        <dt>
	      <label for="data_aniversario">Data do Aniversário (dd/mm)</label>
	    </dt>
	    <dd>
            <input type="text" class="text round" name="data_aniversario" id="data_aniversario" style="width:50px;" value="<?=$data_aniversario;?>" maxlength="5" />
	      <span class='error'><?=Arr::get($errors, 'data_aniversario');?></span>
	    </dd>
        <dt>
	      <label for="ramal">Ramal</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="ramal" id="ramal" style="width:50px;" value="<?=$ramal;?>" maxlength="5"/>
	      <span class='error'><?=Arr::get($errors, 'ramal');?></span>
	    </dd>
            <dt>
	      <label for="arquivo">Anexar Foto</label>
	    </dt>	    
	    <dd>
                <?
                if($foto!=''){
                    ?>
                <img src="<?=URL::base();?><?=$foto?>" width="150" alt="<?=$nome;?>" />
                    <?
                }
                ?>
                <input type="file" class="text required round" name="arquivo" id="arquivo" style="width:500px;" />
	    </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate==1){?>Salvar<? }else{ ?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
