<div class="fixed clear">
	<div class="list_header round">
		<div class="table_info round">
			<?=count($collectionsList)?> coleções encontradas 
		</div>
	</div>
	<div class="list_body scrollable_content">
		<ul class="list_item">
			<? foreach($collectionsList as $collection){?>
			<li>
				<div class="left">
					<p><a style='display:block' class="check" href="<?=URL::base().'admin/collections/edit/'.$collection->id;?>" rel="load-content" data-panel="#direita" title="Editar"><b><?=$collection->op?> - <?=$collection->name?></b></a></p>
					<p>fechamento: <?=Utils_Helper::data($collection->fechamento,'d/m/Y')?></p>
				</div>
				<div class="right">
					<a class="excluir" href="<?=URL::base().'admin/collections/delete/'.$collection->id;?>" title="Excluir">Excluir</a>
				</div>	
			</li>
			<?}?>
		</ul>
	</div>
</div>