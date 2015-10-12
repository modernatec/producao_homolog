<?foreach ($teamsVO as $team){
	$data_team = json_encode(array('team'=>$team['id']));
?>
<div class="task_bar_item">
	<div class="icon_team">
		<a class="load"  href="tasks/index/ajax" data-post='<?=$data_team?>' rel="task_bar" data-panel="#content" data-refresh="true" title="tarefas <?=$team['name']?>">
			<div class="round_imgList team_<?=$team['id']?>" style="float:left"><span><?=$team['ico']?></span></div>
			<div class="badge cyan"><?=$team['qtd']?></div>				
		</a>
	</div>				
</div>	
<?}?>

<?foreach ($has_task as $user_task) {
	$data_post = json_encode(array('to'=>$user_task->to->id));
?>
<div class="task_bar_item">
	<div class="icon_team">
		<a class="load" href="tasks/index/ajax" data-post='<?=$data_post?>' rel="task_bar" data-panel="#content" data-refresh="true" title="<?=ucfirst($user_task->to->nome);?>">
			<div class="left"><?=Utils_Helper::getUserImage($user_task->to)?></div>
			<div class="badge cyan"><?=$user_task->total?></div>			
		</a>
	</div>
	
</div>
<?}?>	
