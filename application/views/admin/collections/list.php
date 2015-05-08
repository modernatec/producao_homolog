<div class="topo" >
	<div class="tabs_panel">
		<ul class="tabs">
	        <? foreach($collectionsList as $key=>$collection){?>
			<li class="round"><a class="ajax" id='tab_<?=$key+1;?>' href="<?=URL::base();?>admin/collections/getlist/<?=$collection->ano?>"><?=$collection->ano?></a></li>
			<?}?>
	    </ul>  
    </div>
</div>
<div id="esquerda">
    <div class="bar" style='margin-bottom:5px;'>
    	<a href="<?=URL::base();?>admin/collections/edit" rel="load-content" data-panel="#direita " class="bar_button round">cadastrar coleção</a>
	</div>    
    <div id="tabs_content">
        
    </div>
</div>
<div id="direita"></div>