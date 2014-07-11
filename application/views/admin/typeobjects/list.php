<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/typeobjects/create" class="bar_button round">cadastrar tipos de objeto</a>
	</div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs_content">tipos de Objetos</a></li>
		</ul>
		<div id="tabs_content" >
			<div class="list_body">
				<ul class="list_item">
					<? foreach($typeObjectsjsList as $tipoObj){?>
					<li>
						<div class="left">
							<a style='display:block' href="<?=URL::base().'admin/typeobjects/edit/'.$tipoObj->id;?>" title="Editar"><?=$tipoObj->name?></a>
						</div>
						<div class="right">
							<a class="excluir" href="<?=URL::base().'admin/typeobjects/delete/'.$tipoObj->id;?>" title="Excluir">Excluir</a>
						</div>	
					</li>
					<?}?>
				</ul>
			</div>
		</div>
	</div>
</div>
