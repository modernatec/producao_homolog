<div id="esquerda">
	<div class="list_bar">
		<a href="<?=URL::base();?>admin/repositorios/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar repositório</a>
	</div>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($repositoriosList as $repositorio){?>
			<li>
				<div class="left">
					<a style='display:block' href="<?=URL::base().'admin/repositorios/edit/'.$repositorio->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$repositorio->name?></a>
				</div>
				<div class="right">
					<a class="excluir" href="<?=URL::base().'admin/repositorios/delete/'.$repositorio->id;?>" title="Excluir">Excluir</a>
				</div>	
			</li>
			<?}?>
		</ul>
	</div>
</div>
<div id="direita"></div>
