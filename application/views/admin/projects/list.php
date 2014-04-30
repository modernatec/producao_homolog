<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/projects/create" class="bar_button round">Criar Projeto</a>
	</div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs_content">projetos</a></li>
		</ul>
		<div id="tabs_content" >
			<table class="list">
				<thead>
					<th>nome</th>
					<th>status</th>			
					<th>ação</th>
				</thead>
				<tbody>
		            <? foreach($projectsList as $projeto){?>
		            <tr>
						<td><a style='display:block' href="<?=URL::base().'admin/projects/edit/'.$projeto->id;?>" title="Editar"><?=$projeto->name?></a></td>				
						<td><?=($projeto->status == 0) ? "finalizado" : "em produção"?></td>				
						<td class="acao">
		                    <a class="excluir" href="<?=URL::base().'admin/projects/delete/'.$projeto->id;?>" title="Excluir">Excluir</a>
		                </td>
					</tr>
		            <?}?>
				</tbody>
			</table>
		</div>
	</div>


	
</div>
