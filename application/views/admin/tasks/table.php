
<div class="list_header round">
    <table class="list">
    	<thead>
    		<th width="30">para:</th>
            <th width="50">solicitação</th>
            <th width="50">OED</th>
            <th width="50">status</th>
            <th width="20">criada por:</th> 
            <th width="100">data de entrega</th>	            
    	</thead>
    </table>
</div> 
<div class="dd">
<? 
if(count($taskList) <= 0){
    echo '<span class="list_alert round">nenhum registro encontrado</span>';    
}else{
    echo '<ol class="dd-list">';
    foreach($taskList as $key=>$task){?>
        <li class="dd-item" data-id="<?=$key?>">
            <div class="dd-handle left"><?=$key+1?></div>
                <div class="left">
                    
                    <? 
                        if($task->task_to != "0"){
                            $nome = explode(" ", $task->to->nome);?>
                            <a href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>">
                                <div class="round_imgDetail <?=$task->to->team->color?>">
                                    <img class='round_imgList' src='<?=URL::base();?><?=($task->to->foto)?($task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->to->nome);?>" />
                                    <span><?$nome = explode(" ", $task->to->nome); echo $nome[0];?></span>
                                    
                                </div>
                            </a>
                        <?}?>
                </div>
                <div class="left">
                    <p><a href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>"><b><?=$task->topic;?></b></a></p>
                    <p><a href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>"><?=$task->object->taxonomia;?></a></p>
                    <p class="red round list_faixa"><?=$task->status->status;?> &bull; retorno: <?=Utils_Helper::data($task->crono_date)?></p>
                </div>
            
        </li>
    <?}
    echo '<ol>';
}?>
</div>

		<!--tbody>
            <? foreach($taskList as $task){?>
                <tr >
                    <td width="40">
                        <? 
                        if($task->task_to != "0"){
                            $nome = explode(" ", $task->to->nome);?>
                            <a href="<?=URL::base();?>admin/objects/view/<?=$task->object_id?>">
                                <div class="round_imgDetail <?=$task->to->team->color?>">
                                    <img class='round_imgList' src='<?=URL::base();?><?=($task->to->foto)?($task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->to->nome);?>" />
                                    <span><?$nome = explode(" ", $task->to->nome); echo $nome[0];?></span>
                                    
                                </div>
                            </a>
                        <?}?>
                    </td>
                    <td></td>
                    <td></a></td>
                    <td></td>
                    <td width="40">
                        <?$nome = explode(" ", $task->to->nome);?>
                        <div class="round_imgDetail <?=$task->userInfo->team->color?>">
                            <img class='round_imgList' src='<?=URL::base();?><?=($task->userInfo->foto)?($task->userInfo->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->userInfo->nome);?>" />
                            <span><?$nome = explode(" ", $task->userInfo->nome); echo $nome[0];?></span>
                            
                        </div>
                    </td> 
                    <td></td>         
                </tr>
                <? }?>
		</tbody>
	</table-->