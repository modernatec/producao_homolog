<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/curriculums/create" class="bar_button round">Criar Curriculum</a>
	</div>
	<span class="header">Curriculums</span>
	<table class="list">
		<thead>
			<th>nome</th>
            <th>objetivo</th>
            <th>formado</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($curriculumsList as $curriculums){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/curriculums/edit/'.$curriculums->id;?>" title="Editar"><?=$curriculums->name?></a></td>	
                <td><?=$curriculums->objective?></td>
                <td><?=($curriculums->formado) ? 'Sim' : 'Não';?></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/curriculums/delete/'.$curriculums->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
