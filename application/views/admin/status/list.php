<div class="topo" >
    <span class="header"><a href="<?=URL::base();?>admin/status/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar status</a></span>
</div>
<div id="esquerda">
    <div class="fixed clear">
        <div id="tabs_content" class="scrollable_content clear">
            <ul class="list_item">
                <? foreach($statusList as $status){?>
                <li>
                    <div class="left">
                        <span class="ball <?=$status->class;?>"></span>
                    </div>
                    <div class="left">
                        <a style='display:block' href="<?=URL::base().'admin/status/edit/'.$status->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$status->status?></a>
                    </div>
                    <div class="right">
                        <a class="excluir" href="<?=URL::base().'admin/status/delete/'.$status->id;?>" title="Excluir">Excluir</a>
                    </div>  
                </li>
                <?}?>
            </ul>
        </div>
    </div>
</div>
<div id="direita"></div>