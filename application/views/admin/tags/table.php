<div class="list_bar">
	<a href="<?=URL::base();?>admin/tags/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar tarefa</a>
</div>
<span class='list_alert'>
    <?
        if(count($list) <= 0){
            echo 'não encontrei tarefas com estes critérios';    
        }else{
            echo count($list).' tarefas encontradas';
        }
    ?>
    </span>
<div class="scrollable_content">
	<ul class="list_item sortable_tags">
        <? foreach($list as $tag){?>
        <li class="dd-item" id="item-<?=$tag->id?>">
            <a class="right icon icon_excluir" href="<?=URL::base().'admin/tags/delete/'.$tag->id;?>" title="Excluir">Excluir</a>
            <div class="item_content">
	            <span class="left ball" style="background:<?=$tag->color;?>"></span>
	            <a style='display:block' href="<?=URL::base().'admin/tags/edit/'.$tag->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$tag->tag?></a>
	        </div>
        </li>
        <?}?>
    </ul>
</div>