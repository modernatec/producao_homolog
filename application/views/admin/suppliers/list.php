<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/suppliers/create" class="bar_button round">Cadastrar fornecedores</a>
	</div>
	<span class="header">Fornecedores</span>
	<table class="list">
		<thead>
			<th>empresa</th>
            <th>telefone</th>
            <th>contato</th>
            <th>trabalho</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($suppliersList as $supplier){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/suppliers/edit/'.$supplier->id;?>" title="Editar"><?=$supplier->empresa?></a></td>
                <td><a style='display:block' href="<?=URL::base().'admin/suppliers/edit/'.$supplier->id;?>" title="Editar"><?=$supplier->telefone?></a></td>
                <td><a style='display:block' href="<?=URL::base().'admin/suppliers/edit/'.$supplier->id;?>" title="Editar"><?=$supplier->nome?></a></td>
                <td><a style='display:block' href="<?=URL::base().'admin/suppliers/edit/'.$supplier->id;?>" title="Editar"><?=$supplier->trabalho?></a></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/suppliers/delete/'.$supplier->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
