<div class="topo">
    <div id='filtros'></div>
</div>
<div id="esquerda">
	<div class="list_bar">
		<a href="<?=URL::base();?>admin/segmentos/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar segmento</a>
	</div>
	<span class='list_alert'>
	<?
        if(count($segmentosList) <= 0){
            echo 'não encontrei segmentos com estes critérios';    
        }else{
            echo count($segmentosList).' segmentos encontrados';
        }
    ?>
	</span>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($segmentosList as $segmento){?>
			<li>
				<a class="right icon icon_excluir" href="<?=URL::base().'admin/segmentos/delete/'.$segmento->id;?>" title="Excluir">Excluir</a>
				<div class="item_content">
					<a class="clean" href="<?=URL::base().'admin/segmentos/edit/'.$segmento->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$segmento->name?></a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
</div>
<div id="direita"></div>