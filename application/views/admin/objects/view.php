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
        <span class="list_faixa blue round"><?=($obj->reaproveitamento == 0) ? "Novo" : "Reaproveitamento" ?>
        &bullet; <?=@$obj->supplier->empresa?></span> - <?=@$obj->typeobject->name;?>
        <br/>
        <b>início:</b> <?=Utils_Helper::dataGdocs(@$obj->gdoc->envio_produtora,'d/m/Y')?><br/>
        <b>fechamento:</b> <?=Utils_Helper::dataGdocs(@$obj->gdoc->fechamento,'d/m/Y')?><br/>
        <b>fechamento da coleção:</b> <?=Utils_Helper::data(@$obj->collection->fechamento,'d/m/Y')?><br/>        
    </div>
<?

?>
<div class="scrollable_content clear">             
    <?if(isset($taskflows)){
            $count = 0;
            foreach($taskflows as $status_task){
                ?>                          
                    <div style='clear:both' >
                        <div class='hist round step step_<?=$status_task->status->team->color?>' >
                            <div style='width:30px; height:60px; float:left; margin:0 5px 0 0'>
                                <div class="left"><?=Utils_Helper::getUserImage($status_task->userInfo)?></div>
                                <!--img class='round_imgList' src='<?=URL::base();?><?=$status_task->userInfo->foto?>' height="25"  title="<?=ucfirst($status_task->userInfo->nome);?>" /--> 
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
                                    //$count++;
                                }
                            ?>
                                                       
                            <div class='line_bottom'>
                                <?if($current_auth != "assistente"){?>
                                    <a href="<?=URL::base();?>admin/objects/update/<?=$status_task->id?>" class="popup edit black">
                                <?}?>
                                <span class="list_faixa <?=$status_task->status->team->color?> round"><?=$status_task->status->status;?> <?=!empty($status_task->prova) ? '('.$status_task->prova.')' : ""?></span></a>

                                
                                <p>iniciado: <?=Utils_Helper::getday($status_task->created_at)?> &bull; <?=Utils_Helper::data($status_task->created_at, 'd/m/Y - H:i')?></p>
                                <p>retorno: <?=Utils_Helper::getday($status_task->crono_date)?> &bull; <?=Utils_Helper::data($status_task->crono_date, 'd/m/Y')?></p>
                            </div>

                            
                            <?if(!empty($status_task->description)){ ?>
                                <span class="wordwrap description"><?=$status_task->description;?></span>
                            <?}?>

                            <? if($count == 0){
                                    if($current_auth != "assistente"){?>
                                        <a class="down_button fade" data-show="replies_gdocs"><img src="<?=URL::base();?>public/image/admin/down.png" title="abrir tabela" /></a>
                                        <div class="table_info replies replies_gdocs" style="margin-top:5px;">
                                            <div class="left">
                                                <table>
                                                    <thead>
                                                        <th><b>gdocs</b></th>
                                                        <th><b>envio</b></th>
                                                        <th><b>retorno RT</b></th>
                                                        <th><b>consolidação</b></th>
                                                    </thead>
                                                    <tr>
                                                        <td><span class="text_blue">prova 1</span></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->p1,'d/m/Y')?></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->rt1,'d/m/Y')?></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->r1,'d/m/Y')?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="text_blue">prova 2</span></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->p2,'d/m/Y')?></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->rt2,'d/m/Y')?></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->r2,'d/m/Y')?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="text_blue">prova 3</span></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->p3,'d/m/Y')?></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->rt3,'d/m/Y')?></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->r3,'d/m/Y')?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="text_blue">prova 4</span></td>
                                                        <td><?=Utils_Helper::dataGdocs(@$obj->gdoc->p4,'d/m/Y')?></td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                </table>
                                                <p>obs: informação atualizada em: <?=Utils_Helper::data(@$obj->gdoc->created_at,'d/m/Y - H:i')?></p>
                                            </div>
                                            <div class="observacoes_gdocs wordwrap left"><b>observações:</b><br/><?=@$obj->gdoc->observacoes;?>
                                            </div>
                                        </div>

                            <?      
                                    }
                                    $count++;
                                }
                            ?>


                            <?foreach ($status_task->getHistory($status_task->id) as $task) {?> 
                                <? if($task->type == 'anotacoes'){?>
                                    <div style='clear:both'>
                                        <div class="hist anotacoes round"> 
                                            <div class="left">
                                                <?=Utils_Helper::getUserImage($task->userInfo)?>
                                                <!--img class='round_imgList<?=$task->userInfo->team->color?>' src='<?=Utils_Helper::getUserImage($task->userInfo)?>' height="20" style='float:left' alt="<?=ucfirst($task->userInfo->nome);?>" /-->
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
                                        <div class='hist'>
                                            <div class="left"><?=Utils_Helper::getUserImage($task->userInfo)?></div>
                                            <!--img class='round_imgList<?=$task->userInfo->team->color?> left' src='<?=Utils_Helper::getUserImage($task->userInfo)?>' height="20" alt="<?=ucfirst($task->userInfo->nome);?>" /-->
                                            <div class="task round">
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
                                                        <div class="left"><?=Utils_Helper::getUserImage($task->to)?></div>
                                                        <!--img class='round_imgList<?=$task->to->team->color?>' src='<?=Utils_Helper::getUserImage($task->to)?>' height="20" alt="<?=ucfirst($task->to->nome);?>" /-->
                                                    <?}?>
                                                    <span class="status round <?=$task->status->class?>"><?=$task->status->status?></span>
                                                    <div class="clear" style="padding-top:5px;">
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
                                                        <!--a class="down_button fade" data-show="replies_<?=$task->id;?>"><img src="<?=URL::base();?>public/image/admin/down.png" title="detalhar tarefa" /></a-->                          
                                                    <?}?>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="replies replies_<?=$task->id;?>">

                                             
                                            <div style='clear:both'>
                                                <div class='hist'>
                                                    <div class="right"><?=Utils_Helper::getUserImage($task->to)?></div>
                                                    <!--img class='round_imgList<?=$task->to->team->color?> right' src='<?=Utils_Helper::getUserImage($task->to)?>' height="20" alt="<?=ucfirst($task->to->nome);?>" /-->
                                                    <div class="task_reply round"> 
                                                        <? if($task->status_id == '5'){?>
                                                            <form action="<?=URL::base();?>admin/taskstatus/start" id="startTask" method="post" class="form">
                                                                <input type="hidden" name='task_id' value="<?=$task->id?>" />
                                                                <input type="hidden" name='object_id' value="<?=$task->object_id?>" />
                                                                <?  
                                                                    if($task->tag_id == '7' && $current_auth == "assistente"){
                                                                        $start = false;
                                                                    }else{
                                                                        $start = true;
                                                                    }

                                                                    if($start){
                                                                ?>
                                                                        <input type="submit" class="bar_button round" value="iniciar">
                                                                <?}?>

                                                            </form>
                                                        <?}?>


                                                    <?foreach ($task->getReplies($task->id) as $taskReply) {?>
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
                                                    <?}?>
                                                    </div> 
                                                </div>
                                            </div>  
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
