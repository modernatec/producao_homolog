<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/segmentos/create" class="bar_button round">Criar Segmento</a>
	</div>
	<span class="header">Segmentos</span>
	<table class="list">
		<thead>
			<th>nome</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($segmentosList as $segmento){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/segmentos/edit/'.$segmento->id;?>" title="Editar"><?=$segmento->name?></a></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/segmentos/delete/'.$segmento->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
