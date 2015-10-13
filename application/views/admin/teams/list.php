<div class="topo" >
	
</div>
<div id="esquerda">
	<div class="list_bar"><a href="<?=URL::base();?>admin/teams/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar time</a></div>
	<ul class="list_item">
		<? foreach($teamsList as $teams){?>
		<li>
			<a class="right icon icon_excluir" href="<?=URL::base().'admin/teams/delete/'.$teams->id;?>" title="Excluir">Excluir</a>
			<div class="item_content">
				<a style='display:block' href="<?=URL::base().'admin/teams/edit/'.$teams->id;?>" rel="load-content" data-panel="#direita">
				<p><b><?=$teams->name?></b></p>
				<p>coord.: <?=$teams->userInfo->nome?></p>
				</a>
			</div>
		</li>
		<?}?>
	</ul>
</div>
<div id="direita"></div>