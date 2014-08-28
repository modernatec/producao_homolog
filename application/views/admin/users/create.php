
	<div class="bar">
		<a href="<?=URL::base();?>admin/users" class="bar_button round">voltar</a>
	</div>
    <form name="frmCreateUsers" id="frmCreateUsers" method="post" class="form" enctype="multipart/form-data" autocomplete="off">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	  	<div class="left">	    
		    <div class="foto_form" style="background: url('<?=URL::base();?><?=@$userInfoVO["foto"]?>') no-repeat;"></div> 	
		</div>
		<div class="left">
	        <dt>
				<label for="arquivo">Anexar Foto</label>
		    </dt>
		    <?=$anexosView?> 
		</div>
		<div class="clear">
		    <dt>
		      <label for="nome">nome</label>
		    </dt>
	    </div>
	    <dd>
	      <input type="text" class="text round" name="nome" id="nome" style="width:500px;" value="<?=@$userInfoVO["nome"];?>"/>
	      <span class='error'><?=Arr::get($errors, 'nome');?></span>
	    </dd>
	    <div class="left">
		    <dt>
		      <label for="email">e-mail</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="email" id="email" style="width:250px;" value="<?=@$userInfoVO["email"];?>"/>
		      <span class='error'><?=Arr::get($errors, 'email');?></span>
		    </dd>       	    
		</div>                	    
	    <dt>
	      <label for="team">equipe</label>
	    </dt>
	    <dd>
			<select name="team_id" id="team_id">
				<option value="">Selecione</option>
				<? foreach($teamsList as $team){?>
                	<option value="<?=$team->id?>" <?=((@$userInfoVO["team_id"] == $team->id)?('selected'):(''))?> ><?=ucfirst($team->name)?></option><? }?>
			</select>
			<span class='error'><?=Arr::get($errors, 'role');?></span>
	    </dd>
	    
	    <div class="left">
			<dt>
				<label for="telefone">telefone</label>
		    </dt>
		    <dd>
				<input type="text" class="text round" name="telefone" id="telefone" style="width:100px;" value="<?=@$userInfoVO["telefone"];?>" maxlength="12"/>
				<span class='error'><?=Arr::get($errors, 'telefone');?></span>
		    </dd>
	    </div>
	    <div class="left">
		    <dt>
				<label for="ramal">ramal</label>
		    </dt>
		    <dd>
				<input type="text" class="text round" name="ramal" id="ramal" style="width:50px;" value="<?=@$userInfoVO["ramal"];?>" maxlength="5"/>
				<span class='error'><?=Arr::get($errors, 'ramal');?></span>
		    </dd>
		</div>
        <dt>
			<label for="data_aniversario">data do Aniversário (dd/mm)</label>
	    </dt>	
	    <dd>
            <input type="text" class="text round" name="data_aniversario" id="data_aniversario" style="width:50px;" value="<?=@$userInfo["data_aniversario"];?>" maxlength="5" />
			<span class='error'><?=Arr::get($errors, 'data_aniversario');?></span>
	    </dd>
        
	    <div class="clear">	    
			<dt>
		      <label for="role">permissão</label>
		    </dt>
		    <dd>
				<?foreach($rolesList as $roleObj){?>
					<input type="checkbox" name="role_id[]" id="role_<?=$roleObj->id?>" value="<?=$roleObj->id?>" <?=(in_array($roleObj->id, $userInfoVO["role_id"])) ? 'checked' :''?> /><label for="role_<?=$roleObj->id?>"><?=ucfirst($roleObj->name)?></label>
				<? }?>
				<span class='error'><?=Arr::get($errors, 'role_id');?></span>
		    </dd>
		</div>
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
			<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="salvar" />
	    </dd>	
	  </dl>
	</form>