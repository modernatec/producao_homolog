<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/materias/create" class="bar_button round">cadastrar matéria</a>
	</div>
	<div style="padding:8px 0;">
		<label><b>matérias</b></label><hr/>
		<ul class="list_item">
			<? foreach($materiasList as $materia){?>
			<li>
				<div class="left">
					<a style='display:block' href="<?=URL::base().'admin/materias/edit/'.$materia->id;?>" title="Editar"><?=$materia->name?></a>
				</div>
				<div class="right">
					<a class="excluir" href="<?=URL::base().'admin/materias/delete/'.$materia->id;?>" title="Excluir">Excluir</a>
				</div>	
			</li>
			<?}?>
		</ul>
	</div>
</div>
