<div class="bar" style='margin-bottom:5px;'>
	<a href="<?=URL::base();?>admin/tags/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar tarefa</a>
</div>
<div class="scrollable_content">
<ul class="list_item sortable_tags">
            <? foreach($list as $tag){?>
            <li class="dd-item" id="item-<?=$tag->id?>">
                <a class="right excluir" href="<?=URL::base().'admin/tags/delete/'.$tag->id;?>" title="Excluir">Excluir</a>
                <span class="left ball" style="background:<?=$tag->color;?>"></span>
                <a style='display:block' href="<?=URL::base().'admin/tags/edit/'.$tag->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$tag->tag?></a>
            </li>
            <?}?>
        </ul>
</div>