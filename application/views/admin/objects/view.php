<div class="clear">
    <div class="bar">
    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/objects/edit/<?=$obj->id?>" rel="load-content" data-panel="#direita" class="bar_button round">editar OED</a>       
    <?}?>
    <?if($current_auth == "coordenador" || $current_auth == "admin"){?>
        <!--a href="<?=URL::base();?>admin/custos/view/<?=$obj->id?>" class="bar_button round">custos</a-->       
    <?}?>

    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/objects/updateForm/?object_id=<?=$obj->id?>" class="popup bar_button round">alterar status</a>                           
    <?}?>

        
    </div>  
    <div class="boxwired round" >
        <a class="collapse right" data-show="replies" title="abrir/fechar infos"><span class="collapse_ico">contrair</span></a>
        <b><span class="wordwrap"><?=@$obj->title;?></span></b><br/>
        <span class="wordwrap"><?=@$obj->taxonomia;?></span>
        <hr style="margin:8px 0;" />
        <?
        if($last_status->status_id == '8'){?>
        <a href='<?=URL::base();?>/admin/acervo/preview/<?=$obj->id?>' class="bar_button round right view_oed">visualizar</a>
        <?}?>

        <span class="list_faixa light_blue round left"><?=@$obj->collection->name?></span>
        <span class="list_faixa light_blue round left"><?=Utils_Helper::data(@$obj->collection->fechamento,'d/m/Y')?></span>
        <?if($obj->reaproveitamento == 0){ 
            $origem = "novo";
        }elseif($obj->reaproveitamento == 1){
            $origem = "reap.";
        }else{
            $origem = "reap. integral";
        }?>
        <span class="list_faixa light_blue round left"><?=$origem?></span>
        <span class="list_faixa light_blue round left"><?=@$obj->typeobject->name;?></span>
        
        <div class="clear">
        <b>início:</b> <?=Utils_Helper::data(@$obj->crono_date,'d/m/Y')?><br/>
        <b>entrega:</b> <?=Utils_Helper::data(@$obj->planned_date,'d/m/Y')?>
        </div>
        <div class="clear">
            <?foreach ($suppliersList as $supplier_obj) {?>
                <span class="list_faixa cyan round left"><?=@$supplier_obj->supplier->empresa;?></span>
            <?}?>
        </div>
    </div>

