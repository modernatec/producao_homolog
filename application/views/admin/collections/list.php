<div class="topo" >
	<div class="tabs_panel">
		<ul class="tabs">
	        <? foreach($anosList as $ano){?>
			<li class="round"><a class="ajax" id='tab_<?=$ano->ano?>' href="<?=URL::base();?>admin/collections/getlist/<?=$ano->ano?>"><?=$ano->ano?></a></li>
			<?}?>
	    </ul>  
    </div>
	<div class="clear" id='filtros'></div>
</div>
<div id="esquerda">
    <div class="bar" style='margin-bottom:5px;'>
    	<a href="<?=URL::base();?>admin/collections/edit" rel="load-content" data-panel="#direita " class="bar_button round">cadastrar coleção</a>
	</div>    
    <div id="tabs_content">
        
    </div>
</div>
<div id="direita"></div>