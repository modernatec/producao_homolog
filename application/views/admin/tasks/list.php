<div class="content">
	<?if($current_auth != "assistente" || $current_auth == "coordenador" || $current_auth == "admin"){?>
	<?foreach ($has_task as $user_task) {?>
		<div class="left">
			<div class="round_imgDetail">
				<img class='round_imgList' src='<?=URL::base();?><?=($user_task->to->foto)?($user_task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($user_task->to->nome);?>" />
				<span><?$nome = explode(" ", $user_task->to->nome); echo $nome[0];?></span>				
			</div>
			<div class="badge"><?=$user_task->getTasks($user_task->task_to)?></div>
		</div>
	<?}}?>
    <div id="tabs" class="clear">

        <ul>
            <li id="tab_1"><a href='<?=URL::base();?>admin/tasks/getTasks/?status=<?=json_encode(array("5"))?>'>Tarefas da equipe</a></li>
            <li id="tab_2"><a href='<?=URL::base();?>admin/tasks/getTasks/?userInfo_id=<?=$userInfo_id?>'>Minhas tarefas</a></li>
        </ul>
        
        <div id="tabs_content">
            
        </div>
    </div>
</div>