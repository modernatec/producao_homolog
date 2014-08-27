<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/segmentos/create" class="bar_button round">cadastrar segmento</a>
	</div>
	<div style="padding:8px 0;">
		<label><b>segmentos</b></label><hr/>
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
