<div class="clear">



    <div class="bar">
    
    <?
    if($last_status->status_id == '8'){?>
        <a href='<?=URL::base();?>/admin/acervo/preview/<?=$obj->id?>' class="bar_button round view_oed">visualizar</a>
    <?}?>

        
    </div>  
    <div class="oed_info">
        <span class="wordwrap"><b><?=@$obj->title;?></b></span><br/>
        <span class="wordwrap"><?=@$obj->taxonomia;?></span>

        <div class="right">
            <a href="" title="infos" class="popup icon icon_info">infos</a>
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
            <?if($current_auth != "assistente"){?>
                <a href="<?=URL::base();?>admin/tasks/update/" title="criar tarefa" class="popup icon icon_task">nova tarefa</a>
                <a href="<?=URL::base();?>admin/objects/updateForm/?object_id=<?=$obj->id?>" class="popup icon icon_status">alterar status</a>                           
            <?}?>
        </div>
    </div>

<div class="scrollable_content clear">             
    <?if(isset($objects_status)){
            $count = 0;
            foreach($objects_status as $object){
                ?>                          
                    <div class="step clear">
                        <div class="team_step_<?=$object->status->team_id?> roundTop">
                            <?if($current_auth != "assistente"){?>
                                <div class="right">
                                    <a class="icon icon_excluir_white" href="<?=URL::base()?>admin/objects/deleteStatus/<?=$object->id?>" title="excluir" data-panel="#direita">Excluir</a>
                                </div>
                            <?}?>
                            <div class="right">
                                <a class="popup icon icon_comment_white" href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?status_id=<?=$object->id?>" title="criar anotações">anotacao</a>
                            </div> 
                            <div>
                                <a class="left icon icon_collapse" href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?status_id=<?=$object->id?>" title="criar anotações">anotacao</a>
                                <?if($current_auth != "assistente" && $object->crono_date != ''){?>
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
                                            <a href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?anotacao_id=<?=$anotacao->id?>&status_id=<?=$object->id?>" title="anotações" class="popup black">
                                                <p><?=$anotacao->userInfo->nome;?> | <?=Utils_Helper::data($anotacao->created_at, 'd/m/Y - H:i')?></p>
                                            </a>  
                                            <div class="clear">                                            
                                                <span class="wordwrap"><?=$anotacao->anotacao?></span>
                                            </div>                                          
                                        </div>
                                    </div> 
                                </div>
                            <?}  

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
                            <div class="task_list">
                            <?
                                foreach ($task_tags as $task) {?>   
                                    <div class="task_item clear">                                                          
                                        <div class="task">
                                            <div class="left"><?=Utils_Helper::getUserImage($task->userInfo)?></div>
                                            <?if($current_auth != "assistente"){?>
                                                <div class="right">
                                                    <a class="icon icon_excluir" href="<?=URL::base()?>admin/tasks/delete/<?=$task->id?>" data-panel="#direita" title="excluir">Excluir</a>
                                                </div>
                                            <?}?>
                                            <span class="right icon icon_<?=$task->status->status?>"><?=$task->status->status?></span>
                                            <?
                                            if($current_auth != "assistente"){?>
                                                <a href="<?=URL::base();?>admin/tasks/update/<?=$task->id?>" title="editar tarefa" class="popup">
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
                                            <div class="task_description">
                                                <?if(!empty($task->description)){ ?>
                                                    <span class="wordwrap replies replies_<?=$task->id;?>"><?=$task->description;?></span>
                                                <?}?>
                                            </div> 
                                            <!--respostas-->
                                            <div class="task_reply replies_<?=$task->id;?>"> 
                                                <div style='clear:both'>
                                                    <div >
                                                        <div class="left"><?=Utils_Helper::getUserImage($task->to)?></div>
                                                        <div> 
                                                            <? 
                                                                if($task->status_id == '5'){
                                                                    if($task->tag_id == '7' && $current_auth == "assistente"){
                                                                        $start = false;
                                                                    }else{?>
                                                                        <div style="padding:8px 0;">
                                                                            <a class="bar_button round startTask" href="<?=URL::base();?>admin/tasks_status/start" data-taskid="<?=$task->id?>" data-objectid="<?=$task->object_id?>" >iniciar</a>
                                                                        </div>
                                                                    <?}
                                                                }
                                                            
                                                                if($task->reply->id != '') {
                                                                    if($task->reply->finished != ""){
                                                                        $data = Utils_Helper::data($task->reply->finished, 'd/m/Y');
                                                                    }elseif($task->status_id == '6'){
                                                                        $data = Utils_Helper::data($task->reply->created_at, 'd/m/Y');
                                                                    }

                                                                    if($current_auth != "assistente"){?>
                                                                        <a href="<?=URL::base();?>admin/tasks/updateReply/<?=$task->reply->id?>" title="editar resposta" class="popup black">
                                                                    <?}?>
                                                                            <p class="task_topic"><b><?=$task->status->status?> | <?=$data?></b></p>
                                                                        </a>
                                                                    <div class="task_description">
                                                                        <?if(!empty($task->reply->description)){ ?>
                                                                            <span class="wordwrap replies replies_<?=$task->id;?>"><?=$task->reply->description;?></span>
                                                                        <?}?>
                                                                        <div class="options" >
                                                                            <? if($task->status_id == '6' && $task->to->id == $user->id){?>
                                                                                <div style="min-height:25px;">
                                                                                    <a href="<?=URL::base();?>admin/tasks/endtask/<?=$task->id?>" class="popup bar_button round">entregar</a>
                                                                                </div>
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
