<div>
	<div id="user_info">
        <img src='<?=URL::base();?><?=$user->userInfos->foto?>' height="25" style='float:left' alt="<?=ucfirst($user->username);?>" />
        <?=ucfirst($user->username);?>
        
        <a href="<?=URL::base();?>logout/">logout</a>
	</div>
	<div id="menu" class="round">
		<ul id="MainMenuList">
			<? 
                        foreach($menuList as $menuItem){?>
				<li><a href="<?=URL::base();?><?=$menuItem->link?>" ><?=$menuItem->display?></a></li>
			<?}?>
		</ul>
	</div>
</div>