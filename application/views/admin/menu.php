<div id="lateral">
	
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