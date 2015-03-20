<div class="topo" >
	<span class="header"><a href="<?=URL::base();?>admin/format/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar formato</a></span>
</div>
<div id="esquerda">
	<ul class="list_item">
		<? foreach($sfwprodsList as $sfwprod){?>
		<li>
			<div class="left">
				<a style='display:block' href="<?=URL::base().'admin/format/edit/'.$sfwprod->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$sfwprod->name?></a>
			</div>
			<div class="right">
				<a class="excluir" href="<?=URL::base().'admin/format/delete/'.$sfwprod->id;?>" title="Excluir">Excluir</a>
			</div>	
		</li>
		<?}?>
	</ul>	
</div>
<div id="direita"></div>