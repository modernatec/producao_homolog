<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/medias/create" class="bar_button round">Subir arquivo</a>
	</div>
	<span class="header">Media</span>
	<table class="list">
		<thead>
                        <th>tag</th>	
		</thead>
		<tbody>
            <? 
            $k = 0;
            foreach($tags as $tag){?>
                    <tr>
                        <td>
                            <a href="javascript:sldBox('#tag_<?=$k?>');"><?=$tag?></a>
                <table id="tag_<?=$k?>" style="display:none; width:990px;">
                    <? foreach($mediasList[$tag] as $medias){?>

                    <tr>
                        <td><a style='display:block' href="<?=URL::base().'admin/medias/download/'.$medias->id;?>" title="Baixar" target="_blank"><?=basename($medias->uri)?></a></td>
                        <td class="acao">
                            <a class="excluir" href="<?=URL::base().'admin/medias/delete/'.$medias->id;?>" title="Excluir">Excluir</a>
                        </td>
                    </tr>
                    <?}?>
                </table>
                    </td>
                </tr>
            <? 
                $k++;
            }?>
		</tbody>
	</table>
</div>