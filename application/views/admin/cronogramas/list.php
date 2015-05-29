<div class="topo" >
    <div class="tabs_panel">
        <ul class="tabs">
            <? foreach($projectList as $key=>$project){?>
            <li class="round"><a class="ajax" data-clear="#direita" id='tab_<?=$key+1;?>' href='<?=URL::base();?>admin/cronogramas/getObjects/<?=$project->id?>' ><?=$project->name?></a></li>
            <?}?>
        </ul>  
    </div>
    <div class="clear" id="filtros"></div>
</div>
<div id="page">
    <div id="tabs_content" >
        
    </div>
</div>
