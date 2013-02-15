	<div class="filelist">
    <a href="javascript:sldBox('#hsFl_<?=$status_task->id?>');" class="h">Arquivos</a>
    <ul id="hsFl_<?=$status_task->id?>" style="<?=($sldAberto)?'display:block':'display:none'?>">
        <?foreach($filesList as $file){?>
        <li><a href="<?=URL::base();?>admin/files/download/<?=$file->id?>" title="<?=basename($file->uri)?>" ><?=basename($file->uri)?></a>
            <?=Utils_Helper::preview($file)?>
        <?}?>
    </ul>
</div>
