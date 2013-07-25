<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks/create" class="bar_button round">Criar tarefas</a>
	</div>
	<span class="header">minhas tarefas</span>
	<table class="list">
		<thead>
            <tr valign="bottom">
                <th width="150">título</th>
                <th width="200">taxonomia</th>
                <th width="100">status atual</th>
                <th width="100">de:</th>
                <th width="100">para:</th>	
                <th width="50">projeto</th>		
                <th width="50">prioridade</th>
                <th width="100">data de entrega</th>
            </tr>
		</thead>
		<tbody>
				<? foreach($taskList as $task){?>
                <tr>
                    <td><a style='display:block' href="<?=URL::base().'admin/tasks/edit/'.$task->id;?>" title="Editar"><?=$task->title?></a></td>
                    <td><?=$task->pasta?></td>
                    <td>
                        <?
                            $status = $task->status->order_by('status_tasks.id', 'DESC')->limit('1')->find_all();
                            echo $status[0]->status;
                        ?>
                    </td>
                    <td>
                        <?=$task->userInfo->nome;?>
                    </td>		
                    <td>
                        <?
                            $task_user = ORM::factory('tasks_user')->where('task_id', '=', $task->id)->order_by('id', 'DESC')->limit('1')->find_all();
                            echo $task_user[0]->userInfo->nome;
                        ?>
                    </td>
                    <td>
                        <?=$task->project->name;?>
                    </td>   
                    <td><?=$task->priority->priority?></td>	
                    <td><?=Utils_Helper::data($task->crono_date)?></td>			
                </tr>
                <? }?>
		</tbody>
	</table>
    <?
    	if(isset($taskTeam)){
	?>
    <span class="header">tarefas da minha equipe</span>
	<table class="list">
		<thead>
            <tr valign="bottom">
                 <th width="150">título</th>
                <th width="200">taxonomia</th>
                <th width="100">status atual</th>
                <th width="100">de:</th>
                <th width="100">para:</th>  
                <th width="50">projeto</th>     
                <th width="50">prioridade</th>
                <th width="100">data de entrega</th>
            </tr>
		</thead>
		<tbody>
				<? foreach($taskTeam as $task){?>
                <tr>
                    <td><a style='display:block' href="<?=URL::base().'admin/tasks/edit/'.$task->id;?>" title="Editar"><?=$task->title?></a></td>
                    <td><?=$task->pasta?></td>
                    <td>
                        <?
                            $status = $task->status->order_by('status_tasks.id', 'DESC')->limit('1')->find_all();
                            echo $status[0]->status;
                        ?>
                    </td>
                    <td>
                        <?=$task->userInfo->nome;?>
                    </td>		
                    <td>
                        <?
                            $task_user = ORM::factory('tasks_user')->where('task_id', '=', $task->id)->order_by('id', 'DESC')->limit('1')->find_all();
                            echo $task_user[0]->userInfo->nome;
                        ?>
                    </td>
                    <td>
                        <?=$task->project->name;?>
                    </td> 
                    <td><?=$task->priority->priority?></td>	
                    <td><?=Utils_Helper::data($task->crono_date)?></td>			
                </tr>
                <? }?>
		</tbody>
	</table>
	<? }?>
</div>