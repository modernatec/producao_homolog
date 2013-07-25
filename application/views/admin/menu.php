<div id="head">
	<div id="user_info">
		<a href="<?=URL::base();?>admin/users/editInfo" style="float:left;">
			<div class="foto" style="background: url('<?=URL::base();?><?=$user->userInfos->foto?>') no-repeat;"><!--style="background: url('<?=URL::base();?><?=$user->userInfos->foto?>')"--></div>
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