<div class="scrollable_content clear">             
    <?if(isset($objects_status)){
            $count = 0;
            foreach($objects_status as $object){
                ?>                          
                    <div style='clear:both' >
                        <div class='hist round step step_<?=$object->status->type?>_status<?=$object->status->id?>' >
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
                                }
                            ?>
                                                       
                            <div class='line_bottom'>
                                <div class="left">
                                    <?if($current_auth != "assistente"){?>
                                        <a href="<?=URL::base();?>admin/objects/updateForm/<?=$object->id?>" title="editar status" class="popup left">
                                    <?
                                    }

                                    $diff = '';
                                    $status_class = $object->status->type.'_status'.$object->status->id;
                                    if($object->diff != 0){

                                        if($object->diff < 0){
                                            $diff = '<span class="list_faixa green round">'.$object->diff.'</span>';
                                            //$status_class = 'green';
                                        }else{
                                            $diff = '<span class="list_faixa red round">+'.$object->diff.'</span>';
                                            $status_class = 'red';
                                        }
                                    }

                                    if($object->delivered_date != ''){
                                        $date_faixa = Utils_Helper::data($object->delivered_date, 'd/m/Y');
                                    }else{
                                        $date_faixa = Utils_Helper::data($object->crono_date, 'd/m/Y').' ('.Utils_Helper::getday($object->crono_date).')';
                                    }


                                    ?>
                                    <span class="list_faixa round left <?=$object->status->type.'_status'.$object->status->id?>"><?=$object->status->status;?></span>
                                    <span class="list_faixa round left <?=$status_class?>"><?=$date_faixa?></span><?=$diff?>
                                        </a>
                                </div>
                                
                            </div>
                            
                            <?if(!empty($object->description)){ ?>
                                <span class="wordwrap description"><?=$object->description;?></span>
                            <?}

                            //finalizado
                            if($count == 0 && $object->status_id == '8'){?>
                                <div id="uploadPackage" data-action="<?=URL::base()?>admin/objects/upload/<?=$object->object_id?>" class="dropzone" >           
                                    <div class="dz-message" data-dz-message><span>clique ou arraste o pacote de fechamento (.zip)<br/>tamanho max.: 100mb</span></div>                                    
                                </div>
                            <?}

                            $count++;

                            foreach ($object->anotacoes->order_by('id', 'desc')->find_all() as $anotacao) {?> 
                                <div class="clear">
                                    <div class="left">
                                        <?=Utils_Helper::getUserImage($anotacao->userInfo)?>
                                    </div>
                                    <div class="hist anotacoes round"> 
                                        
                                        <div class="left">
                                            <a href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?anotacao_id=<?=$anotacao->id?>&status_id=<?=$object->id?>" title="anotações" class="popup black"><?=Utils_Helper::data($anotacao->created_at, 'd/m/Y - H:i')?></a><br/>  
                                            
                                        </div>
                                        <?if($current_auth != "assistente"){?>                                        
                                        <div class="right">
                                            <a class="excluir" href="<?=URL::base()?>admin/anotacoes/delete/<?=$anotacao->id?>" data-panel="#direita" title="Excluir">Excluir</a>
                                        </div>
                                        <?}?>
                                        <hr class="clear" style="margin:8px 0;" />
                                        <div class="clear">                                            
                                            <span class="wordwrap description"><?=$anotacao->anotacao?></span>
                                        </div>
                                    </div> 
                                </div>

                            <?}  

                            /*
                            * Verificar como melhorar...
                            */
                            $query = $object->tasks->join('tags_teams', 'INNER')->on('tasks.tag_id', '=', 'tags_teams.tag_id');
                                        
                            if($current_auth != "admin"){
                                $query->where('tags_teams.team_id', '=', $user->team_id);
                            }

                            $task_tags = $query->group_by('tasks.id')->order_by('tasks.id', 'desc')->find_all();

                            foreach ($task_tags as $task) {?> 
                            
                                <div style='clear:both'>
                                    <div class='hist'>
                                        <div class="left"><?=Utils_Helper::getUserImage($task->userInfo)?></div>
                                        <div class="task round">
                                            <?if($current_auth != "assistente"){?>
                                                <div class="right">
                                                    <a class="excluir" href="<?=URL::base()?>admin/tasks/delete/<?=$task->id?>" data-panel="#direita" title="excluir">Excluir</a>
                                                </div>
                                            <?}?>
                                            <div class='line_bottom'>
                                                <div class="left">
                                                    <?if($current_auth != "assistente"){?>
                                                        <a href="<?=URL::base();?>admin/tasks/update/<?=$task->id?>" title="editar tarefa" class="popup">
                                                    <?}

                                                    $diff = '';
                                                    $color = $task->tag->color;
                                                    if($task->diff != 0){
                                                        if($task->diff < 0){
                                                            $diff = '<span class="list_faixa green round">'.$task->diff.'</span>';
                                                            //$color = $task->tag->color;
                                                        }else{
                                                            $diff = '<span class="list_faixa red round">+'.$task->diff.'</span>';
                                                            $color = 'red';
                                                        }
                                                    }

                                                    if($task->delivered_date != ''){
                                                        $date_faixa = Utils_Helper::data($task->delivered_date, 'd/m/Y');
                                                    }else{
                                                        $date_faixa = Utils_Helper::data($task->crono_date, 'd/m/Y').' ('.Utils_Helper::getday($task->crono_date).')';
                                                    }

                                                    ?>
                                                    <span class="round list_faixa left tag" style="background:<?=$task->tag->color?>"><?=$task->tag->tag?></span>
                                                    <span class="round list_faixa left tag" style="background:<?=$color?>"><?=$date_faixa?></span><?=$diff?>
                                                        </a> 
                                                </div>
                                                <? if($task->task_to != "0"){?>
                                                    <div class="left"><?=Utils_Helper::getUserImage($task->to)?></div>
                                                <?}?>
                                                <span class="round right list_faixa <?=$task->status->type?>_status<?=$task->status->id?>"><?=$task->status->status?></span>
                                            </div>
                                            <div class="clear" style="padding-top:5px;">
                                                <?if(!empty($task->description)){ ?>
                                                    <span class="wordwrap description replies replies_<?=$task->id;?>"><?=$task->description;?></span>
                                                <?}?>
                                            </div> 
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
                                                <div class="right"><?=Utils_Helper::getUserImage($task->to->id)?></div>
                                                <div class="task_reply round"> 
                                                    <? if($task->status_id == '5'){?>
                                                        <form action="<?=URL::base();?>admin/tasks_status/start" id="startTask" method="post" class="form">
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
                                                    <?}
                                                
                                                if($task->reply->id != '') {?>
                                                    <div class='line_bottom'>
                                                        <? if($current_auth != "assistente"){?>
                                                            <a href="<?=URL::base();?>admin/tasks/updateReply/<?=$task->reply->id?>" title="editar resposta" class="popup black">
                                                        <?}?>
                                                            <span class="round left list_faixa <?=$task->status->type?>_status<?=$task->status->id?>"><?=$task->status->status?></span>
                                                        <? if($task->reply->finished != ""){?>
                                                            <span class="round left list_faixa"><?=Utils_Helper::data($task->reply->finished, 'd/m/Y')?> (<?=Utils_Helper::getday($task->reply->finished)?>)</span>
                                                            </a>
                                                        <?}elseif($task->status_id == '6'){?>
                                                            <span class="round left list_faixa"><?=Utils_Helper::data($task->reply->created_at, 'd/m/Y')?> (<?=Utils_Helper::getday($task->reply->created_at)?>)</span>
                                                            </a>
                                                        <?}?>
                                                    </div>
                                                    <div class="clear">
                                                    <?if(!empty($task->reply->description)){ ?>
                                                        <span class="wordwrap description"><?=$task->reply->description;?></span>
                                                    <?}?>
                                                    </div>
                                                    <div class="options description" >
                                                        <? if($task->status_id == '6' && $task->to->id == $user->id){?>
                                                            <div class="right" style="min-height:20px; padding-top:10px">
                                                                <a href="<?=URL::base();?>admin/tasks/endtask/<?=$task->id?>" class="popup bar_button round">entregar</a>
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
