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
            <li class="dd-item step_<?=$task->status->type?>_status<?=$task->status->id?>" id="item-<?=$task->id?>">
                <a class="load"  href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>?c=tasks" rel="load-content" data-panel="#direita" title="+ informações">
                    <?
                        $diff = '';
                        if($task->diff != 0){
                            if($task->diff < 0){
                                $diff = '<span class="list_faixa green round">'.$task->diff.'</span>';
                            }else{
                                $diff = '<span class="list_faixa red round">+'.$task->diff.'</span>';
                            }
                        }
                    ?>
                    <div class="clear" style="overflow:auto;" >
                        <div class="left"><b><?=$task->object->taxonomia;?></b></div>
                        <div class="right"><?=$diff?></div>
                    </div>
                    <hr style="margin:5px 0;" class="clear" />
                    <!--div class="clear" style="margin:5px 0;">
                        <span class="round list_faixa tag" style="background:<?=$task->tag->color?>">
                            <?
                                $last_status = $task->object->status->order_by('id', 'DESC')->find();
                                echo $last_status->status;
                            ?>
                        </span> 
                    </div-->

                    <div class="clear">
                                           
                        <?
                            if(strtotime($task->crono_date) < strtotime(date("Y-m-d H:i:s"))){
                                $class_obj = "#ff0000";                            
                            }else{
                                $class_obj  = $task->tag->color;
                            }
                        ?>
                        <div class="left" style="width:25px;position:relative;top:-3px;">           
                            <? 
                                //if($task->task_to != "0"){
                                    echo Utils_Helper::getUserImage($task->to);   
                                //}
                            ?>
                        </div>
                        <span class="round list_faixa left tag" style="background:<?=$task->tag->color?>"><?=$task->tag->tag?></span>                    
                        <span class="round list_faixa left tag" style="background:<?=$class_obj?>"><?=Utils_Helper::data($task->crono_date)?></span>
                        <!--span class="<?=$task->status->type?>_status<?=$task->status->id?> round left list_faixa"><?=$task->status->status;?></span-->
                    </div>
                </a>
            </li>
        <?}
        echo '<ul>';
    ?>
    </div>
