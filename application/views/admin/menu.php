<div>
	<div id="user_info">
        <a href="<?=URL::base();?>admin/users/editInfo" style="float:left;" >
        	<img src='<?=URL::base();?><?=$user->userInfos->foto?>' height="25" style='float:left' alt="<?=ucfirst($user->username);?>" />
        	<?=ucfirst($user->username);?>
        </a>
        <a href="<?=URL::base();?>logout/">logout</a>
	</div>
	<div id="menu" class="round">
		<ul id="MainMenuList">
			<?foreach($menuList as $key=>$menuItem){?>
				<li><a href="<?=URL::base();?><?=$menuItem['link']?>" ><?=$menuItem['display']?></a></li>
                <?
                	if(isset($menuItem['sub'])){
						foreach($menuItem['sub'] as $menuSubItem){?>
                    	<li>-- <a href="<?=URL::base();?><?=$menuSubItem['link']?>" ><?=$menuSubItem['display']?></a></li>
	                <?
						}
					}
					?>
			<?}?>
		</ul>
	</div>
</div>