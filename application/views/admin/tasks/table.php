<div class="fixed clear">
    <div class="list_header round">
        <div class="table_info round">
            <?=count($taskList)?> tarefas encontradas 
        </div>
    </div>
    <div class="list_body scrollable_content">
    <? 
    if(count($taskList) <= 0){
        echo '<span class="list_alert round">nenhum registro encontrado</span>';    
    }else{
        if($current_auth != "assistente"){
            $id = "sortable";
        }else{
            $id = "";
        }
                     
        echo '<ul class="list_item" id="'.$id.'">';
        foreach($taskList as $key=>$task){?>
            <li class="dd-item" id="item-<?=$task->id?>">
                <a class="load"  href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>" rel="load-content" data-panel="#direita" title="+ informações">
                <!--div class="list_order left"><?=$key+1?></div-->
                    <div >
                        <b><?=$task->object->taxonomia;?></b>
                        <hr style="margin:8px 0;" />
                        <!--p>&bull; <?=$task->object->supplier->empresa?>
                        </p-->
                        <!--p>por: <?=$task->userInfo->nome?> em: <?=Utils_Helper::data($task->created_at, "d/m/Y - H:i")?></p-->
                        
                    </div>
                    <div class="left" style="width:25px;">           
                        <? 
                            if($task->task_to != "0"){?>
                                <?=Utils_Helper::getUserImage($task->to)?>
                                <!--img class='round_imgList<?=$task->to->team->color?>' src='<?=Utils_Helper::getUserImage($task->to)?>' height="20" style='float:left' alt="<?=ucfirst($task->to->nome);?>" /-->
                            <?}else{ echo "&nbsp;";}?>
                    </div>
                    
                    <div class="left">
                        <span class="<?=$task->tag->class?> round list_faixa"><?=$task->tag->tag?> - <?=$task->object->objectStatus->prova?></span> <span class="<?=$task->status->class?> round list_faixa"><?=$task->status->status;?></span><span class="red round list_faixa"><img src="<?=URL::base()?>/public/image/admin/calendar2.png" height="16" valign='middle'> <?=Utils_Helper::data($task->crono_date)?></span> 
                    </div>
                </a>
            </li>
        <?}
        echo '<ul>';
    }?>
    </div>
</div>