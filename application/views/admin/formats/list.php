<div id="esquerda">
	<div class="list_bar">
		<a href="<?=URL::base();?>admin/format/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar formato</a>    
	</div>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($sfwprodsList as $sfwprod){?>
			<li>
				<a class="right excluir" href="<?=URL::base().'admin/format/delete/'.$sfwprod->id;?>" title="Excluir">Excluir</a>
				<a style='display:block' href="<?=URL::base().'admin/format/edit/'.$sfwprod->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$sfwprod->name?></a>
			</li>
			<?}?>
		</ul>	
	</div>
</div>
<div id="direita"></div>