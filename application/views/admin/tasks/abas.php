<div class="tabs_panel">
    <ul class="tabs">
        <li><span><a id="task_1" class="ajax" href='<?=URL::base();?>admin/tasks/getTasks/?to=<?=$userInfo_id?>'>Minhas tarefas</a></span></li>
        <li><span><a id="task_2" class="aba ajax" href='<?=URL::base();?>admin/tasks/getTasks/<?=$filter?>'><?=$title?></a></span></li>
        <?if($current_auth != "assistente" || $current_auth == "coordenador" || $current_auth == "admin"){?>
        <!--li class="round"><a id="tab_2" class="ajax" href='<?=URL::base();?>admin/tasks/ongoing'>em fluxo</a></li-->
        <?}?>
    </ul>  
</div>