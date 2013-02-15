<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/countries/create" class="bar_button round">Criar País</a>
	</div>
	<span class="header">Países</span>
	<table class="list">
		<thead>
			<th>nome</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($countriesjsList as $country){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/countries/edit/'.$country->id;?>" title="Editar"><?=$country->nome?></a></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/countries/delete/'.$country->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
