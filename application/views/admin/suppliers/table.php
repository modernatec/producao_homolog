
<table class="list">
		<thead>
			<form action="<?=URL::base();?>admin/suppliers" method="post" class="form">
			<th width="250">
				<div class="filter" >
				    <ul>
				        <li class="round" >
				            <span id="tipo">empresa <?=(!empty($filter_empresa) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <ul class="round" >
			            		<li><input type="text" class="round" style="width:135px" name="empresa" value="<?=$filter_empresa?>" ></li>
				                
				                <input type="submit" class="round bar_button" value="OK"> 
				                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>
				</div>
			</th>
			<th width="200">
				<div class="filter" >
				    <ul>
				        <li class="round" >
				            <span id="tipo">contato <?=(!empty($filter_contato) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <ul class="round" >
			            		<li><input type="text" class="round" style="width:135px" name="contato" value="<?=$filter_contato?>" ></li>
				                
				                <input type="submit" class="round bar_button" value="OK"> 
				                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>

				</div>
			</th>
            <th>telefone</th>
            <th>trabalho</th>	
         	</form>
		</thead>
		<tbody>
            <? foreach($suppliersList as $supplier){?>
            <tr>
				<td><a style='display:block' href="<?=URL::base().'admin/suppliers/edit/'.$supplier->id;?>" title="Editar"><?=$supplier->empresa?></a></td>
                <td><a style='display:block' href="<?=URL::base().'admin/suppliers/edit/'.$supplier->id;?>" title="Editar"><?=$supplier->name?></a></td>
                <td><a style='display:block' href="<?=URL::base().'admin/suppliers/edit/'.$supplier->id;?>" title="Editar"><?=$supplier->telefone?></a></td>
                
                <td><a style='display:block' href="<?=URL::base().'admin/suppliers/edit/'.$supplier->id;?>" title="Editar"><?=$supplier->trabalho?></a></td>				
				
			</tr>
            <?}?>
		</tbody>
	</table>