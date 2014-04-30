<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/segmentos/create" class="bar_button round">+ segmentos</a>
	</div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs_content">segmentos</a></li>
		</ul>
		<div id="tabs_content" >
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
	</div>
</div>
