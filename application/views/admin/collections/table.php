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
			<? foreach($collectionsList as $collection){?>
			<li>
				<a class="right icon icon_excluir" href="<?=URL::base().'admin/collections/delete/'.$collection->id;?>" title="Excluir">Excluir</a>	
				<div class="item_content">				
					<a class="check" href="<?=URL::base().'admin/collections/edit/'.$collection->id;?>" rel="load-content" data-panel="#direita" title="Editar">
						<p><b><?=$collection->name?></b></p>
						<p><?=Utils_Helper::data($collection->fechamento,'d/m/Y')?> | <?=$collection->segmento->name?></p>
						<div class="clear">
						<?foreach ($collection->userInfos->find_all() as $key => $userInfo) {?>
							<div class="left" style="width:25px;">           
	                        <?=Utils_Helper::getUserImage($userInfo);?>
	                    	</div>
						<?}?>
						</div>
					</a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
