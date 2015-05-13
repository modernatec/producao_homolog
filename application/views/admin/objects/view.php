<div class="clear">
    <div class="bar">
    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/objects/edit/<?=$obj->id?>" rel="load-content" data-panel="#direita" class="bar_button round">editar OED</a>       
    <?}?>
    <?if($current_auth == "coordenador" || $current_auth == "admin"){?>
        <!--a href="<?=URL::base();?>admin/custos/view/<?=$obj->id?>" class="bar_button round">custos</a-->       
    <?}?>

    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/objects/update/?object_id=<?=$obj->id?>" class="popup bar_button round">alterar status</a>                           
    <?}?>
        
    </div>  
    <div class="boxwired round" >
        <a class="collapse right" data-show="replies" title="abrir/fechar infos"><span class="collapse_ico">contrair</span></a>
        <b><span class="wordwrap"><?=@$obj->title;?></span></b><br/>
        <span class="wordwrap"><?=@$obj->taxonomia;?></span>
        <hr style="margin:8px 0;" />
        <span class="list_faixa light_blue round left"><?=@$obj->collection->name?></span>
        <span class="list_faixa red round"><?=Utils_Helper::data(@$obj->collection->fechamento,'d/m/Y')?></span>
        <?if($obj->reaproveitamento == 0){ 
            $origem = "novo";
        }elseif($obj->reaproveitamento == 1){
            $origem = "reap.";
        }else{
            $origem = "reap. integral";
        }?>
        <div class="clear">
            <span class="list_faixa light_blue round left"><?=$origem?></span>
            <span class="list_faixa light_blue round left"><?=@$obj->typeobject->name;?></span>
            <span class="list_faixa cyan round"><?=@$obj->supplier->empresa?></span>
            <p><b>início:</b> <?=Utils_Helper::dataGdocs(@$obj->gdoc->envio_produtora,'d/m/Y')?></p>
            <p><b>fechamento:</b> <?=Utils_Helper::dataGdocs(@$obj->gdoc->fechamento,'d/m/Y')?></p>
        </div>
    </div>
<?

