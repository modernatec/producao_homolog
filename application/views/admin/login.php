<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?=I18n::$lang ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="<?=I18n::$lang ?>" /> 
		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
		<title>Kaizen</title>
        <script>
        	var base_url = "<?=URL::base();?>";
        </script>  

        <link href="<?=URL::base();?>public/css/admin/login.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?=URL::base();?>public/image/common/favicon.ico" />
        <link rel="shortcut icon" href="<?=URL::base();?>public/image/common/favicon.ico" />
	</head>
	<body>
		<div id='nav_login'>
		    <div id='login'>
				<form action="<?=URL::base();?>login/" name="frmAcesso" id="frmAcesso" method="post">
					
					<div>
						<input type="text" class="text required round" placeholder="usuário" name="username" id="username" />
					</div>
					<div>
						<input type="password" class="text required round" placeholder="senha" name="password" id="password" />
					</div>
					<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="acessar" />
				</form>
			</div>    
		</div>
	</body>
</html>
