<div>
	<div id="user_info">
            <table> <tr> <td>
            <img src='<?=URL::base();?><?=$userInfo->foto?>' height="25" alt="<?=ucfirst($user->username);?>" />
            </td><td>
            <?=ucfirst($user->username);?>
            </td> </tr> </table>
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