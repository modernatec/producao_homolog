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
		<?=@$refresh?>
		<title>Kaizen<?php echo $title; ?></title>
	    <?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
        <script>
        	var base_url = "<?=URL::base();?>";
        	var current_auth = "<?=$current_auth;?>";
        	var logged_in = <?=Auth::instance()->logged_in();?>;
        	var hollidays = <?=$hollidays?>;
        </script>  
        <style type="text/css">
        	<?=$team_css;?>
        </style>
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?=URL::base();?>public/image/common/favicon.ico" />
        <link rel="shortcut icon" href="<?=URL::base();?>public/image/common/favicon.ico" />
	</head>
	<body>
	    <div id="nav">
	    	<div class="topo">
	    		<div class="user_info"  >
					<!--a href="users/editInfo" rel="load-content" data-panel="#content" data-refresh="true" style="float:left;"-->
						<!--img class="foto" src="<?=URL::base();?><?=$user->userInfos->foto?>" /-->
						<div class='left'><?=Utils_Helper::getUserImage($user->userInfos)?></div>			
				        <div class='left line'><?$nome = explode(" ", $user->userInfos->nome); echo ucfirst($nome[0]);?></div>
				        <div class='right'><a href="<?=URL::base();?>logout/" class='logout'  title="logout">logout</a></div>
				    <!--/a-->
				</div>
				<div id='filtros'></div>
	    	</div>
	    	<?=$menu;?>
	    	<div id="content" class="content"></div>
	    	<?=$bar?>
	    </div>	    
		<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
		<script>var msgs = <?=($mensagens)?($mensagens):('[]')?>;</script>   
	</body>
</html>