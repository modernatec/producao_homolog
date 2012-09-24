<div class="content">
	<span class="header">Tarefas</span>
	<table class="list">
            <thead>
                <th>Tarefa</th>			                
            </thead>
            <tbody>
            <? foreach($taskList as $task){?>
            <tr>
                <td><a style='display:block' href="<?=URL::base().'admin/projects/edit/'.$projeto->id;?>" title="Editar"><?=$projeto->name?></a></td>				
                <td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/projects/delete/'.$projeto->id;?>" title="Excluir">Excluir</a>
                </td>
            </tr>
            <?}?>
            </tbody>
	</table>
</div>

