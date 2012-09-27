<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/contacts/create" class="bar_button round">Criar Contatos</a>
	</div>
	<span class="header">Contatos</span>
	<table class="list">
		<thead>
			<th>nome</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($contactsList as $contacts){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/contacts/edit/'.$contacts->id;?>" title="Editar"><?=$contacts->nome?></a></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/contacts/delete/'.$contacts->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
