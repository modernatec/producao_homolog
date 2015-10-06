<div id="esquerda">
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($list as $service){?>
			<li>
				<div class="left">
					<a style='display:block' href="<?=URL::base().'admin/services/edit/'.$service->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$service->name?></a>
				</div>
				<div class="right">
					<a class="excluir" href="<?=URL::base().'admin/services/delete/'.$service->id;?>" title="Excluir">Excluir</a>
				</div>	
			</li>
			<?}?>
		</ul>
	</div>
</div>
<div id="direita"></div>
