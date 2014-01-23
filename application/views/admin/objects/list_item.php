<div class="boxwired round list_item">
	<a href="<?=URL::base().'admin/objects/'.$linkPage.'/'.$objeto->id;?>" title="Editar">
	<div class="left">
		<?=$objeto->taxonomia?> - <?=$objeto->title?><br/>
		atualizado em: <?=Utils_Helper::data($objeto->updated_at,'d/m/Y \à\s H:i')?>
	</div>
	<div class="left">
		<?=$objeto->collection->name?>
	</div>
	</a>
</div>
<!--table class="list">
		<thead>
			<th>nome</th>	
            <th>tipo de objeto</th>
            <th>coleção</th>
            <th>data de alteração</th>
			<th>ação</th>
		</thead>
		<tbody>
            <? /*foreach($objectsList as $objeto){*/?>
            <tr>
                <td>
                    <a href="<?=URL::base().'admin/objects/'.$linkPage.'/'.$objeto->id;?>" title="Editar"><?=$objeto->taxonomia?></a>
                </td>
                <td><a><?=$objeto->typeobject->name?></a></td>
                <td><a></a></td>
                <td><a><?=Utils_Helper::data($objeto->updated_at,'d/m/Y \à\s H:i')?></a></td>
                <td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/objects/delete/'.$objeto->id;?>" title="Excluir" <?=$styleExclusao?>>Excluir</a>
                </td>
			</tr>
            
		</tbody>
	</table-->