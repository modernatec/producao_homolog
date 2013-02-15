<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/users" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateUsers" id="frmCreateUsers" method="post" class="form" enctype="multipart/form-data" autocomplete="off">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	    <dt>
	      <label for="nome">Nome</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="nome" id="nome" style="width:500px;" value="<?=@$userInfoVO["nome"];?>"/>
	      <span class='error'><?=Arr::get($errors, 'nome');?></span>
	    </dd>
	    <dt>
	      <label for="email">Email</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="email" id="email" style="width:250px;" value="<?=@$userInfoVO["email"];?>"/>
	      <span class='error'><?=Arr::get($errors, 'email');?></span>
	    </dd>       	    
                	    
	    <dt>
	      <label for="team">Equipe</label>
	    </dt>
	    <dd>
			<select name="team_id" id="team_id">
				<option value="">Selecione</option>
				<? foreach($teamsList as $team){?>
                	<option value="<?=$team->id?>" <?=((@$userInfoVO["team_id"] == $team->id)?('selected'):(''))?> ><?=ucfirst($team->name)?></option><? }?>
			</select>
			<span class='error'><?=Arr::get($errors, 'role');?></span>
	    </dd>
	    <dt>
	      <label for="role">Permissão</label>
	    </dt>
	    <dd>
			<select name="role_id" id="role_id" >
				<option value="">Selecione</option>
                <?
				foreach($rolesList as $roleObj){
					?><option value="<?=$roleObj->id?>" <?=((@$userInfoVO["role_id"] == $roleObj->id)?('selected'):(''))?>><?=ucfirst($roleObj->name)?></option>
				<? }?>
			</select>
			<span class='error'><?=Arr::get($errors, 'role_id');?></span>
	    </dd>
		<dt>
			<label for="telefone">Telefone</label>
	    </dt>
	    <dd>
			<input type="text" class="text round" name="telefone" id="telefone" style="width:100px;" value="<?=@$userInfoVO["telefone"];?>" maxlength="12"/>
			<span class='error'><?=Arr::get($errors, 'telefone');?></span>
	    </dd>
        <dt>
			<label for="data_aniversario">Data do Aniversário (dd/mm)</label>
	    </dt>
	    <dd>
            <input type="text" class="text round" name="data_aniversario" id="data_aniversario" style="width:50px;" value="<?=@$userInfo["data_aniversario"];?>" maxlength="5" />
			<span class='error'><?=Arr::get($errors, 'data_aniversario');?></span>
	    </dd>
        <dt>
			<label for="ramal">Ramal</label>
	    </dt>
	    <dd>
			<input type="text" class="text round" name="ramal" id="ramal" style="width:50px;" value="<?=@$userInfoVO["ramal"];?>" maxlength="5"/>
			<span class='error'><?=Arr::get($errors, 'ramal');?></span>
	    </dd>
        <dt>
			<label for="arquivo">Anexar Foto</label>
	    </dt>	    
	    <dd>
        	<? if(@$userInfoVO["foto"]){ ?>
        	<img src="<?=URL::base();?><?=@$userInfoVO["foto"]?>" width="150" alt="<?=@$userInfoVO["nome"];?>" />
           	<? }?>
			<input type="file" class="text round" name="arquivo" id="arquivo" style="width:500px; display:block;" />
	    </dd>
        <br/>
        <dt>
	      <label for="username">Username</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="username" id="username" style="width:200px;" value="<?=@$userInfoVO["username"];?>" />
	      <span class='error'><?=Arr::get($errors, 'username');?></span>
	    </dd>
	    
        <dt>
	      <label for="password">Senha</label>
	    </dt>
	    <dd>
	      <input type="password" class="text round" name="password" id="password" style="width:100px;" />
	      <span class='error'><?=Arr::get($errors, 'password');?></span>
	    </dd>
	    <dt>
	      <label for="password_confirm">Confirme a senha</label>
	    </dt>
	    <dd>
	      <input type="password" class="text round" name="password_confirm" id="password_confirm" style="width:100px;" />
	      <span class='error'><?=Arr::get($errors, 'password_confirm');?></span>
	    </dd>
                
	    <dd>
			<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<?=(@$isUpdate) ? "Salvar" : "Criar"?>" />
	    </dd>	
	  </dl>
	</form>
</div>