<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks/create" class="bar_button round">Criar tarefas</a>
	</div>
	<span class="header">tarefas</span>
	<table class="list">
		<thead>
			<th>nome</th>
			<th>prioridade</th>			
			<th>data de entrega</th>
		</thead>
		<tbody>
			<? foreach($taskList as $task){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/task/edit/'.$task->id;?>" title="Editar"><?=$task->title?></a></td>
				<td><?=$task->priority->priority?></td>	
				<td><?=$task->crono_date?></td>			
			</tr>
            <?}?>
		</tbody>
	</table>
</div>