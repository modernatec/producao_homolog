
<table class="list">
		<thead>
			<form action="<?=URL::base();?>admin/users" method="post" class="form">
			<th width="250">
				<div class="filter" >
				    <ul>
				        <li class="round" >
				            <span id="tipo">nome <?=(!empty($filter_nome) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <ul class="round" >
			            		<li><input type="text" class="round" style="width:135px" name="nome" value="<?=$filter_nome?>" ></li>
				                
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
				            <span id="tipo">email <?=(!empty($filter_email) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <ul class="round" >
			            		<li><input type="text" class="round" style="width:135px" name="email" value="<?=$filter_email?>" ></li>
				                
				                <input type="submit" class="round bar_button" value="OK"> 
				                <input type="button" class="round bar_button cancelar" value="Cancelar"> 
				            </ul>
				        </li>
				    </ul>

				</div>
			</th>
            <th>equipe</th>
            <th>ramal</th>
			<th>ação</th>	
         	</form>
		</thead>
		<tbody>
            <? foreach($userinfosList as $usuario){?>
            <tr>
                <td><img src='<?=URL::base();?><?=($usuario->foto)?($usuario->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($usuario->nome);?>" /><a style='display:block' href="<?=URL::base().'admin/users/edit/'.$usuario->id;?>" title="Editar"><?=$usuario->nome?></a></td>
                <td><?=$usuario->email?></td>
                <td><?=$usuario->team->name?></td>
                <td><?=$usuario->ramal?></td>
                <td class="acao">
                    <a class="excluir" href="<?=URL::base().'admin/users/inativate/'.$usuario->id;?>" title="inativar">Excluir</a>
                </td>
			</tr>
            <?}?>
		</tbody>
	</table>