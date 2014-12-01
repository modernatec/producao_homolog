<div class="topo" >
	<span class="header">coleções</span>
</div>
<div id="esquerda">
	<div class="fixed clear">
		<div class="bar">
			<a href="<?=URL::base();?>admin/collections/edit" rel="load-content" data-panel="#direita " class="bar_button round">cadastrar coleção</a>
		</div>
		<div class="clear left">
	        <ul class="tabs">
	            <? foreach($collectionsList as $key=>$collection){?>
				<li class="round"><a class="ajax" id='tab_<?=$key+1;?>' href="<?=URL::base();?>admin/collections/getlist/<?=$collection->ano?>"><?=$collection->ano?></a></li>
				<?}?>
	        </ul>  
	    </div>
	    <div id="tabs_content" class="scrollable_content clear">
	        
	    </div>
	</div>
</div>
<div id="direita"></div>