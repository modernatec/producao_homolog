<div class="topo" >
    <span class="header"><a href="<?=URL::base();?>admin/tags/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar tag</a></span>
</div>
<div id="esquerda">
    <div id="tabs_content" class="scrollable_content clear">
        <ul class="list_item">
            <? foreach($list as $tag){?>
            <li>
                <a class="right excluir" href="<?=URL::base().'admin/tags/delete/'.$tag->id;?>" title="Excluir">Excluir</a>
                <span class="left ball" style="background:<?=$tag->color;?>"><?=$tag->days;?></span>
                <a style='display:block' href="<?=URL::base().'admin/tags/edit/'.$tag->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$tag->tag?></a>
            </li>
            <?}?>
        </ul>
    </div>
</div>
<div id="direita"></div>