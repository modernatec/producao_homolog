<div class="topo" >
	<span class="header"><a href="<?=URL::base();?>admin/projects/edit" rel="load-content" data-panel="#direita" class="bar_button round">Criar Projeto</a></span>
</div>
<div id="esquerda">
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($projectsList as $projeto){?>
			<li>
				<a style='display:block' href="<?=URL::base().'admin/projects/edit/'.$projeto->id;?>"  rel="load-content" data-panel="#direita" title="Editar">
					<p class="left" style="width:100px;"><span class="<?=($projeto->status == 0) ? "object_finished" : "task_open"?> round list_faixa"><?=($projeto->status == 0) ? "finalizado" : "em produção"?></span></p>
					<p class="left"><?=$projeto->name?></p>
				</a>
			</li>
			<?}?>
		</ul>
	</div>
</div>
<div id="direita"></div>