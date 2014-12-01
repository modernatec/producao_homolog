<div class="topo" >
	<span class="header">matérias</span>
</div>
<div id="esquerda">
	<div class="bar">
		<a href="<?=URL::base();?>admin/materias/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar matéria</a>
	</div>
	<span class="header">matérias</span>
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
<div id="direita"></div>
