	<div class="list_header round">
	<?=$sql;?>
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
		<ul class="list_item">
			<?foreach($objectsList as $objeto){
				
			?>
			<li>

				<a class="load" href="<?=URL::base().'admin/acervo/view/'.$objeto->id?>" rel="load-content" data-panel="#direita" title="+ informações">
					<div>
						<p><b><?=$objeto->title?></b></p><p><?=$objeto->taxonomia?></p>
						<hr style="margin:8px 0;" />
						
						<p><?=$objeto->collection_name?></p>
						<?if($objeto->reaproveitamento == 0){ 
			                $origem = "novo";
			            }elseif($objeto->reaproveitamento == 1){
			                $origem = "reap.";
			            }else{
			                $origem = "reap. integral";
			            }?>
            
						<p>
							<span class="light_blue round list_faixa left "><?=$objeto->tipo;?></span>
							<span class="light_blue round list_faixa left "><?=$origem?></span>
							<span class="light_blue round list_faixa"><?=$objeto->collection_ano?></span>
						</p>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
	</div>
