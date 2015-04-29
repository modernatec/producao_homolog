<div class="topo" >
	<span class="header"><a href="<?=URL::base();?>admin/typeobjects/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar tipo de objeto</a></span>
</div>
<div id="esquerda">
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($typeObjectsjsList as $tipoObj){?>
			<li>
				<a class="excluir right" href="<?=URL::base().'admin/typeobjects/delete/'.$tipoObj->id;?>" title="Excluir">Excluir</a>
				<a href="<?=URL::base().'admin/typeobjects/edit/'.$tipoObj->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$tipoObj->name?></a>
			</li>
			<?}?>
		</ul>
	</div>
</div>
<div id="direita"></div>