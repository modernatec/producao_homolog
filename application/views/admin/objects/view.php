<div class="clear">
    <div class="oed_info">
        <a href="<?=URL::base();?>admin/objects/edit/<?=$obj->id?>" rel="load-content" data-panel="#direita" title='editar OED' class="black" >
            <span class="wordwrap"><b><?=@$obj->title;?></b></span>
        </a>
        <br/>
        <span class="wordwrap"><?=@$obj->taxonomia;?></span>

        <div class="right">
            <a class="popup icon icon_info" href="<?=URL::base().'admin/acervo/view/'.$obj->id?>" data-select="obj_<?=$obj->id?>" title="+ informações">infos</a>
        </div>
        <div class="line right">
            <?=Utils_Helper::data(@$obj->planned_date,'d/m/Y')?>
        </div>
        <hr class="clear" style="margin:8px 0;" />
        <div class="left">
        <?foreach ($obj->collection->userInfos->find_all() as $key => $userInfo) {?>
            <div class="left" style="width:25px;">           
            <?=Utils_Helper::getUserImage($userInfo);?>
            </div>
        <?}?>
        </div>
        <div class="right">
            <?
            $data_tarefa = json_encode(array('object_id' => $obj->id, 'status_id' => $objects_status[0]->id));
            if($current_auth != "assistente"){?>
                <a href="<?=URL::base();?>admin/tasks/update/" data-post='<?=$data_tarefa?>' title="criar tarefa" class="popup icon icon_task">nova tarefa</a>
                <a href="<?=URL::base();?>admin/objects/updateForm/" data-post='<?=$data_tarefa?>' title="alterar status" class="popup icon icon_status">alterar status</a>                           
            <?}?>
        </div>
    </div>

