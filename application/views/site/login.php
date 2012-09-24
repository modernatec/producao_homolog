<div id='login'>
	<p class='label'>Insira os dados de acesso</p>
	<div class='boxLogin'>
		<?php echo Form::open("login"); ?>
		<input type="hidden" name="uri" id="uri" value="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
		<label for="username">Usuario:</label><?php echo Form::input('username', @$user["username"]); ?> <br />
		<label for="password">Senha:</label><?php echo Form::password('password', @$user["password"]); ?> <br />
		<?php echo Form::submit('Logar', 'Entrar') ?> <br />
		<?php echo Form::close(); ?>
	</div>
	<?php if(isset($errors)){ foreach ($errors as $error) echo '<p class="error">'.$error.'</p>'; }?>
</div>
