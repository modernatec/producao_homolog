<div class="scrollable_content">
<ul class="list_item sortable_tags">
            <? foreach($list as $tag){?>
            <li class="dd-item" id="item-<?=$tag->id?>">
                <a class="right excluir" href="<?=URL::base().'admin/tags/delete/'.$tag->id;?>" title="Excluir">Excluir</a>
                <span class="left ball" style="background:<?=$tag->color;?>"><?=$tag->days;?></span>
                <? $dot = ($tag->sync == '1') ? '*' : '';?>
                <a style='display:block' href="<?=URL::base().'admin/tags/edit/'.$tag->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$dot.$tag->tag?></a>
            </li>
            <?}?>
        </ul>
</div>