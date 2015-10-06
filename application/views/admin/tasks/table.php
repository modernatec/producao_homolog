    <span class='list_alert'>
    <?
        if(count($taskList) <= 0){
            echo 'não encontrei tarefas não iniciadas.';    
        }else{
            echo count($taskList).' tarefas encontradas';
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
                <div class="item_content">
                <a class="load"  href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>?c=tasks" rel="load-content" data-panel="#direita" title="+ informações">
                    <?
                        $object_late = '';

                        $diff = '';
                        if($task->diff != 0){
                            if($task->diff < 0){
                                $diff = '<span class="list_faixa green round">'.$task->diff.'</span>';
                            }else{
                                $diff = '<span class="list_faixa red round">+'.$task->diff.'</span>';
                            }
                        }

                        if(strtotime($task->crono_date) < strtotime(date("Y-m-d H:i:s"))){
                            $object_late = "red";                            
                            $icon_status = 'list_'.$task->status->status.'_white';
                        }else{
                            $icon_status = 'list_'.$task->status->status;
                        }
                    ?>
                    
                    <div class="right list_status <?=$object_late?>">
                        <div class="list_icon <?=$icon_status?>"></div>
                    </div>                 
                    <p><?=$task->object->taxonomia;?></p>
                    <div class="left" style="width:25px;position:relative;top:-3px;margin-right:10px;">           
                        <?=Utils_Helper::getUserImage($task->to);?>
                    </div>
                    <p><?=$task->tag->tag?> | <?=Utils_Helper::data($task->crono_date)?></p>
                    
                </a>
                </div>
            </li>
        <?}
        echo '<ul>';
    ?>
    </div>
