	<div class="list_header round">
	<?$sql;?>
		<span class='list_alert light_blue round'>
		<?
			if(count($objectsList) <= 0){
                echo 'não encontrei objetos com estes critérios.';    
            }else{
                echo 'encontrei: '.$total_objects.' objeto(s)';
            }
        ?>
		</span>
		<div class="clear">
			<?=$pagination?>
		</div>
	</div>
	<div class="scrollable_content list_body">
			<?foreach($objectsList as $objeto){
				
			?>
			<div class="acervo_item round" id="obj_<?=$objeto->id?>">

				<a class="popup" href="<?=URL::base().'admin/acervo/view/'.$objeto->id?>" data-select="obj_<?=$objeto->id?>" title="+ informações">
					<div>	
						<div class="light_blue round item_type"><?=$objeto->tipo;?></div>
						<p class="clear"><b><?=$objeto->title?></b></p>
						<!--hr style="margin:8px 0;" /-->
						
						<p><?=$objeto->collection_name?></p>
						<?if($objeto->reaproveitamento == 0){ 
			                $origem = "novo";
			            }elseif($objeto->reaproveitamento == 1){
			                $origem = "reap.";
			            }else{
			                $origem = "reap. integral";
			            }?>
            
						
					</div>
				</a>
			</div>
			<?}?>
	</div>