?>
<div class="scrollable_content clear">             
    <?if(isset($objects_status)){
            $count = 0;
            foreach($objects_status as $object){
                ?>                          
                    <div style='clear:both' >
                        <div class='hist round step step_<?=$object->status->class?>' >
                            <div style='width:30px; height:60px; float:left; margin:0 5px 0 0'>
                                <div class="left"><?=Utils_Helper::getUserImage($object->userInfo)?></div>
                                <!--img class='round_imgList' src='<?=URL::base();?><?=$object->userInfo->foto?>' height="25"  title="<?=ucfirst($object->userInfo->nome);?>" /--> 
                            </div>
                            <?if($current_auth != "assistente"){?>
                                <div class="right">
                                    <a class="excluir" href="<?=URL::base()?>admin/objects/deleteStatus/<?=$object->id?>" title="excluir" data-panel="#direita">Excluir</a>
                                </div>
                            <?}?>

                            <div class="right">
                                <a href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?status_id=<?=$object->id?>" title="criar anotações" class="popup note">anotacao</a>
                            </div> 
                            <? if($count == 0){
                                    if($current_auth != "assistente"){?>
                                        <div class="right">
                                            <a href="<?=URL::base();?>admin/tasks/update/?object_id=<?=@$obj->id?>&object_status_id=<?=$object->id?>" title="criar tarefa" class="popup task_icon">nova tarefa</a> &bull;
                                        </div>
                            <?      
                                    }
                                    //$count++;
                                }
                            ?>
                                                       
                            <div class='line_bottom'>
                                <?if($current_auth != "assistente"){?>
                                    <a href="<?=URL::base();?>admin/objects/update/<?=$object->id?>" class="popup edit black">
                                <?}?>
                                <span class="list_faixa <?=$object->status->class?> round"><?=$object->status->status;?> <?=!empty($object->prova) ? '('.$object->prova.')' : ""?></span></a>

                                
                                <p>iniciado: <?=Utils_Helper::getday($object->created_at)?> &bull; <?=Utils_Helper::data($object->created_at, 'd/m/Y - H:i')?></p>
                                <p>retorno: <?=Utils_Helper::getday($object->crono_date)?> &bull; <?=Utils_Helper::data($object->crono_date, 'd/m/Y')?></p>
                            </div>

                            
                            <?if(!empty($object->description)){ ?>
                                <span class="wordwrap description"><?=$object->description;?></span>
                            <?}?>

                            <? if($count == 0){
                                    if($current_auth != "assistente"){?>
                                        <div class="replies replies_gdocs" style="margin-top:5px;">
                                            <table class="left">
                                                <thead>
                                                    <th>&nbsp;</th>
                                                    <th>envio</th>
                                                    <th>retorno RT</th>
                                                    <th>consolidação</th>
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
                                            <div class="observacoes_gdocs table_info round scrollable_content wordwrap left" data-bottom="false"><pre><?=@$obj->gdoc->observacoes;?></pre><p>obs: informação atualizada em: <?=Utils_Helper::data(@$obj->gdoc->created_at,'d/m/Y - H:i')?></p></div>
                                        </div>

                            <?      
                                    }
                                    $count++;
                                }

                            foreach ($object->anotacoes->order_by('id', 'desc')->find_all() as $anotacao) {?> 
                                <div style='clear:both'>
                                    <div class="hist anotacoes round"> 
                                        <div class="left">
                                            <?=Utils_Helper::getUserImage($anotacao->userInfo)?>
                                        </div>
                                        <div class="left">
                                            <a href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?anotacao_id=<?=$anotacao->id?>&status_id=<?=$object->id?>" title="anotações" class="popup edit black"><b>anotação</b></a><br/>  
                                            em: <?=Utils_Helper::data($anotacao->created_at, 'd/m/Y - H:i')?>
                                        </div>
                                        <?if($current_auth != "assistente"){?>                                        
                                        <div class="right">
                                            <a class="excluir" href="<?=URL::base()?>admin/anotacoes/delete/<?=$anotacao->id?>" data-panel="#direita" title="Excluir">Excluir</a>
                                        </div>
                                        <?}?>
                                        <div class="clear">
                                            <hr style="margin:8px 0;" />
                                            <pre><span class="wordwrap"><?=$anotacao->anotacao?></span></pre>
                                        </div>
                                    </div> 
                                </div>

                            <?}    

                            foreach ($object->tasks->order_by('id', 'desc')->find_all() as $task) {?> 
                                
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
                                                        <span class="round list_faixa tag" style="background:#<?=$task->tag->class?>"><?=$task->tag->tag?></span></a> 
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


                                                    <?
                                                    if($task->reply->id != '') {?>
                                                        <div class='line_bottom'>
                                                            <? if($current_auth != "assistente"){?>
                                                                <a href="<?=URL::base();?>admin/tasks/updateReply/<?=$task->reply->id?>" class="popup edit black">
                                                            <?}?>
                                                            <? if($task->reply->finished != ""){?>
                                                                entregue: </a> &bull; <?=Utils_Helper::getday($task->reply->finished)?> - <?=Utils_Helper::data($task->reply->finished, 'd/m/Y - H:i')?><br/>
                                                            <?}elseif($task->status_id == '6'){?>
                                                                iniciada: </a> &bull; <?=Utils_Helper::getday($task->reply->created_at)?> - <?=Utils_Helper::data($task->reply->created_at, 'd/m/Y - H:i')?><br/>
                                                            <?}?>
                                                        </div>
                                                        <?if(!empty($task->reply->description)){ ?>
                                                            <span class="wordwrap description"><?=$task->reply->description;?></span>
                                                        <?}?>
                                                        <div class="options" >
                                                            <? if($task->status_id == '6' && $task->to->id == $user->id){?>
                                                                <div style="min-height:20px;">
                                                                    <a href="<?=URL::base();?>admin/tasks/endtask/<?=$task->id?>" class="popup bar_button green round">entregar</a>
                                                                </div>
                                                            <?}?>
                                                        </div>
                                                    <?}?>
                                                    </div> 
                                                </div>
                                            </div>  
                                        </div>                                    
                                    </div>
                            <?}?>
                        </div> 
                        
                    </div>
                <?               
            }   
        }
    ?>
</div> 
</div>
