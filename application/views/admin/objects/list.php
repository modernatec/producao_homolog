<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/objects/create" class="bar_button round">catalogar objeto</a>
	</div>
	<span class="header">Objetos</span>
        <!--div class="boxfilter">
            <form id="frmFilterObjects" action="<?=URL::base();?>admin/objects/filter/" method="post">
                <p>
                    <label>Tipo de objeto</label>
                    <select class="required round" name="typeobject_id" id="typeobject_id">
                        <option value=''>Todos</option>  
                        <?$tiposObj?>           
                    </select>
                </p>
                <p>
                    <label>Segmento</label>
                    <select class="required round" name="segmento_id" id="segmento_id">
                        <option value=''>Todos</option>
                        <?$segmentos?>
                    </select>
                </p>
                <p>
                    <label>Coleção</label>
                    <select class="required round" name="colecao" id="colecao">
                        <option value=''>Todos</option>
                        <?$colecaoList?>
                    </select>
                </p>
                <p>
                    <label>Ano</label>
                    <select class="required round" name="ano" id="ano">
                        <option value=''>Todos</option>
                        <?$dataLancamentoList?>
                    </select>
                </p>
                <p>
                    <label>Título</label>
                    <input type="text" class="required round" name="titulo" id="titulo" value="<?$titulo?>" />
                </p>
                <p>
                    <a href="<?=URL::base();?>admin/objects" class="bar_button round">Limpar</a> 
                    <a href="javascript:;" onclick="document.getElementById('frmFilterObjects').submit()" class="bar_button round">Buscar</a> 
                </p>
            </form>
        </div-->
	<table class="list">
		<thead>
			<th>nome</th>	
            <th>tipo de objeto</th>
            <th>tarefas</th>
            <th>coleção</th>
            <th>data de alteração</th>
		</thead>
		<tbody>
            <? foreach($objectsList as $objeto){?>
            <tr>
                <td>
                    <a href="<?=URL::base().'admin/objects/view/'.$objeto->id;?>" title="Editar"><?=$objeto->taxonomia?><br/><?=$objeto->title?></a>
                </td>
                <td><a><?=$objeto->typeobject->name?></a></td>
                <td>0</td>
                <td><a><?=$objeto->collection->name?></a></td>
                <td><a><?=Utils_Helper::data($objeto->updated_at,'d/m/Y \à\s H:i')?></a></td>
			</tr>
            <?}?>
		</tbody>
	</table>
        <?=$page_links?>
</div>
