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