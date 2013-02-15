<? if($status_task){?>
<div class='hist_task round'>
<img src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25" style='float:left' alt="<?=ucfirst($status_task->userInfo->nome);?>" /> 
<?=$status_task->userInfo->nome;?> - <b><?=$status_task->statu->status;?></b> <em>em <?=Utils_Helper::data($status_task->date, 'd/m/Y - H:i:s');?></em>
<br/>
<?=$status_task->description;?>
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
<?}?>