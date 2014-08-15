<div id="head">
	<div id="user_info">
		<a href="<?=URL::base();?>admin/users/editInfo" style="float:left;">
			<img class="round_imgList" src="<?=URL::base();?><?=$user->userInfos->foto?>" />
			
	        <?=ucfirst($user->userInfos->nome);?>
	    </a>
	</div>
	<div id="menu">
		<ul >
			<?foreach($menuList as $key=>$menuItem){?>
				<li class="round"><a href="<?=URL::base();?><?=$menuItem['link']?>" ><?=$menuItem['display']?></a></li>
                <?if(isset($menuItem['sub'])){?>
                	<ul class="submenu">
                	<?
						foreach($menuItem['sub'] as $menuSubItem){?>
                    	<li class="round"><a href="<?=URL::base();?><?=$menuSubItem['link']?>" ><?=$menuSubItem['display']?></a></li>
	                <?}?>
					</ul>
				<?}?>
			<?}?>
		</ul>
	</div>
	<a class="logout" href="<?=URL::base();?>logout/" title="Logout">logout</a>
</div>