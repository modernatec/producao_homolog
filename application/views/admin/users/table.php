	<span class='list_alert'>
	<?
        if(count($userinfosList) <= 0){
            echo 'não encontrei usuários com estes critérios.';    
        }else{
            echo count($userinfosList).' usuários encontrados';
        }
    ?>
	</span>
	<div class="clear list_body scrollable_content">
	    <ul class="list_item">
			<? foreach($userinfosList as $usuario){?>
			<li>
				<div class="item_content">
				<a href="<?=URL::base().'admin/users/edit/'.$usuario->id;?>" rel="load-content" data-panel="#direita" title="+ informações">
					<div class="left"><?=Utils_Helper::getUserImage($usuario)?></div>
					<div class="left">
						<span class='line'><?=$usuario->nome?></span>
						<p><?=$usuario->email?></p>
						<p><?=$usuario->ramal?></p>
					</div>
				</a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
