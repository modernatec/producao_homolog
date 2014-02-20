<? if($status_task){?>
<div style='clear:both'>
	<div style='width:25px; float:left; margin-top:5px'>
		<img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="criada por: <?=ucfirst($status_task->userInfo->nome);?>" /> 
	</div>
	<div class='hist_task round' style='float:left;'>
	<div class='line_bottom'>
		<b><?=$status_task->topic;?></b> <span class="status round <?=$status_task->getStatus($status_task->id)->statu->class?>"><?=$status_task->getStatus($status_task->id)->statu->status?></span><br/>
		criada por: <?=$status_task->userInfo->nome?> em <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?><br/>
	</div>
	<span class="wordwrap description"><?=$status_task->description;?></span>
	<div class="options line_up">
		<? if($status_task->getStatus($status_task->id) == '5'){?>
			<a href="<?=URL::base();?>admin/tasks/start/<?=$status_task->id?>" class="bar_button round">iniciar</a>
		<?}?>
	</div>
</div>
<?}?>