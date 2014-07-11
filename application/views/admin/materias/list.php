<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/materias/create" class="bar_button round">cadastrar matéria</a>
	</div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs_content">materias</a></li>
		</ul>
		<div id="tabs_content" >
			<div class="list_body">
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
	</div>

	
</div>
