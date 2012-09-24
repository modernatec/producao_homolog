<table class="filelist">
	<thead>
        <th>Arquivo</th>	
	</thead>
	<tbody>
        <?foreach($filesList as $file){?>
        <tr>
            <td><a href="<?=$linkEditar?>" title="Editar"><?=basename($file->uri)?></a></td>
        </tr>
        <?}?>			
	</tbody>
</table>
