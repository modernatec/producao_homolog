<div class="list_header round">
	<div class="table_info round">
		<?=count($userinfosList)?> usuários encontrados 
		<a class="bar_button round green" href='<?=URL::base();?>admin/users'>limpar filtros</a>
	</div>
	<form action="<?=URL::base();?>admin/users" method="post" class="form">
		<div class="filters">
			<div class="left">
				<input type="text" class="round left" style="width:135px" placeholder="nome" name="nome" value="<?=$filter_nome?>" >
       		</div>
       		<div class="left">
				<input type="text" class="round left" style="width:135px" placeholder="email" name="email" value="<?=$filter_email?>" >
       			<input type="submit" class="round bar_button left" value="OK"> 
       		</div>
		</div>
	</form>	
</div>
<div class="list_body">
    <? 
	if(count($userinfosList) <= 0){
		echo '<span class="list_alert round">nenhum registro encontrado</span>';	
	}else{
	?>
	<ul class="list_item">
		<? foreach($userinfosList as $usuario){?>
		<li>
			<a href="<?=URL::base().'admin/users/edit/'.$usuario->id;?>" rel="load-content" data-panel="#direita" title="+ informações">
				<img class='round_imgList' src='<?=URL::base();?><?=($usuario->foto)?($usuario->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($usuario->nome);?>" />
				<div class="left" style="width:30%">
					<p><b><?=$usuario->nome?></b></p>
					<p><?=$usuario->email?></p>
					<p>ramal: <?=$usuario->ramal?></p>
				</div>
				<div class="left" style="width:20%">
					<p><?=$usuario->team->name?></p>
				</div>
			</a>
		</li>
		<?}?>
	</ul>
	<?}?>
</div>