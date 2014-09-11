<div class="fixed clear">
    <div class="bar">
        <a href="<?=URL::base();?>admin/objects/edit" rel="load-content" data-panel="#direita" class="bar_button round">catalogar objeto</a>
    </div>    
    <div class="clear left">
        <ul class="tabs">
            <? foreach($projectList as $key=>$project){?>
            <li class="round"><a class="ajax" id='tab_<?=$key+1;?>' href='<?=URL::base();?>admin/objects/getObjects/<?=$project->id?>' ><?=$project->name?></a></li>
            <?}?>
        </ul>  
    </div>
    <div id="tabs_content" class="scrollable_content clear">
        
    </div>
</div>
