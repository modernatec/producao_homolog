<div class="bar" style='margin-bottom:5px;'>
	<a href="<?=URL::base();?>admin/services/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar serviço</a>
</div>
<div class="scrollable_content">
	<ul class="list_item">
        <? foreach($list as $service){?>
        <li>
            <div class="left">
                <a style='display:block' href="<?=URL::base().'admin/services/edit/'.$service->id;?>" rel="load-content" data-panel="#direita" title="Editar"><?=$service->name?></a>
            </div>
            <div class="right">
                <a class="excluir" href="<?=URL::base().'admin/services/delete/'.$service->id;?>" title="Excluir">Excluir</a>
            </div>  
        </li>
        <?}?>
    </ul>
</div>