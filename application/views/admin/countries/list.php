<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/countries/create" class="bar_button round">cadastrar país</a>
	</div>
	<span class="header">países</span>
	<ul class="list_item">
		<? foreach($countriesjsList as $country){?>
		<li>
			<div class="left">
				<a style='display:block' href="<?=URL::base().'admin/countries/edit/'.$country->id;?>" title="Editar"><?=$country->name?></a>
			</div>
			<div class="right">
				<a class="excluir" href="<?=URL::base().'admin/countries/delete/'.$country->id;?>" title="Excluir">Excluir</a>
			</div>	
		</li>
		<?}?>
	</ul>
</div>
