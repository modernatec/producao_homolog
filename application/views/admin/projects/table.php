	<span class='list_alert light_blue round'>
	<?
        if(count($projectsList) <= 0){
            echo 'não encontrei projetos com estes critérios.';    
        }else{
            echo 'encontrei '. count($projectsList).' projetos';
        }
    ?>
	</span>
		
	<div class="scrollable_content list_body">
		<ul class="list_item">
			<? foreach($projectsList as $projeto){
				$list_class = ($projeto->status == 0) ? "object_finished" : "light_blue";
			?>
			<li>
				<a style='display:block' href="<?=URL::base().'admin/projects/edit/'.$projeto->id;?>"  rel="load-content" data-panel="#direita" title="Editar">
					<p><?=$projeto->name?></p>
					<span class="left <?=$list_class?> round list_faixa"><?=($projeto->status == 0) ? "finalizado" : "em produção"?></span>
					<span class="left <?=$list_class?> round list_faixa"><?=$projeto->segmento->name?></span>
					<span class="left <?=$list_class?> round list_faixa"><?=count($projeto->collections->find_all())?> coleções</span>
				</a>
			</li>
			<?}?>
		</ul>
	</div>
