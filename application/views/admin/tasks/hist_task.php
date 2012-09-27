<?if($status_task){?>
<div class='hist_task round'>
<? $imgSrc = ($status_task->user->userInfos->foto)?($status_task->user->userInfos->foto):('public/image/admin/default.png');?>
<img src='<?=URL::base();?><?=$imgSrc?>' height="25" style='float:left' alt="<?=ucfirst($status_task->user->username);?>" /> 
<?=$status_task->user->userInfos->nome;?> - <b><?=$status_task->statu->status;?></b> <em>em <?=Utils_Helper::data($status_task->date, 'd/m/Y - H:i:s');?></em>
<br/><?=$status_task->description;?>
<?	
    $sldAberto = 1;
    if($cntStsTsk>2){
        $sldAberto = 0;
    }
    $filesList = $status_task->files->find_all();
    if(count($filesList) > 0){
        echo View::factory('admin/fileslist')
            ->bind('filesList', $filesList)
            ->bind('status_task', $status_task)
            ->bind('sldAberto', $sldAberto);
    }
?>
</div>
<?}?>