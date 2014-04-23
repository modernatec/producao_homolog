<div id="head">
	<div id="user_info">
		<a href="<?=URL::base();?>admin/users/editInfo" style="float:left;">
			<img class="foto" src="<?=URL::base();?><?=$user->userInfos->foto?>" />
			
	        <?=ucfirst($user->userInfos->nome);?>
	    </a>
        <a class="logout" href="<?=URL::base();?>logout/" title="Logout">logout</a>
	</div>
	<div id="menu">
		<ul >
			<?foreach($menuList as $key=>$menuItem){?>
				<li><a href="<?=URL::base();?><?=$menuItem['link']?>" ><?=$menuItem['display']?></a>
                <?if(isset($menuItem['sub'])){?>
                	<ul>
                	<?
						foreach($menuItem['sub'] as $menuSubItem){?>
                    	<li><a href="<?=URL::base();?><?=$menuSubItem['link']?>" ><?=$menuSubItem['display']?></a></li>
	                <?}?>
					</ul>
				<?}?>
				</li>
			<?}?>
		</ul>
	</div>
</div>