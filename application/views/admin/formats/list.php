	<div class="list_bar">
		<a href="<?=URL::base();?>admin/formats/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar formato final</a>    
	</div>
	<span class='list_alert'>
	<?
        if(count($formatList) <= 0){
            echo 'não encontrei tipos com estes critérios';    
        }else{
            echo count($formatList).' tipos encontrados';
        }
    ?>
	</span>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($formatList as $format){
				$qtd_oed = $format->objects->count_all();
			?>
			<li>
				<? if($qtd_oed > 0){?>
					<a class="right icon icon_excluir popup" href="<?=URL::base().'admin/formats/deletePanel/'.$format->id;?>">Excluir</a>
				<?}else{?>
					<a class="right icon icon_excluir" href="<?=URL::base().'admin/formats/delete/'.$format->id;?>" data-message="<?=$delete_msg?>">Excluir</a>
				<?}?>
				<div class="item_content">
					<a style='display:block' href="<?=URL::base().'admin/formats/edit/'.$format->id;?>" rel="load-content" data-panel="#direita"><b><?=$format->name?></b><br/>
					<p class="subtitle"><?=$qtd_oed ?> OED</p></a>
				</div>
			</li>
			<?}?>
		</ul>	
	</div>