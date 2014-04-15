<div class="content">
    <div class="bar">
        <a href="<?=URL::base();?><?=($current_auth != "assistente") ? 'admin/objects' : 'admin/tasks' ?>" class="bar_button round">voltar</a>        <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/objects/edit/<?=$obj->id?>" class="bar_button round">editar OED</a>
        
        <a href="#" data-show="form_status" class="bar_button round show">alterar status</a>
        <a href="#" data-show="form_assign" class="bar_button round show">criar tarefa</a>
        
        <?}?>
    </div>
    
    <div class="left" style="width:280px;">

        <div class="box round">
            <b>título:</b> <?=@$obj->title;?><br/>
            <b>taxonomia:</b> <?=@$obj->taxonomia;?><br/>
            <hr style="margin:8px 0;" />
            <b>produtora:</b> <?=@$obj->supplier->empresa?><br/>
            <b>contato:</b> <?=@$obj->supplier->name?><br/>
            <b>email:</b> <?=@$obj->supplier->email?><br/>
            <b>tels:</b> <?=@$obj->supplier->telefone?><br/>
            <hr style="margin:8px 0;" />
            <b>tipo:</b> <?=@$obj->typeobject->name;?><br/>
            <b>classificação:</b> <?=($obj->reaproveitamento == 0) ? "Novo" : "Reaproveitamento" ?><br/>
            <b>fechamento:</b> <?=Utils_Helper::data($obj->crono_date,'d/m/Y')?><br/>
            <br/>
            <b>obs:</b> <?=@$obj->obs?><br/>
        </div>
        <div class="box round anotacoes">
            Anotações
            <hr style="margin:8px 0;" />
            <form action="<?=URL::base();?>admin/objects/anotacoes/" method="post" class="form">
                <dd>
                    <input type="hidden" name='object_id' value="<?=@$obj->id;?>" />
                    <textarea class="text round" name="anotacoes" id="anotacoes" style="width:240px; height:50px;"><?=@$obj->anotacoes;?></textarea>
                    <span class='error'><?=Arr::get($errors, 'anotacoes');?></span>
                </dd>
                <input type="submit" value="salvar" class="round" />
            </form>
        </div>
    </div>
    <div class="left">
        <?=@$assign_form?>
        <?=@$reply_form?>
        <?=@$form_status?>
        <div> 
            <div style="padding:8px;">  
                <a href="#" class="collapse bar_button round right" data-show="replies"><span>contrair</span></a>
            </div>
            <?if(isset($taskflows)){
                    foreach($taskflows as $status_task){
                        if($status_task->type == 'tasks'){?>

                            <div style='clear:both'>
                                <div style='width:25px; float:left; margin-top:5px'>
                                    <img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="<?=ucfirst($status_task->userInfo->nome);?>" /> 
                                </div>
                                <div class='hist_task round' style='float:left;'>
                                    <div class='line_bottom'>
                                        <?if(($current_auth != "assistente" && $status_task->userInfo_id == $user->id) || $current_auth == "coordenador" || $current_auth == "admin"){?>
                                            <a href="<?=URL::base();?>admin/tasks/update/<?=$status_task->id?>" class="popup edit black">
                                        <?}?>
                                        <b><?=$status_task->topic;?></b></a> <span class="status round <?=$status_task->getStatus($status_task->id)->status->class?>"><?=$status_task->getStatus($status_task->id)->status->status?></span><br/>
                                        criada por: <?=$status_task->userInfo->nome?> em <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?><br/>
                                        retorno: <?=Utils_Helper::data($status_task->crono_date, 'd/m/Y')?>
                                        <? if($status_task->task_to != "0"){
                                            $nome = explode(" ", $status_task->to->nome);
                                            echo "<br/><br/><span class='round label_name' >".ucfirst($nome[0])."</span>";
                                        }?>
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
                                                <input type="hidden" name='task_to' value="<?=$status_task->task_to?>" />
                                                <input type="hidden" name='object_id' value="<?=$status_task->object_id?>" />
                                                <input type="hidden" name='userinfo_id' value="<?=$status_task->userInfo_id?>" />
                                                <input type="submit" class="bar_button round" value="iniciar tarefa">
                                            </form>
                                        <?}?>

                                    </div>  
                                    <a class="down_button fade" data-show="replies_<?=$status_task->id;?>"><img src="<?=URL::base();?>public/image/admin/down.png" title="detalhar tarefa" /></a>                          
                                </div>
                                <div class="replies" id="replies_<?=$status_task->id;?>">
                                <?foreach ($status_task->getReplies($status_task->id) as $taskReply) {?>
                                    <div style='clear:both'>
                                        <div style='width:25px; float:left;'>
                                            <img class='round_imgList' src='<?=URL::base();?><?=$taskReply->to->foto?>' height="25"  title="<?=ucfirst($taskReply->to->nome);?>" /> 
                                        </div>
                                        <div class='hist_task_reply round' style='float:left;'>
                                            <div class='line_bottom'>
                                                <? if($current_auth == "coordenador" || $current_auth == "admin" || $current_auth == "assistente 2"){?>
                                                    <a href="<?=URL::base();?>admin/tasks/updateReply/<?=$taskReply->id?>" class="popup edit black">
                                                <?}?>
                                                <?=$taskReply->getStatus($taskReply->id)->status->status?></a> em <?=Utils_Helper::data($taskReply->created_at, 'd/m/Y - H:i')?><br/>
                                            </div>
                                            <?if(!empty($taskReply->description)){ ?>
                                                <span class="wordwrap description"><?=$taskReply->description;?></span>
                                            <?}?>
                                            <div class="options">
                                                <? if($taskReply->getStatus($status_task->id)->status_id == '6' && $taskReply->getStatus($status_task->id)->task_to == $user->id){?>
                                                    <form id="formEndTask" name="formEndTask" action="<?=URL::base();?>admin/tasks/end/<?=$status_task->id?>" method="post" class="form">
                                                        <input type="hidden" name='topic' value="<?=$status_task->topic?>" />
                                                        <input type="hidden" name='status_id' value="7" />
                                                        <input type="hidden" name='crono_date' value="<?=$status_task->crono_date?>" />
                                                        <input type="hidden" name='task_id' value="<?=$status_task->id?>" />
                                                        <input type="hidden" name='object_id' value="<?=$status_task->object_id?>" />
                                                        <input type="hidden" name='userinfo_id' value="<?=$status_task->userInfo_id?>" />
                                                        <input type="hidden" name='task_to' value="<?=$status_task->task_to?>" />
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
                                        <?if(($current_auth != "assistente" && $status_task->userInfo_id == $user->id) || $current_auth == "coordenador" || $current_auth == "admin"){?>
                                            <a href="<?=URL::base();?>admin/objects/update/<?=$status_task->id?>" class="popup edit black">
                                        <?}?>
                                        <b><?=$status_task->status->status;?> <?=!empty($status_task->prova) ? '('.$status_task->prova.')' : ""?></b></a> - <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?> <br/>
                                        
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
