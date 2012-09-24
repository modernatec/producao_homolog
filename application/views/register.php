<?
if(isset($errors))
	var_dump($errors);
?>
<form method="post" autocomplete="off">	
	<label for="email">email</label><br>
	<input type="text" name="email" id="email" /><br>
        <label for="username">username</label><br>
	<input type="text" name="username" id="username" /><br>
	<label for="password">password</label><br>
	<input type="password" name="password" id="password" /><br>
	<label for="password_confirm">password confirm</label><br>
	<input type="password" name="password_confirm" id="password_confirm" /><br>
	<input type="submit" value="register" />
</form>