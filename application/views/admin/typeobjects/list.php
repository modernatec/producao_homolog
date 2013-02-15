<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/typeobjects/create" class="bar_button round">Criar Tipo de Objeto</a>
	</div>
	<span class="header">Tipo de Objetos</span>
	<table class="list">
		<thead>
			<th>nome</th>			
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($typeObjectsjsList as $tipoObj){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/typeobjects/edit/'.$tipoObj->id;?>" title="Editar"><?=$tipoObj->nome?></a></td>				
				<td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/typeobjects/delete/'.$tipoObj->id;?>" title="Excluir">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
</div>
