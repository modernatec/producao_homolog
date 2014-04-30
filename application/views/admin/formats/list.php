<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/format/create" class="bar_button round">+ formatos</a>
	</div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs_content">formatos</a></li>
		</ul>
		<div id="tabs_content" >
			<table class="list">
				<thead>
					<th>nome</th>			
					<th>ação</th>
				</thead>
				<tbody>
		            <? foreach($sfwprodsList as $sfwprod){?>
		            <tr>
						<td><a style='display:block' href="<?=URL::base().'admin/format/edit/'.$sfwprod->id;?>" title="Editar"><?=$sfwprod->name?></a></td>				
						<td class="acao">
		                    <a class="excluir" href="<?=URL::base().'admin/format/delete/'.$sfwprod->id;?>" title="Excluir">Excluir</a>
		                </td>
					</tr>
		            <?}?>
				</tbody>
			</table>
		</div>
	</div>

	
</div>
