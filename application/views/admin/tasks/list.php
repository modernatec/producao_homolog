<div class="content">
    <div id="tabs" class="clear">
        <ul>
            <li id="tab_<?=$project->id?>"><a href='<?=URL::base();?>admin/tasks/getTasks/?status=5'>Tarefas da equipe</a></li>
            <li id="tab_<?=$project->id?>"><a href='<?=URL::base();?>admin/tasks/getTasks/?status=6&userInfo_id=<?=$userInfo_id?>'>Minhas tarefas</a></li>
        </ul>
        
        <div id="tabs_content">
            
        </div>
    </div>
</div>