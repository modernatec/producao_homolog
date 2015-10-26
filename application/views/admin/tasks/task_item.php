<li class="dd-item <?=$object_late?>" id="item-<?=$task->id?>">
    <a class="load"  href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>?c=tasks" rel="load-content" data-panel="#direita">   
        <div class="right list_status">
            <div class="list_icon <?=$icon_status?>" title='<?=$task->status->status?>'></div>
        </div>                 
        <p><b><?=$task->object->title?></b></p>
        <p>
        <span class="subtitle"><?=$task->object->taxonomia?></span>
        <div class="left" style="width:25px;position:relative;top:-3px;margin-right:10px;">           
            <?=Utils_Helper::getUserImage($task->to);?>
        </div>
        <span class="subtitle"><p><?=$task->tag->tag?> | <?=Utils_Helper::data($task->crono_date)?></p></span></p>
        
    </a>
</li>