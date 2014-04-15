<div class="content">
    <div id="tabs" class="clear">

        <ul>
            <li id="tab_1"><a href='<?=URL::base();?>admin/tasks/getTasks/?status=<?=json_encode(array("5"))?>'>Tarefas da equipe</a></li>
            <li id="tab_2"><a href='<?=URL::base();?>admin/tasks/getTasks/?userInfo_id=<?=$userInfo_id?>'>Minhas tarefas</a></li>
        </ul>
        
        <div id="tabs_content">
            
        </div>
    </div>
</div>