<div class="topo" >
	<span class="header"><a href="<?=URL::base();?>admin/workflows/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar workflow</a></span>
</div>
<div id="esquerda">
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($workflowList as $workflow){?>
			<li>
				<div class="left">
					<a style='display:block' href="<?=URL::base().'admin/workflows/edit/'.$workflow->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$workflow->name?></a>
				</div>
				<div class="right">
					<a class="excluir" href="<?=URL::base().'admin/workflows/delete/'.$workflow->id;?>" title="Excluir">Excluir</a>
				</div>	
			</li>
			<?}?>
		</ul>
	</div>
</div>
<div id="direita"></div>
