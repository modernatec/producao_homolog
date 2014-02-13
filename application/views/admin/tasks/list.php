<div class="content">
	<span class="header">minhas tarefas (<?=count($taskList);?>)</span>
    <table class="list">
        <thead>
            <tr valign="bottom">
                <th width="50">solicitação</th>
                <th width="50">OED</th>
                <th width="20">de:</th>
                <th width="20">para:</th>  
                <th width="100">data de entrega</th>
            </tr>
        </thead>
        <tbody>
                <? foreach($taskList as $task){?>
                <tr>
                    <td>
                        <a href="<?=URL::base();?>/admin/objects/view/<?=$task->object_id?>"><?=$task->topic;?></a>
                    </td>
                    <td>
                        <?=$task->object->taxonomia;?>
                    </td>
                    <td>
                        <img class='round_imgList' src='<?=URL::base();?><?=$task->userInfo->foto?>' height="25" title="<?=ucfirst($task->userInfo->nome);?>" /> 
                    </td>       
                    <td>
                        <?
                            $task_user = ORM::factory('tasks_user')->where('task_id', '=', $task->id)->order_by('id', 'DESC')->limit('1')->find_all();
                        ?>
                            <img class='round_imgList' src='<?=URL::base();?><?=$task_user[0]->userInfo->foto?>' height="25" title="<?=ucfirst($task_user[0]->userInfo->nome);?>" /> 
                    </td>
                    <td><?=Utils_Helper::data($task->crono_date)?></td>         
                </tr>
                <? }?>
        </tbody>
    </table>  
</div>