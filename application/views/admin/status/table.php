<div class="bar" style='margin-bottom:5px;'>
	<a href="<?=URL::base();?>admin/status/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar status</a>
</div>
<div class="scrollable_content">
	<ul class="list_item sortable_status">
        <? foreach($statusList as $status){?>
        <li class="dd-item" id="item-<?=$status->id?>">
            <a class="right excluir" href="<?=URL::base().'admin/status/delete/'.$status->id;?>" title="Excluir">Excluir</a>
            <span class="left ball" style='background: <?=$status->color;?>'></span>
            <a style='display:block' href="<?=URL::base().'admin/status/edit/'.$status->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$status->status?></a>
        </li>
        <?}?>
    </ul>
</div>