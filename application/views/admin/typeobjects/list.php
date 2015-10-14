	<div class="list_bar">
		<a href="<?=URL::base();?>admin/typeobjects/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar tipo de objeto</a>	
	</div>
	<span class='list_alert'>
	<?
        if(count($typeObjectsjsList) <= 0){
            echo 'não encontrei tipos com estes critérios';    
        }else{
            echo count($typeObjectsjsList).' tipos encontrados';
        }
    ?>
	</span>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($typeObjectsjsList as $tipoObj){?>
			<li>
				<a class="icon icon_excluir right" href="<?=URL::base().'admin/typeobjects/delete/'.$tipoObj->id;?>" title="Excluir">Excluir</a>
				<div class="item_content">
					<a href="<?=URL::base().'admin/typeobjects/edit/'.$tipoObj->id;?>" rel="load-content" data-panel="#direita" ><?=$tipoObj->name?></a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
