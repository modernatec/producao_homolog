<div class="clear">
    <div class="bar">
    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/objects/edit/<?=$obj->id?>" rel="load-content" data-panel="#direita" class="bar_button round">editar OED</a>       
    <?}?>
    <?if($current_auth == "coordenador" || $current_auth == "admin"){?>
        <a href="<?=URL::base();?>admin/custos/view/<?=$obj->id?>" class="bar_button round">custos</a>       
    <?}?>

    <?if($current_auth != "assistente"){?>
        <!--a href="<?=URL::base();?>admin/tasks/update/" class="popup bar_button round">criar tarefa</a--> 
        <a href="<?=URL::base();?>admin/objects/update/?object_id=<?=$obj->id?>" class="popup bar_button round">alterar status</a>                           
    <?}?>
    <a class="collapse bar_button round" data-show="replies"><span>contrair</span></a>
    </div>  
    <div class="boxwired round" >
        <b><span class="wordwrap"><?=@$obj->title;?></span></b><br/>
        <span class="wordwrap"><?=@$obj->taxonomia;?></span>
        <hr style="margin:8px 0;" />
        <?=@$obj->typeobject->name;?> 
        &bullet; <?=($obj->reaproveitamento == 0) ? "Novo" : "Reaproveitamento" ?>
        &bullet; <?=@$obj->supplier->empresa?>
        <br/>
        <b>fechamento:</b> <?=Utils_Helper::data($obj->collection->fechamento,'d/m/Y')?><br/>
    </div>

