<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/objects/create" class="bar_button round">catalogar objeto</a>
	</div>    
    <div id="tabs" class="clear left">
        <ul>
            <? foreach($projectList as $project){?>
            <li id="tab_<?=$project->id?>"><a href='<?=URL::base();?>admin/objects/getObjects/<?=$project->id?>?fase=<?=$fase?>&tipo=<?=$filter_tipo?>&collection=<?=$filter_collection?>&status=<?=$filter_status?>&supplier=<?=$filter_supplier?>&taxonomia=<?=$filter_taxonomia?>&origem=<?=$filter_origem?>&materia=<?=$filter_materia?>'><?=$project->name?></a></li>
            <?}?>
        </ul>
        
        <div id="tabs_content">
            
        </div>
    </div>
    <div class="lateral">
        div lateral
    </div>
    <?=@$page_links?>
</div>
