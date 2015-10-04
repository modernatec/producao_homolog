<div class="list_bar" >
	<a href="<?=URL::base();?>admin/feriados/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar feriado</a>
</div>
<span class='list_alert'>
    <?
        if(count($feriadosList) <= 0){
            echo 'não encontrei feriados com estes critérios';    
        }else{
            echo count($feriadosList).' feriados encontrados';
        }
    ?>
    </span>
<div class="scrollable_content">
    <ul class="list_item">
        <? foreach($feriadosList as $feriado){?>
        <li>
            <a class="right icon icon_excluir" href="<?=URL::base().'admin/feriados/delete/'.$feriado->id;?>" title="Excluir">Excluir</a>
            <div class="item_content">
                <a style='display:block' href="<?=URL::base().'admin/feriados/edit/'.$feriado->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=Utils_Helper::data($feriado->data).' - '.$feriado->feriado?></a>
            </div>
        </li>
        <?}?>
    </ul>
</div>