<div class="scrollable_content clear">             
    <?if(isset($objects_status)){
            $count = 0;
            foreach($objects_status as $object){

                /*
                * Verificar como melhorar...
                * Lista de tarefas
                */
                $query = $object->tasks->join('tags_teams', 'INNER')->on('tasks.tag_id', '=', 'tags_teams.tag_id');
                            
                if($current_auth != "admin"){
                    $query->where('tags_teams.team_id', '=', $user->team_id);
                }

                $task_tags = $query->group_by('tasks.id')->order_by('tasks.id', 'desc')->find_all();

                ?>                          
                    <div class="step clear">
                        <div class="team_step_<?=$object->status->team_id?> roundTop">
                            <?if($current_auth != "assistente"){?>
                                <div class="right">
                                    <a class="icon icon_excluir_white" href="<?=URL::base()?>admin/objects/deleteStatus/<?=$object->id?>" title="excluir" data-panel="#direita">Excluir</a>
                                </div>
                            <?}?>
                            <div class="right">
                                <a class="popup icon icon_comment_white" href="<?=URL::base()?>admin/anotacoes/form" data-post='<?=$data_tarefa?>' title="criar anotação">anotacao</a>
                            </div> 
                            <div>
                                <div class="collapse_holder left">
                                <?if(count($task_tags) > 0){?>
                                    <a class="collapse icon icon_expand_white" data-show="infos<?=$object->id?>" title="abrir/fechar infos">collapse</a>
                                <?}?>
                                </div>
                                <?
                                if($current_auth != "assistente" && $object->crono_date != ''){?>
                                    <a href="<?=URL::base();?>admin/objects/updateForm/<?=$object->id?>" title="editar status" class="popup left">
                                <?
                                }

                                $diff = '';
                                $status_class = $object->status->type.'_status'.$object->status->id;
                                if($object->diff != 0){

                                    if($object->diff < 0){
                                        $diff = '<span class="badge_line border_white round">'.$object->diff.'</span>';
                                        //$status_class = 'green';
                                    }else{
                                        $diff = '<span class="badge_line border_white round">+'.$object->diff.'</span>';
                                        $status_class = 'red';
                                    }
                                }

                                if($object->delivered_date != ''){
                                    $date_faixa = Utils_Helper::data($object->delivered_date, 'd/m/Y');
                                }else{
                                    if($object->crono_date != ''){
                                        $date_faixa = Utils_Helper::data($object->crono_date, 'd/m/Y').' ('.Utils_Helper::getday($object->crono_date).')';
                                    }else{
                                        $date_faixa = 'aguardando definição';
                                        $status_class = 'object_late';
                                    }
                                }
                                ?>
                                <p><?=$object->status->status;?> | <?=$date_faixa?> <?=$diff?></p>
                                    </a>
                            </div>
                        
                        </div>    
                        <div class='hist roundBottom' >                                
                            <?if(!empty($object->description)){ ?>
                                <div class="wordwrap description team_comment_<?=$object->status->team_id?>"><?=$object->description;?></div>
                            <?}

                            //finalizado
                            if($count == 0 && $object->status_id == '8' && $current_auth != "assistente"){?>
                                <div id="uploadPackage" data-action="<?=URL::base()?>admin/objects/upload/<?=$object->object_id?>" class="dropzone" >           
                                    <div class="dz-message" data-dz-message>
                                        <div class="clear" style="text-align:center; width:400px; margin:0 auto;">
                                            <img src='<?=URL::base()?>/public/image/admin/upload.png' valign="top" class="left" /><span class="left">clique ou arraste o pacote de fechamento (.zip)<br/>tamanho max.: 100mb</span>
                                        </div>                                    
                                    </div>    
                                </div>
                            <?}

                            $count++;

                            foreach ($object->anotacoes->order_by('id', 'desc')->find_all() as $anotacao) {?> 
                                <div class="clear">
                                    
                                    <div class="anotacoes"> 
                                        <?if($current_auth != "assistente"){?>                                        
                                        <div class="right">
                                            <a class="icon icon_excluir" href="<?=URL::base()?>admin/anotacoes/delete/<?=$anotacao->id?>" title="excluir" data-panel="#direita">Excluir</a>
                                        </div>
                                        <?}?>
                                        <div class="left icon icon_comment">anotações</div>
                                        <div class="left">
                                            <a href="<?=URL::base()?>admin/anotacoes/form/<?=$anotacao->id?>" data-post='<?=$data_tarefa?>' title="editar anotação" class="popup left">
                                                <p><?=$anotacao->userInfo->nome;?> | <?=Utils_Helper::data($anotacao->created_at, 'd/m/Y - H:i')?></p>
                                            </a>  
                                            <div class="clear">                                            
                                                <span class="wordwrap"><?=$anotacao->anotacao?></span>
                                            </div>                                          
                                        </div>
                                    </div> 
                                </div>
                            <?}  

                            
                            ?>
                            <div class="task_list">
                            <?
                                foreach ($task_tags as $task) {
                                    $status = $task->status->status;
                                    $icon_status = ($task->ended == '1') ? 'icon_expand' : 'icon_collapse';
                                    $status_class = ($task->ended == '1') ? 'hide' : '';
                            ?>                                     
                                    <div class="task_item clear">     
                                        <div class="collapse_holder left">
                                            <a class="collapse icon <?=$icon_status?> collapse_infos<?=$object->id?>" data-show="replies<?=$task->id?>" title="abrir/fechar infos">collapse</a>
                                        </div>                                    
                                        <div class="task">
                                            <div class="left"><?=Utils_Helper::getUserImage($task->userInfo)?></div>
                                            <?if($current_auth != "assistente"){?>
                                                <div class="right">
                                                    <a class="icon icon_excluir" href="<?=URL::base()?>admin/tasks/delete/<?=$task->id?>" data-panel="#direita" title="excluir">Excluir</a>
                                                </div>
                                            <?}?>
                                            <span class="right icon icon_<?=$task->status->status?>" title='<?=$task->status->status?>'><?=$task->status->status?></span>
                                            <?
                                            if($current_auth != "assistente"){?>
                                                <a href="<?=URL::base();?>admin/tasks/update/<?=$task->id?>" title="editar tarefa" class="left popup">
                                            <?}

                                                $diff = '';
                                                $color = $task->tag->color;
                                                if($task->diff != 0){
                                                    if($task->diff < 0){
                                                        $diff = '<span class="badge_line green round">'.$task->diff.'</span>';
                                                        //$color = $task->tag->color;
                                                    }else{
                                                        $diff = '<span class="badge_line red round">+'.$task->diff.'</span>';
                                                        $color = 'red';
                                                    }
                                                }

                                                if($task->delivered_date != ''){
                                                    $date_faixa = Utils_Helper::data($task->delivered_date, 'd/m/Y');
                                                }else{
                                                    $date_faixa = Utils_Helper::data($task->crono_date, 'd/m/Y');
                                                }

                                                ?>
                                                <p class="task_topic"><b><?=$task->tag->tag?> | <?=$date_faixa?></b> <?=$diff?></p>
                                            </a>                                         
                                            <div class="clear task_description replies<?=$task->id?> infos<?=$object->id?> <?=$status_class?>">
                                                <?if(!empty($task->description)){ ?>
                                                    <span class="wordwrap replies replies_<?=$task->id;?>"><?=$task->description;?></span>
                                                <?}?>
                                            </div> 
                                            <!--respostas-->
                                            <div class="clear task_reply replies<?=$task->id?> infos<?=$object->id?> <?=$status_class?>"> 
                                                <div style='clear:both'>
                                                    <div >
                                                        <div class="left"><?=Utils_Helper::getUserImage($task->to)?></div>
                                                        <div> 
                                                            <? 

                                                                if($task->status_id == '5'){
                                                                    if($task->tag_id == '7' && $current_auth == "assistente"){
                                                                        $start = false;
                                                                    }else{?>
                                                                        <a class="bar_button round startFinishTask" href="<?=URL::base();?>admin/tasks_status/start" data-taskid="<?=$task->id?>" data-objectid="<?=$task->object_id?>" >iniciar</a>
                                                                    <?}
                                                                }
                                                            
                                                                if($task->reply->id != '') {
                                                                    if($task->reply->finished != ""){
                                                                        $data = Utils_Helper::data($task->reply->finished, 'd/m/Y');
                                                                    }elseif($task->status_id == '6'){
                                                                        $data = Utils_Helper::data($task->reply->created_at, 'd/m/Y');
                                                                    }

                                                                    if($current_auth != "assistente" && $task->status_id != '6'){?>
                                                                        <a href="<?=URL::base();?>admin/tasks/updateReply/<?=$task->reply->id?>" title="editar resposta" class="left popup">
                                                                    <?}?>
                                                                            <p class="task_topic"><b><?=$task->status->status?> | <?=$data?></b></p>
                                                                        </a>
                                                                    <div class="clear task_description">
                                                                        <?if(!empty($task->reply->description)){ ?>
                                                                            <span class="wordwrap replies replies_<?=$task->id;?>"><?=$task->reply->description;?></span>
                                                                        <?}?>
                                                                        <div class="options" >
                                                                            <? if($task->status_id == '6' && $task->to->id == $user->id){?>
                                                                                <a href="<?=URL::base();?>admin/tasks/endtask/<?=$task->id?>" class="popup bar_button round">entregar</a>
                                                                                
                                                                            <?}?>

                                                                            <? if(($task->status_id == '7' && $task->ended == '0' && $task->userInfo_id == $user->id) || strpos($current_auth, 'assistente') === false){?>
                                                                                <a class="bar_button round startFinishTask" href="<?=URL::base();?>admin/tasks_status/finish" data-taskid="<?=$task->id?>" data-objectid="<?=$task->object_id?>" >confirmar recebimento</a>
                                                                                
                                                                            <?}?>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                <?}
                                                            ?>
                                                        </div> 
                                                    </div>
                                                </div>  
                                            </div>

                                        </div>
                                    </div>                                                                 
                                <?}?>
                            </div>
                        </div> 
                    </div>
                <?               
            }   
        }
    ?>
</div> 
</div>
