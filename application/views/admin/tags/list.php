<div class="topo" >
    <span class="header"><a href="<?=URL::base();?>admin/tags/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar tag</a></span>
</div>
<div id="esquerda">
    <div class="fixed clear">
        <div id="tabs_content" class="scrollable_content clear">
            <ul class="list_item">
                <? foreach($list as $tag){?>
                <li>
                    <div class="left">
                        <span class="ball " style="background:#<?=$tag->class;?>"></span>
                    </div>
                    <div class="left">
                        <a style='display:block' href="<?=URL::base().'admin/tags/edit/'.$tag->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$tag->tag?></a>
                    </div>
                    <div class="right">
                        <a class="excluir" href="<?=URL::base().'admin/tags/delete/'.$tag->id;?>" title="Excluir">Excluir</a>
                    </div>  
                </li>
                <?}?>
            </ul>
        </div>
    </div>
</div>
<div id="direita"></div>