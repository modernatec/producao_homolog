<div class="content">
    <div class="bar">
		<a href="<?=URL::base();?>admin/users/create" class="bar_button round">Criar usuário</a>
	</div>
	<span class="header">Contatos</span>
	<table class="list">
		<thead>
			<th>nome</th>
                        <th>email</th>
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($userinfosList as $usuario){?>
            <tr>
                <td><a style='display:block' href="<?=URL::base().'admin/users/edit/'.$usuario->id;?>" title="Editar"><?=$usuario->nome?></a></td>
                <td><?=$usuario->email?></td>
                <td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/users/delete/'.$usuario->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
