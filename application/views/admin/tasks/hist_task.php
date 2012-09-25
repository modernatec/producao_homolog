<?if($status_task){?>
<div class='hist_task round'>
<img src='<?=URL::base();?><?=($status_task->user->userInfos->foto)?($status_task->user->userInfos->foto):('public/image/admin/default.png')?>' height="25" style='float:left' alt="<?=ucfirst($status_task->user->username);?>" /> 
<?=$status_task->user->userInfos->nome;?> - <?=$status_task->statu->status;?> em <?=Utils_Helper::data($status_task->date, 'd/m/Y - H:i:s');?>
<br/><?=$status_task->description;?>
<?	
	$filesList = $status_task->files->find_all();
	if(count($filesList) > 0){
		echo View::factory('admin/fileslist')
				->bind('filesList', $filesList);
	}
?>
</div>
<?}?>