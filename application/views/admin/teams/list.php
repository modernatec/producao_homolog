<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/teams/create" class="bar_button round">Criar Equipe</a>
	</div>
	<span class="header">Equipes</span>
	<table class="list">
		<thead>
			<th>nome</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($teamsList as $teams){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/teams/edit/'.$teams->id;?>" title="Editar"><?=$teams->name?></a></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/teams/delete/'.$contacts->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
