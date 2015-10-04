<div class="topo">
    <div id='filtros'></div>
</div>
<div id="esquerda">
	<div class="list_bar">
		<a href="<?=URL::base();?>admin/format/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar formato</a>    
	</div>
	<span class='list_alert'>
	<?
        if(count($sfwprodsList) <= 0){
            echo 'não encontrei tipos com estes critérios';    
        }else{
            echo count($sfwprodsList).' tipos encontrados';
        }
    ?>
	</span>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($sfwprodsList as $sfwprod){?>
			<li>
				<a class="right icon icon_excluir" href="<?=URL::base().'admin/format/delete/'.$sfwprod->id;?>" title="Excluir">Excluir</a>
				<div class="item_content">
					<a style='display:block' href="<?=URL::base().'admin/format/edit/'.$sfwprod->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$sfwprod->name?></a>
				</div>
			</li>
			<?}?>
		</ul>	
	</div>
</div>
<div id="direita"></div>