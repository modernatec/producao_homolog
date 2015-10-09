	<div class="acervo_header">
		<span class='left text_cyan'>
		<?
			if(count($objectsList) <= 0){
                echo 'não encontrei objetos com estes critérios.';    
            }else{
                echo $total_objects.' objeto(s) encontrados';
            }
        ?>
		</span>

		<div class="right">
			<span class="left"><?=$items_per_page?> OED por página</span>
			<div class="left"><?=$pagination?></div>
		</div>
		
	</div>
	<div class="clear scrollable_content list_body">
			<?foreach($objectsList as $objeto){?>
			<div class="acervo_item round" id="obj_<?=$objeto->id?>">
				<a class="popup" href="<?=URL::base().'admin/acervo/view/'.$objeto->id?>" data-select="obj_<?=$objeto->id?>">
					<div class="acervo_item_top">
						<p class="text_cyan"><b><?=$objeto->title?></b></p>
						<p><?=$objeto->collection_name?></p>
					</div>
				</a>
			</div>
			<?}?>
	</div>
