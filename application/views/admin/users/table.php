	<div class="boxwired round">
		<div class="table_info round">
			<div class="left"><?=count($userinfosList)?> usuários encontrados</div>
			<div class="left">
				<form action='<?=URL::base();?>admin/users/getUsers' id="frm_reset_oeds" data-panel="#tabs_content" method="post" class="form">
					<input type="hidden" name="reset_form" value="true">
					<input type="submit" class="bar_button round green" value="limpar filtros" />
				</form>
			</div>
		</div>
		<form action="<?=URL::base();?>admin/users/getUsers" id="frm_usuarios" data-panel="#tabs_content" method="post" class="form">
			<div class="filters">
				<div class="left">
					<input type="text" class="round left" style="width:100px" placeholder="nome" name="nome" value="<?=@$filter_nome?>" >
	       		</div>
	       		<div class="left">
					<input type="text" class="round left" style="width:140px" placeholder="email" name="email" value="<?=@$filter_email?>" >
	       			<input type="submit" class="round bar_button left" value="OK"> 
	       		</div>
			</div>

		</form>	
	</div>
	<div class="list_body scrollable_content">
	    <? 
		if(count($userinfosList) <= 0){
			echo '<span class="list_alert round">nenhum registro encontrado</span>';	
		}else{
		?>
		<ul class="list_item">
			<? foreach($userinfosList as $usuario){?>
			<li>
				<a href="<?=URL::base().'admin/users/edit/'.$usuario->id;?>" rel="load-content" data-panel="#direita" title="+ informações">
					<div class="left"><?=Utils_Helper::getUserImage($usuario)?></div>
					<span class='round list_faixa <?=$usuario->team->color?>'><?=$usuario->nome?></span> <span class='round list_faixa <?=$usuario->team->color?>'><?=$usuario->team->name?></span>
					<!--div class="round_imgDetail <?=$usuario->team->color?>">
						<img class='round_imgList' src='<?=URL::base();?><?=($usuario->foto)?($usuario->foto):('public/image/admin/default.png')?>' height="20" style='float:left' alt="<?=ucfirst($usuario->nome);?>" />
	                    <span><?=$usuario->nome?></span>
	                </div-->
					<div class="clear">
						
						<p>e-mail: <?=$usuario->email?></p>
						<p>ramal: <?=$usuario->ramal?></p>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		<?}?>
	</div>