<div  class="scrollable_content clear">             
    <?if(isset($taskflows)){
            $count = 0;
            foreach($taskflows as $status_task){
                ?>                          
                    <div style='clear:both' >
                        <div class='hist round step'>
                            <div style='width:30px; float:left; margin:5px'>
                                <img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="<?=ucfirst($status_task->userInfo->nome);?>" /> 
                            </div>
                            <?if($current_auth != "assistente"){?>
                                <div class="right">
                                    <a class="excluir" href="<?=URL::base()?>admin/objects/deleteStatus/<?=$status_task->id?>" title="excluir" data-panel="#direita">Excluir</a>
                                </div>
                            <?}?>

                            <div class="right">
                                <a href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?status_id=<?=$status_task->id?>" title="criar anotações" class="popup note">anotacao</a>
                            </div> 
                            <? if($count == 0){
                                    if($current_auth != "assistente"){?>
                                        <div class="right">
                                            <a href="<?=URL::base();?>admin/tasks/update/?object_id=<?=@$obj->id?>&object_status_id=<?=$status_task->id?>" title="criar tarefa" class="popup task_icon">nova tarefa</a> &bull;
                                        </div>
                            <?      
                                    }
                                    $count++;
                                }
                            ?>
                                                       
                            <div class='line_bottom'>
                                <?if($current_auth != "assistente"){?>
                                    <a href="<?=URL::base();?>admin/objects/update/<?=$status_task->id?>" class="popup edit black">
                                <?}?>
                                <b><?=$status_task->status->status;?> <?=!empty($status_task->prova) ? '('.$status_task->prova.')' : ""?></b></a> - <?=Utils_Helper::getday($status_task->created_at)?> &bull; <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?> <br/>
                                
                                retorno: <?=Utils_Helper::getday($status_task->crono_date)?> &bull; <?=Utils_Helper::data($status_task->crono_date, 'd/m/Y')?>
                            </div>

                            
                            <?if(!empty($status_task->description)){ ?>
                                <span class="wordwrap description"><?=$status_task->description;?></span>
                            <?}?>


                            <?foreach ($status_task->getHistory($status_task->id) as $task) {?> 
                                <? if($task->type == 'anotacoes'){?>
                                    <div style='clear:both'>
                                        <div class="hist anotacoes round"> 
                                            <div class="left">
                                                <div class="round_imgDetail <?=$task->to->team->color?>">
                                                    <img class='round_imgList' src='<?=URL::base();?><?=($task->userInfo->foto)?($task->userInfo->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->userInfo->nome);?>" />
                                                    <span><?$nome = explode(" ", $task->userInfo->nome); echo $nome[0];?></span>
                                                </div>
                                            </div>
                                            <div class="left">
                                                <a href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?anotacao_id=<?=$task->id?>&status_id=<?=$status_task->id?>" title="anotações" class="popup edit black"><b>anotação</b></a><br/>  
                                                em: <?=Utils_Helper::data($task->created_at, 'd/m/Y - H:i')?>
                                            </div>
                                            <?if($current_auth != "assistente"){?>                                        
                                            <div class="right">
                                                <a class="excluir" href="<?=URL::base()?>admin/anotacoes/delete/<?=$task->id?>" data-panel="#direita" title="Excluir">Excluir</a>
                                            </div>
                                            <?}?>
                                            <div class="clear">
                                                <hr style="margin:8px 0;" />
                                                <pre><span class="wordwrap"><?=$task->description?></span></pre>
                                            </div>
                                        </div> 
                                    </div>
                                <?}else{?>
                                    <div style='clear:both'>
                                        <div class='hist task round'>
                                            <?if($current_auth != "assistente"){?>
                                                <div class="right">
                                                    <a class="excluir" href="<?=URL::base()?>admin/tasks/delete/<?=$task->id?>" data-panel="#direita" title="excluir">Excluir</a>
                                                </div>
                                            <?}?>
                                            <div class='line_bottom'>
                                                <div class="left">
                                                    <?if($current_auth != "assistente"){?>
                                                        <a href="<?=URL::base();?>admin/tasks/update/<?=$task->id?>" class="popup edit black">
                                                    <?}?>
                                                    <span class="<?=$task->tag->class?> round list_faixa"><?=$task->tag->tag?></span></a> 
                                                </div>
                                                <? if($task->task_to != "0"){?>
                                                    
                                                    <div class="round_imgDetail <?=$task->to->team->color?>">
                                                        <img class='round_imgList' src='<?=URL::base();?><?=($task->to->foto)?($task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->to->nome);?>" />
                                                        <span><?$nome = explode(" ", $task->to->nome); echo $nome[0];?></span>
                                                    </div>
                                                <?}?>
                                                <span class="status round <?=$task->status->class?>"><?=$task->status->status?></span>
                                                <div class="clear" style="padding-top:5px;">
                                                    por: <?=$task->userInfo->nome?><br/>
                                                    solicitado: <label><?=Utils_Helper::getday($task->created_at)?> &bull; <?=Utils_Helper::data($task->created_at, 'd/m/Y - H:i')?></label> 
                                                    <br/>
                                                    retorno: <label><?=Utils_Helper::getday($task->crono_date)?> &bull; <?=Utils_Helper::data($task->crono_date, 'd/m/Y')?></label>
                                                </div>                                                    
                                            </div>
                                            <?if(!empty($task->description)){ ?>
                                                <span class="wordwrap description replies replies_<?=$task->id;?>"><?=$task->description;?></span>
                                            <?}?>
                                            <div class="options">
                                                <? if($task->status_id != '5'){?>
                                                    <a class="down_button fade" data-show="replies_<?=$task->id;?>"><img src="<?=URL::base();?>public/image/admin/down.png" title="detalhar tarefa" /></a>                          
                                                <?}?>
                                            </div>  
                                        </div>
                                        <div class="replies replies_<?=$task->id;?>">
                                             <? if($task->status_id == '5'){?>
                                                <form action="<?=URL::base();?>admin/taskstatus/start" id="startTask" method="post" class="form">
                                                    <input type="hidden" name='task_id' value="<?=$task->id?>" />
                                                    <input type="hidden" name='object_id' value="<?=$task->object_id?>" />
                                                    <input type="submit" class="bar_button round" value="iniciar">
                                                </form>
                                            <?}?>
                                            <?foreach ($task->getReplies($task->id) as $taskReply) {?>
                                            <div style='clear:both'>
                                                <div class='hist_reply round'>
                                                    <div class='line_bottom'>
                                                        <? if($current_auth != "assistente"){?>
                                                            <a href="<?=URL::base();?>admin/tasks/updateReply/<?=$taskReply->id?>" class="popup edit black">
                                                        <?}?>
                                                        <?=$taskReply->status->status?></a> &bull; <?=Utils_Helper::getday($taskReply->created_at)?> - <?=Utils_Helper::data($taskReply->created_at, 'd/m/Y - H:i')?><br/>
                                                    </div>
                                                    <?if(!empty($taskReply->description)){ ?>
                                                        <span class="wordwrap description"><?=$taskReply->description;?></span>
                                                    <?}?>
                                                    <div class="options">
                                                        <? if($task->status_id == '6' && $taskReply->userInfo_id == $user->id){?>
                                                            <form id="formEndTask" name="formEndTask" action="<?=URL::base();?>admin/taskstatus/end" method="post" class="form">
                                                                <input type="hidden" name='task_id' value="<?=$task->id?>" />
                                                                <input type="hidden" name='object_id' value="<?=$task->object_id?>" />
                                                                <input type="hidden" name='next_step' id="next_step" value="0" />
                                                                <dd>
                                                                    <textarea placeholder="observações" class="text round" name="description" id="description" style="width:480px; height:50px;"></textarea>
                                                                    <span class='error'><?=Arr::get($errors, 'description');?></span>
                                                                </dd>
                                                                <? if($task->tag_id == '1'){?>
                                                                    <input type="submit" value="liberar" id="submit_btn" class="green round" />
                                                                    <!--a href='#' class="bar_button round red" id="correcao" >solicitar correção</a-->
                                                                <?}else{?>
                                                                    <input type="submit" value="entregar" class="green round" />
                                                                <?}?>
                                                            </form>
                                                        <?}?>
                                                    </div>  
                                                </div>
                                            </div>  
                                            <?}?>
                                        </div>                                    
                                    </div>
                            <?}}?>
                        </div> 
                        
                    </div>
                <?               
            }   
        }
    ?>
</div> 
</div>
