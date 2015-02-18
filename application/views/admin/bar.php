<div class="task_bar_item">
	<div class="icon_team">
		<a class="load"  href="<?=URL::base();?>admin/tasks/getTasks/?status=5" rel="load-content" data-panel="#tabs_content" title="tarefas produção">
			<p class="round_imgList blue" style="float:left"><span>P</span></p>
			<!--img class="round_imgList" src="<?=URL::base();?>public/image/admin/default.png" height="20" style="float:left" alt="produção"-->
			<div class="badge orange"><?=$totalTasks?></div>				
		</a>
	</div>				
</div>
<?foreach ($has_task as $user_task) {?>
<div class="task_bar_item">

	<div class="icon_team">
		<a class="load"  href="<?=URL::base();?>admin/tasks/getTasks/?to=<?=$user_task->to->id?>" rel="load-content" data-panel="#tabs_content" title="tarefas">
			<img class='round_imgList' src='<?=URL::base();?><?=($user_task->to->foto)?($user_task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($user_task->to->nome);?>" />
			<div class="badge orange"><?=$user_task->getUserTasks($user_task->task_to)?></div>			
		</a>
	</div>
	
</div>
<?}?>	
