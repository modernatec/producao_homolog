<table class="filelist">
	<thead>
        <th><a href="javascript:sldBox('#hsFl_<?=$status_task->id?>');">Arquivos</a></th>
	</thead>
	<tbody id="hsFl_<?=$status_task->id?>" class="sld">
        <?foreach($filesList as $file){?>
        <tr>
            <td><a href="<?=URL::base();?>admin/files/download/<?=$file->id?>" title="Download" target="_blank"><?=basename($file->uri)?></a></td>
        </tr>
        <?}?>			
	</tbody>
</table>
