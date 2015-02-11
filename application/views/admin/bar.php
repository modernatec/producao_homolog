<div id="bar">
	<div class="task_bar_item">
		<div class="round_imgDetail blue">
			<a class="load"  href="<?=URL::base();?>admin/tasks/getTasks/?status=5" rel="load-content" data-panel="#tabs_content" title="tarefas produção">
				<img class="round_imgList" src="<?=URL::base();?>public/image/admin/default.png" height="20" style="float:left" alt="produção">
				<div class="badge orange"><?=$totalTasks?></div>
				<span>produção</span>				
			</a>
		</div>				
	</div>
	<?foreach ($has_task as $user_task) {?>
	<div class="task_bar_item">

		<div class="round_imgDetail <?=$user_task->to->team->color?>">
			<a class="load"  href="<?=URL::base();?>admin/tasks/getTasks/?to=<?=$user_task->to->id?>" rel="load-content" data-panel="#tabs_content" title="tarefas">
				<img class='round_imgList' src='<?=URL::base();?><?=($user_task->to->foto)?($user_task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($user_task->to->nome);?>" />
				<div class="badge orange"><?=$user_task->getUserTasks($user_task->task_to)?></div>
				<span><?$nome = explode(" ", $user_task->to->nome); echo $nome[0];?></span>				
			</a>
		</div>
		
	</div>
	<?}?>
	
</div>