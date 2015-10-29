<div class="list_bar" >
	<a href="<?=URL::base();?>admin/status_objects/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar status</a>
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
        <? foreach($statusList as $status){
            $qtd_objects = $status->objects->count_all();
        ?>
        <li class="dd-item" id="item-<?=$status->id?>">
            <?if($qtd_objects > 0){?>
                <a class="right icon icon_excluir popup" href="<?=URL::base().'admin/status_objects/deletePanel/'.$status->id;?>">Excluir</a>
            <?}else{?>
                <a class="right icon icon_excluir" href="<?=URL::base().'admin/status_objects/delete/'.$status->id;?>" data-message="<?=$delete_msg?>">Excluir</a>
            <?}?>
            <a style='display:block' href="<?=URL::base().'admin/status_objects/edit/'.$status->id;?>" rel="load-content" data-panel="#direita" ><b><?=$status->status?></b></a>
            <p class="subtitle"><?=$qtd_objects?> OED</p>
        
        </li>
        <?}?>
    </ul>
</div>