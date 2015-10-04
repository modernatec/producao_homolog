<div id="lateral">
	<div class="user_info"  >
		<!--a href="users/editInfo" rel="load-content" data-panel="#content" data-refresh="true" style="float:left;"-->
			<!--img class="foto" src="<?=URL::base();?><?=$user->userInfos->foto?>" /-->
			<div class='left'><?=Utils_Helper::getUserImage($user->userInfos)?></div>			
	        <div class='left line'><?$nome = explode(" ", $user->userInfos->nome); echo ucfirst($nome[0]);?></div>
	        <div class='right'><a href="<?=URL::base();?>logout/" class='logout'  title="logout">logout</a></div>
	    <!--/a-->
	</div>	
	<div id="menu">
		<ul >
			<?foreach($menuList as $key=>$menuItem){?>
				<li ><a class="menu" rel="load-content" data-panel="#content" data-refresh="true" href="<?=$menuItem['link']?>/index/ajax" ><?=$menuItem['display']?></a></li>
                <?if(isset($menuItem['sub'])){?>
                	<ul class="submenu">
                	<?foreach($menuItem['sub'] as $menuSubItem){?>
                    	<li><a class="menu" rel="load-content" data-panel="#content" data-refresh="true" href="<?=$menuSubItem['link']?>/index/ajax" ><?=$menuSubItem['display']?></a></li>
	                <?}?>
					</ul>
				<?}?>
			<?}?>
		</ul>
	</div>
	
</div>