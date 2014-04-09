
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
                    <td>
                        <? 
                            if($task->task_to != "0"){
                                $nome = explode(" ", $task->to->nome);
                                echo "<span class='round label_name' >".ucfirst($nome[0])."</span>";
                            }
                        ?>
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
                    <td>
                        <img class='round_imgList' src='<?=URL::base();?><?=$task->userInfo->foto?>' height="25" title="<?=ucfirst($task->userInfo->nome);?>" /> 
                    </td> 
                    <td><?=Utils_Helper::data($task->crono_date)?></td>         
                </tr>
                <? }?>
		</tbody>
	</table>