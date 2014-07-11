<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/segmentos/create" class="bar_button round">cadastrar segmento</a>
	</div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs_content">segmentos</a></li>
		</ul>
		<div id="tabs_content" >
			<div class="list_body">
				<ul class="list_item">
					<? foreach($segmentosList as $segmento){?>
					<li>
						<div class="left">
							<a style='display:block' href="<?=URL::base().'admin/segmentos/edit/'.$segmento->id;?>" title="Editar"><?=$segmento->name?></a>
						</div>
						<div class="right">
							<a class="excluir" href="<?=URL::base().'admin/segmentos/delete/'.$segmento->id;?>" title="Excluir">Excluir</a>
						</div>	
					</li>
					<?}?>
				</ul>
			</div>
		</div>
	</div>
</div>
