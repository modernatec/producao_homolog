<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/collections/create" class="bar_button round">cadastrar coleção</a>
	</div>
	<div id="tabs">
		<ul>
			<? foreach($collectionsList as $collection){?>
			<li><a href="<?=URL::base();?>admin/collections/getlist/<?=$collection->ano?>"><?=$collection->ano?></a></li>
			<?}?>
		</ul>
		<div id="tabs_content">
			
		</div>
	</div>
	
</div>
