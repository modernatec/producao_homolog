<div class="bar">
	<a href="<?=URL::base();?>/admin/users/edit/<?=$userInfoVO['id']?>" rel="load-content" data-panel="#direita" class="bar_button round">Voltar</a>
</div>
<form name="frmEditPass" id="frmEditPass" method="post" class="form" enctype="multipart/form-data" autocomplete="off">
  <dl>
    <dt>
      <label for="username">Username</label>
    </dt>
    <dd>
      <input type="hidden" class="text round" name="username" id="username" value="<?=$userInfoVO["username"];?>" />
      <?=$userInfoVO["username"];?>
      <span class='error'><?=Arr::get($errors, 'username');?></span>
    </dd>
    
    <dt>
      <label for="password">Senha</label>
    </dt>
    <dd>
      <input type="password" class="text round" name="password" id="password" style="width:100px;"/>
      <span class='error'><?=Arr::get($errors, 'password');?></span>
    </dd>
    <dt>
      <label for="password_confirm">Confirme a senha</label>
    </dt>
    <dd>
      <input type="password" class="text round" name="password_confirm" id="password_confirm" style="width:100px;"/>
      <span class='error'><?=Arr::get($errors, 'password_confirm');?></span>
    </dd>
            
    <dd>
		<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="Alterar" />
    </dd>	
  </dl>
</form>
