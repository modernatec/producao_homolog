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
			<? foreach($projectsList as $projeto){?>
			<li>
				<a style='display:block' href="<?=URL::base().'admin/projects/edit/'.$projeto->id;?>"  rel="load-content" data-panel="#direita" title="Editar">
					<p class="left" style="width:100px;"><span class="<?=($projeto->status == 0) ? "object_finished" : "task_open"?> round list_faixa"><?=($projeto->status == 0) ? "finalizado" : "em produção"?></span></p>
					<p class="left"><?=$projeto->name?></p>
				</a>
			</li>
			<?}?>
		</ul>
	</div>