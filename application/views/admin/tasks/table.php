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
        foreach($taskList as $key=>$task_status){?>
            <li class="dd-item step_<?=$task_status->status->type?>_status<?=$task_status->status_id?>" id="item-<?=$task_status->id?>">
                <a class="load"  href="<?=URL::base();?>admin/objects/view/<?=$task_status->task->object_id?>?c=tasks" rel="load-content" data-panel="#direita" title="+ informações">
                    <?
                        $diff = '';
                        if($task_status->task->diff != 0){
                            if($task_status->task->diff < 0){
                                $diff = '<span class="list_faixa green round">'.$task_status->task->diff.'</span>';
                            }else{
                                $diff = '<span class="list_faixa red round">+'.$task_status->task->diff.'</span>';
                            }
                        }
                    ?>
                    <div class="clear" style="overflow:auto;" >
                        <div class="left"><b><?=$task_status->task->object->taxonomia;?></b></div>
                        <div class="right"><?=$diff?></div>
                    </div>
                    <hr style="margin:5px 0;" class="clear" />
                    

                    <div class="clear">
                                           
                        <?
                            if(strtotime($task_status->task->crono_date) < strtotime(date("Y-m-d H:i:s"))){
                                $class_obj = "#ff0000";                            
                            }else{
                                $class_obj  = $task_status->task->tag->color;
                            }
                        ?>
                        <div class="left" style="width:25px;position:relative;top:-3px;">           
                            <? 
                                //if($task->task_to != "0"){
                                    echo Utils_Helper::getUserImage($task_status->user);   
                                //}
                            ?>
                        </div>
                        <span class="round list_faixa left tag" style="background:<?=$task_status->task->tag->color?>"><?=$task_status->task->tag->tag?></span>                    
                        <span class="round list_faixa left tag" style="background:<?=$class_obj?>"><?=Utils_Helper::data($task_status->task->crono_date)?></span>
                        
                    </div>
                </a>
            </li>
        <?}
        echo '<ul>';
    ?>
    </div>
