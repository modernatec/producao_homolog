<div class="list_bar">
	<a href="<?=URL::base();?>admin/workflows/edit/" class="popup bar_button round">cadastrar workflow</a>
</div>
<span class='list_alert'>
<?
    if(count($workflowList) <= 0){
        echo 'não encontrei workflows com estes critérios';    
    }else{
        echo count($workflowList).' workflows encontrados';
    }
?>
</span>
<div class="scrollable_content">	
	<ul class="list_item">
		<? foreach($workflowList as $workflow){?>
		<li>
			<a class="right icon icon_excluir" href="<?=URL::base().'admin/workflows/delete/'.$workflow->id;?>" title="Excluir">Excluir</a>
			<div class="item_content">
				<a style='display:block' href="<?=URL::base().'admin/workflows/edit/'.$workflow->id;?>" class="popup" title="Editar"><?=$workflow->name?></a>
			</div>
		</li>
		<?}?>
	</ul>
</div>

