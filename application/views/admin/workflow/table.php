<div class="bar" style='margin-bottom:5px;'>
	<a href="<?=URL::base();?>admin/workflows/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar workflow</a>
</div>
<div class="scrollable_content">	
	<ul class="list_item">
		<? foreach($workflowList as $workflow){?>
		<li>
			<div class="left">
				<a style='display:block' href="<?=URL::base().'admin/workflows/edit/'.$workflow->id;?>" class="popup" title="Editar"><?=$workflow->name?></a>
			</div>
			<div class="right">
				<a class="excluir" href="<?=URL::base().'admin/workflows/delete/'.$workflow->id;?>" title="Excluir">Excluir</a>
			</div>	
		</li>
		<?}?>
	</ul>
</div>

