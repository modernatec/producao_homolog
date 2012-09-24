<div class='hist_task round'>
<?=$status_task->user->name;?> - <?=$status_task->statu->status;?> em <?=Utils_Helper::data($status_task->date, 'd/m/Y - H:i:s');?>
<br/><?=$status_task->description;?>
<?	
	$filesList = $status_task->files->find_all();
	if(count($filesList) > 0){
		echo View::factory('admin/fileslist')
				->bind('filesList', $filesList);
	}
?>
</div>