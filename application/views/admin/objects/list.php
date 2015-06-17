<div class="topo" >
    <div class="tabs_panel">
        <ul class="tabs">
            <? foreach($projectList as $key=>$project){?>
            <li class="round"><a class="ajax" data-clear="#direita" id='tab_<?=$key+1;?>' href='<?=URL::base();?>admin/objects/getObjects/<?=$project->id?>' ><?=$project->name?></a></li>
            <?}?>
        </ul>  
    </div>
    <div class="clear" id="filtros"></div>
</div>
<div id="esquerda">
    <div class="bar" style='margin-bottom:5px;'>
        <a href="<?=URL::base();?>admin/objects/edit" rel="load-content" data-panel="#direita" class="bar_button round">catalogar objeto</a>
    </div>    
    
    <div id="tabs_content" >
        
    </div>
</div>
<div id="direita"></div>