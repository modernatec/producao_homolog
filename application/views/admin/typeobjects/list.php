	<div class="list_bar">
		<a href="<?=URL::base();?>admin/typeobjects/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar tipologia</a>	
	</div>
	<span class='list_alert'>
	<?
        if(count($typeObjectsjsList) <= 0){
            echo 'não encontrei tipos com estes critérios';    
        }else{
            echo count($typeObjectsjsList).' tipos encontrados';
        }
    ?>
	</span>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($typeObjectsjsList as $tipoObj){
				$qtd_oed = $tipoObj->objects->count_all();
			?>
			<li>
				<? if($qtd_oed > 0){?>
					<a class="icon icon_excluir right popup" href="<?=URL::base().'admin/typeobjects/deletePanel/'.$tipoObj->id;?>">Excluir</a>
				<?}else{?>
					<a class="icon icon_excluir right" href="<?=URL::base().'admin/typeobjects/delete/'.$tipoObj->id;?>" data-message="<?=$delete_msg?>">Excluir</a>
				<?}?>
				<div class="item_content">
					<a href="<?=URL::base().'admin/typeobjects/edit/'.$tipoObj->id;?>" rel="load-content" data-panel="#direita" ><b><?=$tipoObj->name?></b>
					<p><?=$qtd_oed;?> OED</p>
					</a>

				</div>
			</li>
			<?}?>
		</ul>
	</div>
