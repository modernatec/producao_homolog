<form name="frmEditPass" id="frmEditPass" method="post" action="<?=URL::base();?>/admin/users/savePass/<?=$userInfoVO["id"];?>" class="form" enctype="multipart/form-data" autocomplete="off">
   <label for="username">username</label>
    <dd>
      <input type="hidden" class="text round" name="username" id="username" value="<?=$userInfoVO["username"];?>" />
      <?=$userInfoVO["username"];?>
      <span class='error'><?=Arr::get($errors, 'username');?></span>
    </dd>
    <div class="left">    
      <label for="password">senha</label>
      <dd>
        <input type="password" class="text round" name="password" id="password" style="width:100px;"/>
        <span class='error'><?=Arr::get($errors, 'password');?></span>
      </dd>
    </div>
    <div class="left">    
      <label for="password_confirm">confirme a senha</label>
      <dd>
        <input type="password" class="text round" name="password_confirm" id="password_confirm" style="width:100px;"/>
        <span class='error'><?=Arr::get($errors, 'password_confirm');?></span>
      </dd>
    </div>            
    <div class="clear">
		  <input type="submit" class="clear round" name="btnSubmit" id="btnSubmit" value="Alterar" />
    </div>
 
</form>
