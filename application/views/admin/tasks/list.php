<div class="topo">
    <div id='filtros'>
    	<div class="tabs_panel">
		    <ul class="tabs">
		    	<?
		    		$my_task_post = json_encode(array('to' => $userInfo_id));
		    	?>
		        <li><a id="task_1" class="aba ajax" href='<?=URL::base();?>admin/tasks/getTasks/' data-post='<?=$my_task_post?>' >Minhas tarefas</a></li>
		        <li><a id="task_2" class="aba ajax" href='<?=URL::base();?>admin/tasks/getTasks/' data-post='<?=$data_post?>'><?=$title?></a></li>
		        
		    </ul>  
		</div>
    </div>
</div>
<div id="esquerda">
    <div id="tabs_content" >
        
    </div>
</div>
<div id="direita"></div>