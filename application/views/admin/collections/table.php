<div class="list_body">
	<ul class="list_item">
		<? foreach($collectionsList as $collection){?>
		<li>
			<div class="left">
				<p><a style='display:block' href="<?=URL::base().'admin/collections/edit/'.$collection->id;?>" title="Editar"><b><?=$collection->op?> - <?=$collection->name?></b></a></p>
				<p>fechamento: <?=Utils_Helper::data($collection->fechamento,'d/m/Y')?></p>
			</div>
			<div class="right">
				<a class="excluir" href="<?=URL::base().'admin/collections/delete/'.$collection->id;?>" title="Excluir">Excluir</a>
			</div>	
		</li>
		<?}?>
	</ul>
</div>