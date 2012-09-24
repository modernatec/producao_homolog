<div id='login'>
	<form action="<?=URL::base();?>login/" name="frmAcesso" id="frmAcesso" method="post">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	    <dt>
	      <label for="strUsuario">Usuário: </label>
	    </dt>
	    <dd>
	      <input type="text" class="text required round" name="username" id="username" />
	    </dd>
	    <dt>
	      <label for="pwdSenha">Senha: </label>
	    </dt>
	    <dd>
	      <input type="password" class="text required round" name="password" id="password" />
	    </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="Acessar" />
	    </dd>
	  </dl>
	</form>
</div>