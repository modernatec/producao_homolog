<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/collections/create" class="bar_button round">Criar coleção</a>
	</div>
	<span class="header">coleções</span>
	<table class="list">
		<thead>
			<th>Op</th>
            <th>Título</th>	
            <th>Ano</th>	
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($collectionsList as $collection){?>
            <tr>
                <td><a style='display:block' href="<?=URL::base().'admin/collections/edit/'.$collection->id;?>" title="Editar"><?=$collection->op?></a></td>
				<td><?=$collection->name?></td>
				<td><?=$collection->ano?></td>			
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/collections/delete/'.$projeto->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
