<div class="content">

	<?if($current_auth != "assistente" || $current_auth == "coordenador" || $current_auth == "admin"){?>
		<div class="left">
			<div class="round_imgDetail blue">
				<a href="<?=URL::base();?>admin/tasks/">
					<img class="round_imgList" src="<?=URL::base();?>public/image/admin/default.png" height="20" style="float:left" alt="produção">
					<span>produção</span>				
				</a>
			</div>
			<div class="badge orange"><?=$totalTasks?></div>
		</div>
	<?foreach ($has_task as $user_task) {?>
		<div class="left">
			<div class="round_imgDetail <?=$user_task->to->team->color?>">
				<a href="<?=URL::base();?>admin/tasks/?to=<?=$user_task->to->id?>">
					<img class='round_imgList' src='<?=URL::base();?><?=($user_task->to->foto)?($user_task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($user_task->to->nome);?>" />
					<span><?$nome = explode(" ", $user_task->to->nome); echo $nome[0];?></span>				
				</a>
			</div>
			<div class="badge orange"><?=$user_task->getUserTasks($user_task->task_to)?></div>
		</div>
	<?}}?>
    <div id="tabs" class="clear">
        <ul>
            <li id="tab_1"><a href='<?=URL::base();?>admin/tasks/getTasks/<?=$filter?>'><?=$title?></a></li>
            <?if($current_auth != "assistente" || $current_auth == "coordenador" || $current_auth == "admin"){?>
            <li id="tab_3"><a href='<?=URL::base();?>admin/tasks/ongoing'>em fluxo</a></li>
            <?}?>
            <li id="tab_2"><a href='<?=URL::base();?>admin/tasks/getTasks/?to=<?=$userInfo_id?>'>Minhas tarefas</a></li>
        </ul>
        
        <div id="tabs_content">
            
        </div>
    </div>
    <? 
    	if($update){
    		echo '<span id="update"></span>';
    	}
    ?>
</div>
