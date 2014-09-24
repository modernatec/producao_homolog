<div class="fixed clear">
    <div class="list_header round">
        <div class="table_info round">
            <?=count($taskList)?> tarefas encontradas 
        </div>
    </div>
    <div class="list_body scrollable_content">
    <? 
    if(count($taskList) <= 0){
        echo '<span class="list_alert round">nenhum registro encontrado</span>';    
    }else{
        if($current_auth != "assistente"){
            $id = "sortable";
        }else{
            $id = "";
        }
                     
        echo '<ul class="list_item" id="'.$id.'">';
        foreach($taskList as $key=>$task){?>
            <li class="dd-item" id="item-<?=$task->id?>">
                <a class="load"  href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>" rel="load-content" data-panel="#direita" title="+ informações">
                <!--div class="list_order left"><?=$key+1?></div-->
                    <div class="left" style="width:100px;">           
                        <? 
                            if($task->task_to != "0"){
                                $nome = explode(" ", $task->to->nome);?>
                                    <div class="round_imgDetail <?=$task->to->team->color?>">
                                        <img class='round_imgList' src='<?=URL::base();?><?=($task->to->foto)?($task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->to->nome);?>" />
                                        <span><?$nome = explode(" ", $task->to->nome); echo $nome[0];?></span>
                                        
                                    </div>
                            <?}else{ echo "&nbsp;";}?>
                    </div>
                    <div class="left" style="width:350px;">
                        <p><span class="<?=$task->tag->class?> round list_faixa"><?=$task->tag->tag?></span> &bull; <?=$task->object->taxonomia;?>
                        </p>
                        <p>por: <?=$task->userInfo->nome?> em: <?=Utils_Helper::data($task->created_at, "d/m/Y - H:i")?></p>
                        
                    </div>
                    <div class="left">
                        <p class="<?=$task->status->class?> round list_faixa">para: <?=Utils_Helper::data($task->crono_date)?> &bull; <?=$task->status->status;?></p>
                    </div>
                </a>
            </li>
        <?}
        echo '<ul>';
    }?>
    </div>
</div>