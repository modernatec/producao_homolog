<? if($status_task){?>
<div style='clear:both'>
	<div style='width:25px; float:left; margin-top:5px'>
		<img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="<?=ucfirst($status_task->userInfo->nome);?>" /> 
	</div>
	<div class='hist_task round' style='float:left;'>
	<div class='separator'>
		<?=$status_task->userInfo->nome;?> <em>em <?=Utils_Helper::data($status_task->date, 'd/m/Y - H:i:s');?></em>
		<br/><b><?=$status_task->step;?></b> - <?=$status_task->statu->status;?>
	</div>
	<span class="wordwrap"><?=$status_task->description;?></span>
	<?	
	    $sldAberto = 1;
	    if($cntStsTsk>2){
	        $sldAberto = 0;
	    }
	    $filesList = $status_task->getFiles($status_task->id);
	    if(count($filesList) > 0){
	        echo View::factory('admin/files/fileslist')
	            ->bind('filesList', $filesList)
	            ->bind('status_task', $status_task)
	            ->bind('sldAberto', $sldAberto);
	    }
	?>
	</div>
</div>
<?}?>