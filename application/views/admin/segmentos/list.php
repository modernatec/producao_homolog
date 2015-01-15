<div class="topo" >
	<span class="header">segmentos</span>
</div>
<div id="esquerda">
	<div class="bar">
		<a href="<?=URL::base();?>admin/segmentos/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar segmento</a>
	</div>
	<ul class="list_item">
		<? foreach($segmentosList as $segmento){?>
		<li>
			<div class="left">
				<a class="clean" href="<?=URL::base().'admin/segmentos/edit/'.$segmento->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$segmento->name?></a>
			</div>
			<div class="right">
				<a class="clean excluir" href="<?=URL::base().'admin/segmentos/delete/'.$segmento->id;?>" title="Excluir">Excluir</a>
			</div>	
		</li>
		<?}?>
	</ul>
</div>
<div id="direita"></div>