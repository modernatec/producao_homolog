<div class="topo" >
	<div class="tabs_panel">
		<div class="clear left">
	        <ul class="tabs">
	            <li class="round"><a id="task_1" class="ajax" href='<?=URL::base();?>admin/tasks/getTasks/<?=$filter?>'><?=$title?></a></li>
	            <?if($current_auth != "assistente" || $current_auth == "coordenador" || $current_auth == "admin"){?>
	            <!--li class="round"><a id="tab_2" class="ajax" href='<?=URL::base();?>admin/tasks/ongoing'>em fluxo</a></li-->
	            <?}?>
	            <li class="round"><a id="task_3" class="ajax" href='<?=URL::base();?>admin/tasks/getTasks/?to=<?=$userInfo_id?>'>Minhas tarefas</a></li>
	        </ul>  
	    </div>
    </div>
</div>
<div id="esquerda">
    <div id="tabs_content" >
        
    </div>
</div>
<div id="direita"></div>