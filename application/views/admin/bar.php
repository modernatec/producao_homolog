<?foreach ($teamsVO as $team){?>
<div class="task_bar_item">
	<div class="icon_team">
		<a class="load"  href="tasks/index/ajax?team=<?=$team['id']?>" rel="task_bar" data-panel="#content" data-refresh="true" title="tarefas <?=$team['name']?>">
			<div class="round_imgList team_<?=$team['id']?>" style="float:left"><span><?=$team['ico']?></span></div>
			<div class="badge cyan"><?=$team['qtd']?></div>				
		</a>
	</div>				
</div>	
<?}?>

<?foreach ($has_task as $user_task) {?>
<div class="task_bar_item">
	<div class="icon_team">
		<a class="load" href="tasks/index/ajax?to=<?=$user_task->to->id?>" rel="task_bar" data-panel="#content" data-refresh="true" title="<?=ucfirst($user_task->to->nome);?>">
			<div class="left"><?=Utils_Helper::getUserImage($user_task->to)?></div>
			<div class="badge cyan"><?=$user_task->total?></div>			
		</a>
	</div>
	
</div>
<?}?>	
