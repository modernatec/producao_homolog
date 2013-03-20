<div>
	<div id="user_info">
		<div class="foto" style="background: url('<?=URL::base();?><?=$user->userInfos->foto?>')"><!--style="background: url('<?=URL::base();?><?=$user->userInfos->foto?>')"--></div>
	        <a href="<?=URL::base();?>admin/users/editInfo" style="float:left;" ><?=ucfirst($user->userInfos->nome);?></a>
        <a href="<?=URL::base();?>logout/">logout</a>
	</div>
	<div id="menu">
		<ul >
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