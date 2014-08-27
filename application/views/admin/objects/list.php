<div class="content">
    <div id="esquerda">
        <div class="fixed clear">
            <div class="bar">
                <a href="<?=URL::base();?>admin/objects/edit" rel="load-content" data-panel="#direita" class="bar_button round">catalogar objeto</a>
            </div>    
            <div class="clear left">
                <ul class="tabs">
                    <? foreach($projectList as $project){?>
                    <li class="round"><a id='p<?=$project->id?>' href='<?=URL::base();?>admin/objects/getObjects/<?=$project->id?>' ><?=$project->name?></a></li>
                    <?}?>
                </ul>  
            </div>
            <div id="tabs_content" class="scrollable_content clear">
                
            </div>
        </div>
        
    </div>
    <div id="direita">
        
    </div>
</div>