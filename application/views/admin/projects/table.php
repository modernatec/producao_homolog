<div class="list_bar">
		<a href="<?=URL::base();?>admin/projects/edit" rel="load-content" data-panel="#direita" class="bar_button round">criar projeto</a>		
	</div>   
	<span class='list_alert'>
	<?
        if(count($projectsList) <= 0){
            echo 'não encontrei projetos com estes critérios';    
        }else{
            echo count($projectsList).' projetos encontrados';
        }
    ?>
	</span>
		
	<div class="scrollable_content list_body">
		<ul class="list_item">
			<? foreach($projectsList as $projeto){
				$list_class = ($projeto->status == 0) ? "object_finished" : "light_blue";
			?>
			<li>
				<div class="item_content">
					<a style='display:block' href="<?=URL::base().'admin/projects/edit/'.$projeto->id;?>" rel="load-content" data-panel="#direita">
						<b><?=$projeto->name?></b>
						<p class="subtitle"><?=$projeto->segmento->name?> | <?=count($projeto->collections->find_all())?> coleções | <?=($projeto->status == 0) ? "finalizado" : "produzindo"?></p>
						
					</a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
