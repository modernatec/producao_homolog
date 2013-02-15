<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/objects/create" class="bar_button round">Criar Objeto</a>
	</div>
	<span class="header">Objetos</span>
        <div class="boxfilter">
            <form id="frmFilterObjects" action="<?=URL::base();?>admin/objects/filter/" method="post">
                <p>
                    <label>Tipo de objeto</label>
                    <select class="required round" name="typeobject_id" id="typeobject_id">
                        <option value=''>Todos</option>  
                        <?=$tiposObj?>           
                    </select>
                </p>
                <p>
                    <label>Segmento</label>
                    <select class="required round" name="segmento_id" id="segmento_id">
                        <option value=''>Todos</option>
                        <?=$segmentos?>
                    </select>
                </p>
                <p>
                    <label>Coleção</label>
                    <select class="required round" name="colecao" id="colecao">
                        <option value=''>Todos</option>
                        <?=$colecaoList?>
                    </select>
                </p>
                <p>
                    <label>Ano</label>
                    <select class="required round" name="ano" id="ano">
                        <option value=''>Todos</option>
                        <?=$dataLancamentoList?>
                    </select>
                </p>
                <p>
                    <label>Título</label>
                    <input type="text" class="required round" name="titulo" id="titulo" value="<?=$titulo?>" />
                </p>
                <p>
                    <a href="<?=URL::base();?>admin/objects" class="bar_button round">Limpar</a> 
                    <a href="javascript:;" onclick="document.getElementById('frmFilterObjects').submit()" class="bar_button round">Buscar</a> 
                </p>
            </form>
        </div>
	<table class="list">
		<thead>
			<th>nome</th>	
                        <th>tipo de objeto</th>
                        <th>coleção</th>
                        <th>segmento</th>
                        <th>data de alteração</th>
			<th>ação</th>
		</thead>
		<tbody>
            <? foreach($objectsList as $objeto){?>
            <tr>
                <td>
                    <a href="<?=URL::base().'admin/objects/'.$linkPage.'/'.$objeto->id;?>" title="Editar"><?=$objeto->nome_obj?></a>
                </td>
                <td><a><?=$objeto->typeobject->nome?></a></td>
                <td><a><?=$objeto->colecao?></a></td>
                <td><a><?=$objeto->segmento->nome?></a></td>
                <td><a><?=Utils_Helper::data($objeto->data_alt,'d/m/Y \a\s H:i:s')?></a></td>
                <td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/objects/delete/'.$objeto->id;?>" title="Excluir" <?=$styleExclusao?>>Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>
        <?=$page_links?>
</div>
