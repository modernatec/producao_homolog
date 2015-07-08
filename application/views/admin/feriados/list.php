<div class="topo" >
	<span class="header"><a href="<?=URL::base();?>admin/feriados/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar feriado</a></span>
</div>
<div id="esquerda">
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($feriadosList as $feriado){?>
			<li>
				<div class="left">
					<a style='display:block' href="<?=URL::base().'admin/feriados/edit/'.$feriado->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=Utils_Helper::data($feriado->data).' - '.$feriado->feriado?></a>
				</div>
				<div class="right">
					<a class="excluir" href="<?=URL::base().'admin/feriados/delete/'.$feriado->id;?>" title="Excluir">Excluir</a>
				</div>	
			</li>
			<?}?>
		</ul>
	</div>
</div>
<div id="direita"></div>
