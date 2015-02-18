<div class="topo" >
	<span class="header">tarefas</span>
</div>
<div id="esquerda">
	<div class="clear"> 
	    <div class="fixed clear">
	        <div class="clear left">
	            <ul class="tabs">
	                <li class="round"><a id="tab_1" class="ajax" href='<?=URL::base();?>admin/tasks/getTasks/<?=$filter?>'>tarefas abertas</a></li>
		            <?if($current_auth != "assistente" || $current_auth == "coordenador" || $current_auth == "admin"){?>
		            <li class="round"><a id="tab_2" class="ajax" href='<?=URL::base();?>admin/tasks/ongoing'>em fluxo</a></li>
		            <?}?>
		            <li class="round"><a id="tab_3" class="ajax" href='<?=URL::base();?>admin/tasks/getTasks/?to=<?=$userInfo_id?>'>Minhas tarefas</a></li>
	            </ul>  
	        </div>
	        <div id="tabs_content" class="scrollable_content clear">
	            
	        </div>
	    </div>
	</div>
</div>
<div id="direita"></div>