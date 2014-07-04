<div class="content">
    <div style="position:fixed">
        <div class="bar">
            <a href="<?=URL::base();?><?=($current_auth != "assistente") ? 'admin/objects' : 'admin/tasks' ?>" class="bar_button round">voltar</a>        
            <?if($current_auth != "assistente"){?>
                <a href="<?=URL::base();?>admin/objects/edit/<?=$obj->id?>" class="bar_button round">editar OED</a>       
            <?}?>
            <?if($current_auth == "coordenador" || $current_auth == "admin"){?>
                <a href="<?=URL::base();?>admin/custos/view/<?=$obj->id?>" class="bar_button round">custos</a>       
            <?}?>
        </div>    
        <div class="left" style="width:280px;">

            <div class="box round">
                <b>título:</b> <span class="wordwrap"><?=@$obj->title;?></span><br/>
                <b>taxonomia:</b> <span class="wordwrap"><?=@$obj->taxonomia;?></span><br/>
                <b>tipo:</b> <?=@$obj->typeobject->name;?><br/>
                <b>classificação:</b> <?=($obj->reaproveitamento == 0) ? "Novo" : "Reaproveitamento" ?><br/>
                <b>fechamento:</b> <?=Utils_Helper::data($obj->crono_date,'d/m/Y')?><br/>
                <hr style="margin:8px 0;" />
                <b>produtora:</b> <?=@$obj->supplier->empresa?><br/>
                <b>contato:</b> <?=@$obj->supplier->contato->nome?><br/>
                <b>email:</b> <?=@$obj->supplier->contato->email?><br/>
                <b>tels:</b> <?=@$obj->supplier->contato->telefone?><br/><br/>

                <b>estúdio:</b> <?=@$obj->audiosupplier->empresa?><br/>
                <b>locutor(a):</b> <?=@$obj->speaker?><br/>
                
                <hr style="margin:8px 0;" />
                
                <b>obs:</b> <span class="wordwrap"><?=@$obj->obs?></span><br/>
            </div>
        </div>
    </div>
    <div class="left" style="margin-left: 290px;">
        <div style="padding-bottom:4px;">              
            <a class="collapse bar_button round right" data-show="replies"><span>contrair</span></a>
                <a data-show="form_anotacoes" class="bar_button round show right">criar anotação</a>
            <?if($current_auth != "assistente"){?>
                <a data-show="form_assign" class="bar_button round show right">criar tarefa</a> 
                <a data-show="form_status" class="bar_button round show right">alterar status</a> 
                              
            <?}?>
        </div>
        <div class="clear" style="padding:4px 0;">
            
            <?=@$form_status?>
        </div>
        <div>             
            <?if(isset($taskflows)){
            		$count = 0;
                    foreach($taskflows as $status_task){
                        if($status_task->type == 'tasks'){?>

                            <div style='clear:both'>
                                <div style='width:25px; float:left; margin-top:5px'>
                                    <img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="<?=ucfirst($status_task->userInfo->nome);?>" /> 
                                </div>
                                <div class='hist task round' style='float:left;'>
                                    <div class='line_bottom'>
                                        <?if(($current_auth != "assistente" && $status_task->userInfo_id == $user->id) || $current_auth == "coordenador" || $current_auth == "admin"){?>
                                            <a href="<?=URL::base();?>admin/tasks/update/<?=$status_task->id?>" class="popup edit black">
                                        <?}?>
                                        <b><?=$status_task->topic;?></b></a> <span class="status round <?=$status_task->getStatus($status_task->id)->status->class?>"><?=$status_task->getStatus($status_task->id)->status->status?></span><br/>
                                        por: <?=$status_task->userInfo->nome?> - <label><?=Utils_Helper::getday($status_task->created_at)?> &bull; <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?></label> 
                                        <br/>
                                        retorno: <label><?=Utils_Helper::getday($status_task->crono_date)?> &bull; <?=Utils_Helper::data($status_task->crono_date, 'd/m/Y')?></label>
                                        <? if($status_task->task_to != "0"){?>
                                            
                                            <div class="round_imgDetail <?=$status_task->to->team->color?>" style="margin-top:5px;">
                                                <img class='round_imgList' src='<?=URL::base();?><?=($status_task->to->foto)?($status_task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($status_task->to->nome);?>" />
                                                <span><?$nome = explode(" ", $status_task->to->nome); echo $nome[0];?></span>
                                            </div>
                                        <?}?>
                                    </div>
                                    <?if(!empty($status_task->description)){ ?>
                                        <span class="wordwrap description replies replies_<?=$status_task->id;?>"><?=$status_task->description;?></span>
                                    <?}?>
                                    <div class="options">
                                        <? if($status_task->getStatus($status_task->id)->status_id == '5'){?>
                                            <form action="<?=URL::base();?>admin/tasks/start/<?=$status_task->id?>" method="post" class="form">
                                                <input type="hidden" name='topic' value="<?=$status_task->topic?>" />
                                                <input type="hidden" name='status_id' value="6" />
                                                <input type="hidden" name='crono_date' value="<?=$status_task->crono_date?>" />
                                                <!--input type="hidden" name='task_id' value="<?=$status_task->id?>" /-->
                                                <input type="hidden" name='task_to' value="<?=$status_task->task_to?>" />
                                                <input type="hidden" name='object_id' value="<?=$status_task->object_id?>" />
                                                <input type="hidden" name='userinfo_id' value="<?=$status_task->userInfo_id?>" />
                                                <input type="submit" class="bar_button round" value="iniciar tarefa">
                                            </form>
                                        <?}else{?>
                                            <a class="down_button fade" data-show="replies_<?=$status_task->id;?>"><img src="<?=URL::base();?>public/image/admin/down.png" title="detalhar tarefa" /></a>                          
                                        <?}?>
                                    </div>  
                                </div>
                                <div class="replies replies_<?=$status_task->id;?>">
                                    <?foreach ($status_task->getReplies($status_task->id) as $taskReply) {?>
                                    <div style='clear:both'>
                                        <div style='width:25px; float:left;'>
                                            <img class='round_imgList' src='<?=URL::base();?><?=$taskReply->to->foto?>' height="25"  title="<?=ucfirst($taskReply->to->nome);?>" /> 
                                        </div>
                                        <div class='hist_reply round' style='float:left;'>
                                            <div class='line_bottom'>
                                                <? if($current_auth == "coordenador" || $current_auth == "admin" || $current_auth == "assistente 2"){?>
                                                    <a href="<?=URL::base();?>admin/tasks/updateReply/<?=$taskReply->id?>" class="popup edit black">
                                                <?}?>
                                                <?=$taskReply->status->status?></a> &bull; <?=Utils_Helper::getday($taskReply->created_at)?> - <?=Utils_Helper::data($taskReply->created_at, 'd/m/Y - H:i')?><br/>
                                            </div>
                                            <?if(!empty($taskReply->description)){ ?>
                                                <span class="wordwrap description"><?=$taskReply->description;?></span>
                                            <?}?>
                                            <div class="options">
                                                <? if($taskReply->status_id == '6' && $taskReply->userInfo_id == $user->id){?>
                                                    <form id="formEndTask" name="formEndTask" action="<?=URL::base();?>admin/tasks/end/<?=$status_task->id?>" method="post" class="form">
                                                        <input type="hidden" name='topic' value="<?=$status_task->topic?>" />
                                                        <input type="hidden" name='status_id' value="7" />
                                                        <input type="hidden" name='crono_date' value="<?=$status_task->crono_date?>" />
                                                        <!--input type="hidden" name='task_id' value="<?=$status_task->id?>" /-->
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
                                
                            </div>
                        <?}elseif ($status_task->type == 'status') {?>                        	
                            <div style='clear:both' >                            	
                                <div style='width:25px; float:left; margin-top:5px'>
                                    <img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="<?=ucfirst($status_task->userInfo->nome);?>" /> 
                                </div>
                                <div class='hist round step' style='float:left;'>
                                	<?if($current_auth != "assistente" || $current_auth == "coordenador" || $current_auth == "admin"){?>
                                        <div class="right">
				                        	<a class="excluir" href="<?=URL::base()?>admin/objects/deleteStatus/<?=$status_task->id?>" title="excluir">Excluir</a>
				                        </div>
                                    <?}?>
	                                
                                    <div class='line_bottom'>
                                        id: <?=$status_task->id;?>
                                        <?if(($current_auth != "assistente" && $status_task->userInfo_id == $user->id) || $current_auth == "coordenador" || $current_auth == "admin"){?>
                                            <a href="<?=URL::base();?>admin/objects/update/<?=$status_task->id?>" class="popup edit black">
                                        <?}?>
                                        <b><?=$status_task->status->status;?> <?=!empty($status_task->prova) ? '('.$status_task->prova.')' : ""?></b></a> - <?=Utils_Helper::getday($status_task->created_at)?> &bull; <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?> <br/>
                                        
                                        retorno: <?=Utils_Helper::getday($status_task->crono_date)?> &bull; <?=Utils_Helper::data($status_task->crono_date, 'd/m/Y')?>
                                    </div>
                                    <? if($count == 0){
	                                    echo @$assign_form;
                                        echo @$anotacoes_form;
	                                    $count++;
	                                }?>
                                    <?if(!empty($status_task->description)){ ?>
                                        <span class="wordwrap description"><?=$status_task->description;?></span>
                                    <?}?>


                                    <?foreach ($status_task->getHistory($status_task->id) as $task) {?>
                                        <? if($task->type == 'anotacoes'){?>
                                            <div style='clear:both'>
                                                <div class="hist anotacoes round"> 
                                                    <div class="left">
                                                        <a href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?anotacao_id=<?=$task->id?>&status_id=<?=$status_task->id?>" title="anotações" class="popup edit black"><b>anotação</b></a><br/>  
                                                        por: <?=$task->userInfo->nome?> - <?=Utils_Helper::getday($task->created_at)?> &bull; <?=Utils_Helper::data($task->created_at, 'd/m/Y - H:i')?>
                                                    </div>
                                                    <?if($task->userInfo_id == $user->id || $current_auth != "assistente"){?>                                        
                                                    <div class="right">
                                                        <a class="excluir" href="<?=URL::base()?>admin/anotacoes/delete/<?=$task->id?>" title="Excluir">Excluir</a>
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
                                                	<?if($current_auth != "assistente" || $current_auth == "coordenador" || $current_auth == "admin"){?>
    			                                        <div class="right">
    							                        	<a class="excluir" href="<?=URL::base()?>admin/tasks/delete/<?=$task->id?>" title="excluir">Excluir</a>
    							                        </div>
    			                                    <?}?>
                                                    <div class='line_bottom'>
                                                        <?if(($current_auth != "assistente" && $task->userInfo_id == $user->id) || $current_auth == "coordenador" || $current_auth == "admin"){?>
                                                            <a href="<?=URL::base();?>admin/tasks/update/<?=$task->id?>" class="popup edit black">
                                                        <?}?>
                                                        <b><?=$task->topic;?></b></a> <span class="status round <?=$task->status->class?>"><?=$task->status->status?></span><br/>
                                                        por: <?=$task->userInfo->nome?> - <label><?=Utils_Helper::getday($task->created_at)?> &bull; <?=Utils_Helper::data($task->created_at, 'd/m/Y - H:i')?></label> 
                                                        <br/>
                                                        retorno: <label><?=Utils_Helper::getday($task->crono_date)?> &bull; <?=Utils_Helper::data($task->crono_date, 'd/m/Y')?></label>
                                                        <? if($task->task_to != "0"){?>
                                                            
                                                            <div class="round_imgDetail <?=$task->to->team->color?>" style="margin-top:5px;">
                                                                <img class='round_imgList' src='<?=URL::base();?><?=($task->to->foto)?($task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->to->nome);?>" />
                                                                <span><?$nome = explode(" ", $task->to->nome); echo $nome[0];?></span>
                                                            </div>
                                                        <?}?>
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
                                                        <form action="<?=URL::base();?>admin/taskstatus/start" method="post" class="form">
                                                            <input type="hidden" name='task_id' value="<?=$task->id?>" />
                                                            <input type="hidden" name='object_id' value="<?=$task->object_id?>" />
                                                            <input type="submit" class="bar_button round" value="iniciar">
                                                        </form>
                                                    <?}?>
                                                    <?foreach ($task->getReplies($task->id) as $taskReply) {?>
                                                    <div style='clear:both'>
                                                        <div class='hist_reply round' style='float:left;'>
                                                            <div class='line_bottom'>
                                                                <? if($current_auth == "coordenador" || $current_auth == "admin" || $current_auth == "assistente 2"){?>
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
                                                                        <dd>
                                                                            <textarea placeholder="observações" class="text round" name="description" id="description" style="width:500px; height:50px;"></textarea>
                                                                            <span class='error'><?=Arr::get($errors, 'description');?></span>
                                                                        </dd>
                                                                        <input type="submit" value="entregar" class="round" />
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
                        <?}                
                    }   
                }
            ?>
        </div>
    </div>  
    
</div>
