<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/materias/create" class="bar_button round">Criar Matéria</a>
	</div>
	<span class="header">Matérias</span>
	<table class="list">
		<thead>
			<th>nome</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($materiasList as $materia){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/materias/edit/'.$materia->id;?>" title="Editar"><?=$materia->nome?></a></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/materias/delete/'.$materia->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
