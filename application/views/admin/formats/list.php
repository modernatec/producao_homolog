<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/format/create" class="bar_button round">cadastrar formato</a>
	</div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs_content">formatos</a></li>
		</ul>
		<div id="tabs_content" >
			<div class="list_body">
				<ul class="list_item">
					<? foreach($sfwprodsList as $sfwprod){?>
					<li>
						<div class="left">
							<a style='display:block' href="<?=URL::base().'admin/format/edit/'.$sfwprod->id;?>" title="Editar"><?=$sfwprod->name?></a>
						</div>
						<div class="right">
							<a class="excluir" href="<?=URL::base().'admin/format/delete/'.$sfwprod->id;?>" title="Excluir">Excluir</a>
						</div>	
					</li>
					<?}?>
				</ul>
			</div>
		</div>
	</div>

	
</div>
