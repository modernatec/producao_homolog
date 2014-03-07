<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/objects/create" class="bar_button round">catalogar objeto</a>
	</div>
	<span class="header">Objetos</span>
    
    <div id="tabs" class="clear">
        <ul>
            <? foreach($projectList as $project){?>
            <li id="tab_<?=$project->id?>"><a href='<?=URL::base();?>admin/objects/getCollections/<?=$project->id?>?tipo=<?=$filter_tipo?>&collection=<?=$filter_collection?>&status=<?=$filter_status?>&supplier=<?=$filter_supplier?>&taxonomia=<?=$filter_taxonomia?>'><?=$project->name?></a></li>
            <?}?>
        </ul>
        
        <div id="tabs_content">
            
        </div>
    </div>
    <?=$page_links?>
</div>
