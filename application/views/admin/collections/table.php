<table class="list">
	<thead>
		<th>op</th>
        <th>título</th>
        <th>fechamento</th>	
        <th>ano</th>	
		<th>ação</th>
	</thead>
	<tbody>
        <? foreach($collectionsList as $collection){?>
        <tr>
            <td><a style='display:block' href="<?=URL::base().'admin/collections/edit/'.$collection->id;?>" title="Editar"><?=$collection->op?></a></td>
			<td><?=$collection->name?></td>
			<td><?=Utils_Helper::data($collection->fechamento,'d/m/Y')?></td>
			<td><?=$collection->ano?></td>			
			<td class="acao">
                <a class="excluir" href="<?=URL::base().'admin/collections/delete/'.$collection->id;?>" title="Excluir">Excluir</a>
            </td>
		</tr>
        <?}?>
	</tbody>
</table>