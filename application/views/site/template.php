<?=$xml?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=I18n::$lang ?>" lang="<?=I18n::$lang ?>">
	<head>
		<meta http-equiv="content-type"			content="text/html; charset=<?=I18n::$lang ?>" /> 
	    <meta http-equiv="pragma"				content="no-cache" /> 
	    <meta http-equiv="Cache-Control"		content="no-cache, must-revalidate" /> 
	    <meta http-equiv="expires"				content="Mon, 06 Jan 1990 00:00:01 GMT" /> 
	    <meta http-equiv="content-language"		content="<?=I18n::$lang ?>" /> 
	    <meta http-equiv="imagetoolbar"			content="no" /> 
        <meta http-equiv="X-UA-Compatible"		content="IE=edge">
    
	    <meta name="language"					content="<?=I18n::$lang ?>" /> 
	    <meta name="rating"						content="General" /> 
	    <meta name="robots"						content="all"/> 
	    <meta name="revisit-after"				content="1 days" /> 
	    <meta name="copyright"					content="4mypet" /> 
	    <meta name="author"						content="Adalberto, Roberto" /> 
	    <meta name="MSSmartTagsPreventParsing"	content="TRUE" /> 
	    <meta name="classification"				content="Comunidade, Pet, Internet" /> 
	    <meta name="description"				content="Comunidade de Pets. Com a ajuda dos usuarios o site aparece cheio de informacoes sobre o mundo pet." /> 
	    <meta name="keywords" 					content="4mypet, 4my pet, 4 mypet, 4 my pet, perfil, pet, orkut, animais, cães, gatos, comunidade, cachorro, filhotes, rede social, raças, pedigree, gatos, aves, bichos, bichos de estimação, vídeos, notícias, fórum, veterinário, adestrador ,namoro, adoção, perdidos, encontrado, cão abandonado, competições premiadas, fotos, rações, alimentação, saúde, reprodução, galeria de fotos, filmes, guia de raças, curiosidades, cartões virtuais" /> 
    
	    <meta property="fb:admins" 				content="643274728" /> 
	    <meta property="og:site_name"			content="4mypet" /> 
	    <meta property="og:title"				content="4mypet" /> 
	    <meta property="og:type"				content="activity" /> 
	    <meta property="og:url"					content="http://www.4mypet.com.br/" /> 
	    <meta property="og:image"				content="http://www.4mypet.com.br/common/image/social/facebook.jpg" /> 
	    <meta property="og:description"			content="Comunidade, Pet, Internet." /> 
	    <meta property="og:email"				content="contato@4mypet.com.br"/> 
	    <meta property="og:phone_number"		content="11-1111-1111"/>
	
	    <title>Produção <?=$title?></title>
	    <? foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>	
	</head>
	<body>
		<div id='nav' >
			<?=@$header?>
			<?=@$layout?>
		</div>
		
		<script type='text/javascript'>var base_url = '<?=URL::base()?>'</script>
	    <? foreach ($scripts as $file) echo HTML::script($file), PHP_EOL; ?>
	</body>
</html>