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
                        <a href="javascript:sldBox('#blk_tag_<?=$k?>');" id="tag_<?=$k?>" class="tags" rightClick="true" title="Para editar esta tag, clique com o botão direito do mouse"><?=$tag?></a>
                        <table id="blk_tag_<?=$k?>" style="display:none; width:100%;">
                            <tr>
                            	<td>Arquivo</td>
                                <td colspan="2">Tamanho</td>
                            </tr>
							<? 
							$filesList = $tag->getFiles($tag->id);
							
							foreach($filesList as $file){?>
                            <tr>
                                <!--td><a style='display:block' href="<?=URL::base().'admin/files/download/'.$file->id;?>" title="Baixar" target="_blank"><?=basename($file->uri)?></a></td-->
                                <td>
                                    <a style='display:block' href="<?=URL::base();?>admin/files/download/<?=$file->id?>" title="Preview" target="_blank"><?=basename($file->uri)?></a>                            
                                </td>
                                <td>
                                	<?=Utils_Helper::getSize($file->size)?>
                                </td>
                                <td class="acao" width='20px'>
                                    <a class="excluir" href="<?=URL::base().'admin/medias/delete/'.$file->id;?>" title="Excluir">Excluir</a>
                                </td>
                            </tr>
                            <? }?>
                        </table>
                    </td>
                </tr>
            <? 
                $k++;
            }?>
		</tbody>
	</table>
</div>