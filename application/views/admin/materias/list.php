<div class="topo" >
	<span class="header"><a href="<?=URL::base();?>admin/materias/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar matéria</a></span>
</div>
<div id="esquerda">
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($materiasList as $materia){?>
			<li>
				<div class="left">
					<a style='display:block' href="<?=URL::base().'admin/materias/edit/'.$materia->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$materia->name?></a>
				</div>
				<div class="right">
					<a class="excluir" href="<?=URL::base().'admin/materias/delete/'.$materia->id;?>" title="Excluir">Excluir</a>
				</div>	
			</li>
			<?}?>
		</ul>
	</div>
</div>
<div id="direita"></div>
