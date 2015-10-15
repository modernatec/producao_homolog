<div class="list_bar" >
	<a href="<?=URL::base();?>admin/status/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar status</a>
</div>
<span class='list_alert'>
    <?
        if(count($statusList) <= 0){
            echo 'não encontrei status com estes critérios';    
        }else{
            echo count($statusList).' status encontrados';
        }
    ?>
    </span>
<div class="scrollable_content">
	<ul class="list_item sortable_status">
        <? foreach($statusList as $status){?>
        <li class="dd-item" id="item-<?=$status->id?>">
            <a class="right icon icon_excluir" href="<?=URL::base().'admin/status/delete/'.$status->id;?>" title="Excluir">Excluir</a>
            <span class="left ball" style='background: <?=$status->color;?>'></span>
            <a style='display:block' href="<?=URL::base().'admin/status/edit/'.$status->id;?>" rel="load-content" data-panel="#direita" ><?=$status->status?></a>
        
        </li>
        <?}?>
    </ul>
</div>