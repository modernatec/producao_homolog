	<div class="list_bar">
		<a href="<?=URL::base();?>admin/materias/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar matéria</a>
	</div>
	<span class='list_alert'>
	<?
        if(count($materiasList) <= 0){
            echo 'não encontrei matérias com estes critérios';    
        }else{
            echo count($materiasList).' matérias encontradas';
        }
    ?>
	</span>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($materiasList as $materia){?>
			<li>
				<a class="right icon icon_excluir" href="<?=URL::base().'admin/materias/delete/'.$materia->id;?>" title="Excluir">Excluir</a>
				<div class="item_content">
					<a style='display:block' href="<?=URL::base().'admin/materias/edit/'.$materia->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$materia->name?></a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
