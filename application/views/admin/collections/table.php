	<span class='list_alert light_blue round'>
	<?
        if(count($collectionsList) <= 0){
            echo 'não encontrei coleções com estes critérios.';    
        }else{
            echo 'encontrei '. count($collectionsList).' coleções';
        }
    ?>
	</span>
		
	<div class="scrollable_content list_body">
		<ul class="list_item">
			<? foreach($collectionsList as $collection){?>
			<li>				
				<a class="right excluir" href="<?=URL::base().'admin/collections/delete/'.$collection->id;?>" title="Excluir">Excluir</a>	
				<a class="check" href="<?=URL::base().'admin/collections/edit/'.$collection->id;?>" rel="load-content" data-panel="#direita" title="Editar">
					<p><?=$collection->name?></p>
					<span class="list_faixa round light_blue left"><img src="<?=URL::base()?>/public/image/admin/calendar2.png"  height="12" valign='middle' > <?=Utils_Helper::data($collection->fechamento,'d/m/Y')?></span><span class="light_blue round list_faixa left"><?=$collection->segmento->name?></span>
					<?foreach ($collection->userInfos->find_all() as $key => $userInfo) {?>
						<div class="left" style="width:25px;">           
                        <?=Utils_Helper::getUserImage($userInfo);?>
                    	</div>
					<?}?>
				</a>
			</li>
			<?}?>
		</ul>
	</div>
