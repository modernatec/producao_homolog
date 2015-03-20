<div class="task_bar_item">
	<div class="icon_team">
		<a class="load"  href="<?=URL::base();?>admin/tasks/index/ajax/?status=5" rel="task_bar" data-panel="#content" data-refresh="true" title="tarefas produção">
			<p class="round_imgListblue blue" style="float:left"><span>P</span></p>
			<!--img class="round_imgList" src="<?=URL::base();?>public/image/admin/default.png" height="20" style="float:left" alt="produção"-->
			<div class="badge orange"><?=$totalTasks?></div>				
		</a>
	</div>				
</div>
<?foreach ($has_task as $user_task) {?>
<div class="task_bar_item">
	<div class="icon_team">
		<a class="load"  href="<?=URL::base();?>admin/tasks/index/ajax/?to=<?=$user_task->to->id?>" rel="task_bar" data-panel="#content" data-refresh="true" title="<?=ucfirst($user_task->to->nome);?>">
			<div class="left"><?=Utils_Helper::getUserImage($user_task->to)?></div>
			<!--img class='round_imgList<?=$user_task->to->team->color;?>' src='<?=Utils_Helper::getUserImage($user_task->to)?>' height="20" alt="<?=ucfirst($user_task->to->nome);?>" /-->
			<div class="badge orange"><?=$user_task->getUserTasks($user_task->task_to)?></div>			
		</a>
	</div>
	
</div>
<?}?>	
