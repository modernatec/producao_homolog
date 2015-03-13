<div class="topo" >
	<span class="header">tipos de objetos</span>
</div>
<div id="esquerda">
	<div class="fixed clear">
		<div class="bar">
			<a href="<?=URL::base();?>admin/typeobjects/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar tipo de objeto</a>
		</div>
		<div id="tabs_content" class="scrollable_content clear">
			<ul class="list_item">
				<? foreach($typeObjectsjsList as $tipoObj){?>
				<li>
					<div class="left">
						<a style='display:block' href="<?=URL::base().'admin/typeobjects/edit/'.$tipoObj->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$tipoObj->name?></a>
					</div>
					<div class="right">
						<a class="excluir" href="<?=URL::base().'admin/typeobjects/delete/'.$tipoObj->id;?>" title="Excluir">Excluir</a>
					</div>	
				</li>
				<?}?>
			</ul>
		</div>
	</div>
</div>
<div id="direita"></div>