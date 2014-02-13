<table class="list">
	<thead>
		<th></th>
		<th>Op</th>
        <th>Título</th>	
	</thead>
	<tbody>
        <? foreach($collectionsList as $collection){?>
        <tr>
        	<td><input type="checkbox" name="selected[]" id="<?=$collection->op?> - <?=$collection->name?>" class="select" value="<?=$collection->id?>" <?=(in_array($collection->id, $collectionsArr)) ? "checked" : ""?>></td>
            <td><label for="<?=$collection->op?> - <?=$collection->name?>" style="color:#000"><?=$collection->op?></label></td>
			<td><label for="<?=$collection->op?> - <?=$collection->name?>" style="color:#000"><?=$collection->name?></label></td>
		</tr>
        <?}?>
	</tbody>
</table>
