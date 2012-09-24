<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/projects/create" class="bar_button round">Criar Projeto</a>
	</div>
	<span class="header">Projetos</span>
	<table class="list">
            <thead>
                <th>nome</th>			
                <th>ação</th>
            </thead>
            <tbody>
            <? foreach($projectsList as $projeto){?>
            <tr>
                <td><a style='display:block' href="<?=URL::base().'admin/projects/edit/'.$projeto->id;?>" title="Editar"><?=$projeto->name?></a></td>				
                <td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/projects/delete/'.$projeto->id;?>" title="Excluir">Excluir</a>
                </td>
            </tr>
            <?}?>
            </tbody>
	</table>
</div>
