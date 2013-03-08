<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/softwares/create" class="bar_button round">Criar Software de produção</a>
	</div>
	<span class="header">Software de produção</span>
	<table class="list">
		<thead>
			<th>nome</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($sfwprodsList as $sfwprod){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/softwares/edit/'.$sfwprod->id;?>" title="Editar"><?=$sfwprod->nome?></a></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/softwares/delete/'.$sfwprod->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
