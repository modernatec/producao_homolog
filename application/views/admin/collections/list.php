<div class="topo" >
	<span class="header"><a href="<?=URL::base();?>admin/collections/edit" rel="load-content" data-panel="#direita " class="bar_button round">cadastrar coleção</a></span>
</div>
<div id="esquerda">
    <ul class="tabs">
        <? foreach($collectionsList as $key=>$collection){?>
		<li class="round"><a class="ajax" id='tab_<?=$key+1;?>' href="<?=URL::base();?>admin/collections/getlist/<?=$collection->ano?>"><?=$collection->ano?></a></li>
		<?}?>
    </ul>  
    <div id="tabs_content">
        
    </div>
</div>
<div id="direita"></div>