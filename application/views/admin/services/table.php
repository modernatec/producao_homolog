<div class="list_bar">
	<a href="<?=URL::base();?>admin/services/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar serviço</a>
</div>
<div class="scrollable_content">
	<ul class="list_item">
        <? foreach($list as $service){?>
        <li>
            <a class="right icon icon_excluir" href="<?=URL::base().'admin/services/delete/'.$service->id;?>" title="Excluir">Excluir</a>
            <div class="item_content">
                <a style='display:block' href="<?=URL::base().'admin/services/edit/'.$service->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$service->name?></a>
            </div>
        </li>
        <?}?>
    </ul>
</div>