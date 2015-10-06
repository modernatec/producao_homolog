<div class="list_bar">
	<a href="<?=URL::base();?>admin/contatos/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar contato</a>
</div>
	<span class='list_alert'>
	<?
        if(count($contatosList) <= 0){
            echo 'não encontrei contatos com estes critérios.';    
        }else{
            echo count($contatosList).' contatos encontrados';
        }
    ?>
	</span>	

	<div class="list_body scrollable_content">
		<ul class="list_item">
			<? foreach($contatosList as $contato){?>
			<li>
				<a class="right icon icon_excluir" href="<?=URL::base().'admin/contatos/delete/'.$contato->id;?>" title="Excluir">Excluir</a>	
				<div class="item_content">	
				<a href="<?=URL::base().'admin/contatos/edit/'.$contato->id;?>" rel="load-content" data-panel="#direita" title="+ informações">
					<div>
						<b><?=$contato->nome?></b><br/>				
						<?=$contato->email?><br/>
						<?=$contato->telefone?>
					</div>
					<div class="line_itens">
						<span><?=$contato->service->name?></span>
					</div>
					
				</a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
