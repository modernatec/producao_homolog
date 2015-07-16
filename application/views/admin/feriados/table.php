<div class="bar" style='margin-bottom:5px;'>
	<a href="<?=URL::base();?>admin/feriados/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar feriado</a>
</div>
<div class="scrollable_content">
    <ul class="list_item">
        <? foreach($feriadosList as $feriado){?>
        <li>
            <div class="left">
                <a style='display:block' href="<?=URL::base().'admin/feriados/edit/'.$feriado->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=Utils_Helper::data($feriado->data).' - '.$feriado->feriado?></a>
            </div>
            <div class="right">
                <a class="excluir" href="<?=URL::base().'admin/feriados/delete/'.$feriado->id;?>" title="Excluir">Excluir</a>
            </div>  
        </li>
        <?}?>
    </ul>
</div>