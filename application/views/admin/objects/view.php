<div class="content">
    <div class="bar">
        <a href="<?=URL::base();?>admin/objects" class="bar_button round">voltar</a>
        <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/objects/edit/<?=$obj->id?>" class="bar_button round">editar OED</a>
        
        <a href="#" data-show="form_status" class="bar_button round show">alterar status</a>
        <a href="#" data-show="form_assign" class="bar_button round show">criar tarefa</a>
        <?}?>
    </div>
    
    <div class="box round left">
        <b>título:</b> <?=@$obj->title;?><br/>
        <b>taxonomia:</b> <?=@$obj->taxonomia;?><br/>
        <b>produtora:</b> <?=@$obj->supplier->empresa?><br/>
        <b>tipo:</b> <?=@$obj->typeobject->name;?><br/>
        <b>classificação:</b> <?=($obj->reaproveitamento == 0) ? "Novo" : "Reaproveitamento" ?><br/>
        <b>obs:</b> <?=@$obj->obs?><br/>
    </div>
    <div class="left">
        <?=@$assign_form?>
        <?=@$reply_form?>
        <?=@$form_status?>
        <div>   
            <?if(isset($taskflows)){
                    foreach($taskflows as $status_task){
                        if($status_task->type == 'task'){?>

                            <div style='clear:both'>
                                <div style='width:25px; float:left; margin-top:5px'>
                                    <img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="<?=ucfirst($status_task->userInfo->nome);?>" /> 
                                </div>
                                <div class='hist_task round' style='float:left;'>
                                <div class='line_bottom'>
                                    <b><?=$status_task->topic;?></b> <span class="status round <?=$status_task->getStatus($status_task->id)->status->class?>"><?=$status_task->getStatus($status_task->id)->status->status?></span><br/>
                                    criada por: <?=$status_task->userInfo->nome?> em <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?><br/>
                                    retorno: <?=Utils_Helper::data($status_task->crono_date, 'd/m/Y')?>
                                </div>
                                <?if(!empty($status_task->description)){ ?>
                                    <span class="wordwrap description"><?=$status_task->description;?></span>
                                <?}?>
                                <div class="options">
                                    <? if($status_task->getStatus($status_task->id)->status_id == '5'){?>
                                        <form action="<?=URL::base();?>admin/tasks/start/<?=$status_task->id?>" method="post" class="form">
                                            <input type="hidden" name='topic' value="<?=$status_task->topic?>" />
                                            <input type="hidden" name='status_id' value="6" />
                                            <input type="hidden" name='crono_date' value="<?=$status_task->crono_date?>" />
                                            <input type="hidden" name='task_id' value="<?=$status_task->id?>" />
                                            <input type="hidden" name='object_id' value="<?=$status_task->object_id?>" />
                                            <input type="submit" class="bar_button round" value="iniciar tarefa">
                                        </form>
                                    <?}?>
                                </div>  
                                <a class="down_button fade" data-show="replies_<?=$status_task->id;?>"><img src="<?=URL::base();?>public/image/admin/down.png" title="detalhar tarefa" /></a>                          
                            </div>
                            <div class="hide" id="replies_<?=$status_task->id;?>">
                            <?foreach ($status_task->getReplies($status_task->id) as $taskReply) {?>
                                <div style='clear:both'>
                                    <div style='width:25px; float:left;'>
                                        <img class='round_imgList' src='<?=URL::base();?><?=$taskReply->userInfo->foto?>' height="25"  title="<?=ucfirst($taskReply->userInfo->nome);?>" /> 
                                    </div>
                                    <div class='hist_task_reply round' style='float:left;'>
                                        <div class='line_bottom'>
                                            <?=$taskReply->getStatus($taskReply->id)->status->status?> em <?=Utils_Helper::data($taskReply->created_at, 'd/m/Y - H:i')?><br/>
                                        </div>
                                        <?if(!empty($taskReply->description)){ ?>
                                            <span class="wordwrap description"><?=$taskReply->description;?></span>
                                        <?}?>
                                        <div class="options">
                                            <? if($taskReply->getStatus($status_task->id)->status_id == '6' && $taskReply->getStatus($status_task->id)->userInfo_id == $user->id){?>
                                                <form action="<?=URL::base();?>admin/tasks/end/<?=$status_task->id?>" method="post" class="form">
                                                    <input type="hidden" name='topic' value="<?=$status_task->topic?>" />
                                                    <input type="hidden" name='status_id' value="7" />
                                                    <input type="hidden" name='crono_date' value="<?=$status_task->crono_date?>" />
                                                    <input type="hidden" name='task_id' value="<?=$status_task->id?>" />
                                                    <input type="hidden" name='object_id' value="<?=$status_task->object_id?>" />
                                                    <dt> <label for="description">observações</label> </dt>
                                                    <dd>
                                                        <textarea class="text round" name="description" id="description" style="width:500px; height:50px;"></textarea>
                                                        <span class='error'><?=Arr::get($errors, 'description');?></span>
                                                    </dd>
                                                    <input type="submit" value="concluir" class="round" />
                                                </form>
                                            <?}?>
                                        </div>  
                                    </div>
                                </div>            

                            <?}?>
                            </div>
                        <?}elseif ($status_task->type == 'status') {?>
                            <div style='clear:both' >
                                <div style='width:25px; float:left; margin-top:5px'>
                                    <img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="<?=ucfirst($status_task->userInfo->nome);?>" /> 
                                </div>
                                <div class='hist_task round step' style='float:left;'>
                                    <div class='line_bottom'>
                                        <b><?=$status_task->status->status;?></b> - <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?><br/>
                                        
                                        retorno: <?=Utils_Helper::data($status_task->crono_date, 'd/m/Y')?>
                                    </div>

                                    <?if(!empty($status_task->description)){ ?>
                                        <span class="wordwrap description"><?=$status_task->description;?></span>
                                    <?}?>
                                 </div>                        
                            </div>
                        <?}                
                    }   
                }
            ?>
        </div>
    </div>  
    
</div>
