<table class="filelist">
	<thead>
        <th>Arquivo</th>	
	</thead>
	<tbody>
        <?foreach($filesList as $file){?>
        <tr>
            <td><a href="<?=URL::base();?>admin/files/download/<?=$file->id?>" title="Download" target="_blank"><?=basename($file->uri)?></a></td>
        </tr>
        <?}?>			
	</tbody>
</table>
