<div id="lateral">
	<div class="user_info"  >
		<div class='left'><?=Utils_Helper::getUserImage($user->userInfos)?></div>			
        <div class="left filter" >
            <ul>
                <li class="round" >
                    <span class="round user_name" id="user"><?$nome = explode(" ", $user->userInfos->nome); echo ucfirst($nome[0]);?></span>
                    <div class="filter_panel_arrow"></div>
                    <div class="filter_panel round" >
                        <ul>
                            <li class="user_menu_item">
                            	<a href="<?=URL::base();?>admin/users/edituser/<?=$user->userInfos->id?>" rel="load-content" data-panel="#content" class='user_menu'>
                            		<div class="left icon icon_edit"></div> <span>Editar perfil</span>
                            	</a>
                            </li>
                            <li class="user_menu_item">
                            	<a href="<?=URL::base();?>logout/" class='user_menu'>
                            		<div class="left icon icon_logout"></div> <span>Logout</span>
                            	</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
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