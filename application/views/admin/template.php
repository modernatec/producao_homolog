<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?=I18n::$lang ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="<?=I18n::$lang ?>" /> 
		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
		<?=@$refresh?>
		<title>Kaizen<?php echo $title; ?></title>
	    <?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
        <script>
        	var base_url = "<?=URL::base();?>"
        	var logged_in = <?=Auth::instance()->logged_in();?>
        </script>  
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?=URL::base();?>public/image/common/favicon.ico" />
        <link rel="shortcut icon" href="<?=URL::base();?>public/image/common/favicon.ico" />
	</head>
	<body>
	    <div id="nav">
	    	<?=$menu;?>
	    	<div id="content" class="content">
	    		<?=$content;?>
	    	</div>
	    	<?=$bar?>
	    </div>	    
		<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
		<script>var msgs = <?=($mensagens)?($mensagens):('[]')?>;</script>   
	</body>
</html>