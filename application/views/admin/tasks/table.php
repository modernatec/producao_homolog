
<table class="list">
		<thead>
			<th width="30">para:</th>
            <th width="50">solicitação</th>
            <th width="50">OED</th>
            <th width="50">status</th>
            <th width="20">criada por:</th> 
            <th width="100">data de entrega</th>	            
		</thead>
		<tbody>
            <? foreach($taskList as $task){?>
                <tr>
                    <td width="40">
                        <? 
                            if($task->task_to != "0"){
                                $nome = explode(" ", $task->to->nome);?>
                                <div class="round_imgDetail green">
                                    <img class='round_imgList' src='<?=URL::base();?><?=($task->to->foto)?($task->to->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->to->nome);?>" />
                                    <span><?$nome = explode(" ", $task->to->nome); echo $nome[0];?></span>
                                    
                                </div>
                            <?}?>
                    </td>
                    <td>                        
                        <a href="<?=URL::base();?>/admin/objects/view/<?=$task->object_id?>"><?=$task->topic;?></a>
                    </td>
                    <td>
                        <?=$task->object->taxonomia;?>
                    </td>
                    <td>
                        <?=$task->status->status;?>
                    </td>
                    <td width="40">
                        <?$nome = explode(" ", $task->to->nome);?>
                        <div class="round_imgDetail">
                            <img class='round_imgList' src='<?=URL::base();?><?=($task->userInfo->foto)?($task->userInfo->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($task->userInfo->nome);?>" />
                            <span><?$nome = explode(" ", $task->userInfo->nome); echo $nome[0];?></span>
                            
                        </div>
                    </td> 
                    <td><?=Utils_Helper::data($task->crono_date)?></td>         
                </tr>
                <? }?>
		</tbody>
	</table>