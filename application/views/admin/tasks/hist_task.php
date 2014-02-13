<? if($status_task){?>
<div style='clear:both'>
	<div style='width:25px; float:left; margin-top:5px'>
		<img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="criada por: <?=ucfirst($status_task->userInfo->nome);?>" /> 
	</div>
	<div class='hist_task round' style='float:left;'>
	<div class='separator'>
		<b><?=$status_task->topic;?></b><br/>
		responsável: <?=$status_task->task_to->userInfo->nome?><br/>
		status: <?=$status_task->statu->status?> em <?=Utils_Helper::data($status_task->created_at, 'd/m/Y H:i')?>
	</div>
	<span class="wordwrap"><?=$status_task->description;?></span>
	
</div>
<?}?>