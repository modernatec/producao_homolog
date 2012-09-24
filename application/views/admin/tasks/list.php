<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks/create" class="bar_button round">Criar tarefas</a>
	</div>
	
	<span class="header">tarefas</span>
	<table class="list">
		<thead>
			<th>nome</th>
			<th>status atual</th>
			<th>responsável</th>			
			<th>prioridade</th>
			<th>data de entrega</th>
		</thead>
		<tbody>
			<? foreach($taskList as $taskUser){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/tasks/edit/'.$taskUser->id;?>" title="Editar"><?=$taskUser->task->title?></a></td>
				<td>
					<?
						$status = $taskUser->task->status->find_all();
						echo $status[0]->status;
					?>
				</td>		
				<td><?=$taskUser->user->username?></td>
				<td><?=$taskUser->task->priority->priority?></td>	
				<td><?=Utils_Helper::data($taskUser->task->crono_date)?></td>			
			</tr>
            <?}?>
		</tbody>
	</table>

</div>