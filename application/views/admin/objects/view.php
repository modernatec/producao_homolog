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
            <?=Utils_Helper::data(@$obj->planned_date,'d/m/Y')?>
            <a href="" title="infos" class="popup icon icon_info">infos</a>
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
                    <div style='clear:both' class="step">
                        <div class="team_step_<?=$object->status->team_id?> roundTop">
                            <?if($current_auth != "assistente"){?>
                                <div class="right">
                                    <a class="icon icon_excluir" href="<?=URL::base()?>admin/objects/deleteStatus/<?=$object->id?>" title="excluir" data-panel="#direita">Excluir</a>
                                </div>
                            <?}?>

                            <div class="right">
                                <a class="popup icon icon_comment" href="<?=URL::base()?>admin/anotacoes/form/<?=@$obj->id?>?status_id=<?=$object->id?>" title="criar anotações">anotacao</a>
                            </div> 

                            <div>
                                <?if($current_auth != "assistente" && $object->crono_date != ''){?>
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
                                    if($object->crono_date != ''){
                                        $date_faixa = Utils_Helper::data($object->crono_date, 'd/m/Y').' ('.Utils_Helper::getday($object->crono_date).')';
                                    }else{
                                        $date_faixa = 'aguardando definição';
                                        $status_class = 'object_late';
                                    }
                                }


                                ?>
                                <?=$object->status->status;?> | <?=$date_faixa?> <?=$diff?>
                                    </a>
                            </div>
                        
                        </div>    
                        <div class='hist roundBottom' >                                
                            <?if(!empty($object->description)){ ?>
                                <span class="wordwrap description team_comment_<?=$object->status->team_id?>"><?=$object->description;?></span>
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
                                    <div >
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
                                                    <!--div class="left"><?=Utils_Helper::getUserImage($task->to)?></div-->
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
                                            <div >
                                                <div class="right"><?=Utils_Helper::getUserImage($task->to)?></div>
                                                <div class="task_reply round"> 
                                                    <? 
                                                        if($task->status_id == '5'){
                                                                if($task->tag_id == '7' && $current_auth == "assistente"){
                                                                    $start = false;
                                                                }else{?>
                                                                    <div style="padding:5px 0;">
                                                                        <a class="bar_button round startTask" href="<?=URL::base();?>admin/tasks_status/start" data-taskid="<?=$task->id?>" data-objectid="<?=$task->object_id?>" >iniciar</a>
                                                                    </div>
                                                                <?}
                                                        }
                                                    ?>
                                                        <!--form action="<?=URL::base();?>admin/tasks_status/start" id="startTask" method="post" class="form">
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

                                                        </form-->
                                                    <?//}
                                                
                                                if($task->reply->id != '') {?>
                                                    <div class='line_bottom'>
                                                        <? if($current_auth != "assistente"){?>
                                                            <a href="<?=URL::base();?>admin/tasks/updateReply/<?=$task->reply->id?>" title="editar resposta" class="popup black">
                                                        <?}?>
                                                            <span class="round left list_faixa <?=$task->status->type?>_status<?=$task->status->id?>"><?=$task->status->status?></span>
                                                        <? if($task->reply->finished != ""){?>
                                                            <span class="round left list_faixa <?=$task->status->type?>_status<?=$task->status->id?>"><?=Utils_Helper::data($task->reply->finished, 'd/m/Y')?> (<?=Utils_Helper::getday($task->reply->finished)?>)</span>
                                                            </a>
                                                        <?}elseif($task->status_id == '6'){?>
                                                            <span class="round left list_faixa <?=$task->status->type?>_status<?=$task->status->id?>"><?=Utils_Helper::data($task->reply->created_at, 'd/m/Y')?> (<?=Utils_Helper::getday($task->reply->created_at)?>)</span>
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
                                    <hr class="clear" style="margin:8px 0;" />                              
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
