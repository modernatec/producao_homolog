    <span class='list_alert light_blue round'>
    <?
        if(count($taskList) <= 0){
            echo 'não encontrei tarefas não iniciadas.';    
        }else{
            echo 'encontrei: '. count($taskList).' tarefas';
        }
    ?>
    </span>
    <div class="list_body scrollable_content">
    <? 
    
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
                    <?
                        $calendar = URL::base().'/public/image/admin/calendar2.png';
                        if(strtotime($task->crono_date) < strtotime(date("Y-m-d H:i:s"))){
                            $class_obj = "ff0000";                            
                        }else{
                            $class_obj  = $task->tag->class;
                        }
                    ?>
                    <span class="round list_faixa left tag" style="background:#<?=$task->tag->class?>"><?=$task->tag->tag?> - <?=$task->object->objectStatus->prova?></span>                    
                    <div class="clear left" style="width:25px;">           
                        <? 
                            if($task->task_to != "0"){
                                echo Utils_Helper::getUserImage($task->to);   
                            }
                        ?>
                    </div>
                    <span class="<?=$task->status->class?> round left list_faixa"><?=$task->status->status;?></span>
                    <span class="round list_faixa left tag" style="background:#<?=$class_obj?>"><img src="<?=$calendar?>" height="12" valign='middle'> <?=Utils_Helper::data($task->crono_date)?></span>
                </a>
            </li>
        <?}
        echo '<ul>';
    ?>
    </div>
