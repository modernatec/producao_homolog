<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/format/create" class="bar_button round">cadastrar formato</a>
	</div>
	<span class="header">formatos</span>
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
