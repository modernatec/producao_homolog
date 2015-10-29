<div class="list_bar">
    	<a href="<?=URL::base();?>admin/collections/edit" rel="load-content" data-panel="#direita " class="bar_button round">cadastrar coleção</a>
	</div>  
	<span class='list_alert'>
	<?
        if(count($collectionsList) <= 0){
            echo 'não encontrei coleções com estes critérios';    
        }else{
            echo count($collectionsList).' coleções encontradas';
        }
    ?>
	</span>
		
	<div class="scrollable_content list_body">
		<ul class="list_item">
			<? foreach($collectionsList as $collection){
				$qtd_objects = $collection->objects->count_all();
			?>
			<li>
				<? if($qtd_objects > 0){?>
					<a class="right icon icon_excluir popup" href="<?=URL::base().'admin/collections/deletePanel/'.$collection->id;?>">Excluir</a>	
				<?}else{?>
					<a class="right icon icon_excluir" href="<?=URL::base().'admin/collections/delete/'.$collection->id;?>" data-message="<?=$delete_msg?>">Excluir</a>	
				<?}?>
				<div class="item_content">				
					<a class="check" href="<?=URL::base().'admin/collections/edit/'.$collection->id;?>" rel="load-content" data-panel="#direita">
						<p><b><?=$collection->name?></b></p>
						<p class="subtitle"><?=Utils_Helper::data($collection->fechamento,'d/m/Y')?> | <?=$collection->segmento->name?></p>						
					</a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
