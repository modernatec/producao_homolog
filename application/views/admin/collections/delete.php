<div class="header">
	<a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white" >fechar</div>
    </a>
    <span><?=$delete_msg?></span>
</div>
<div class="left panel_content" style="min-width:478px;">
	<p><?=$collection->name?></p>
	<p><b>Atenção!</b><br/>Esta coleção possuí <label><?=$total_objects?> OED</label>, é necessário movê-los para outra coleção:</p>
	<form name="frmDeleteCollection" id="frmDeleteCollection"  data-panel="#direita" action="<?=URL::base();?>admin/collections/delete/<?=$collection->id?>" method="post" class="form">
		<div>
            <dd>
	            <select name="collection_id" id="collection_id" class="required round" style="width:300px;" >
	                <option value="">selecione</option>
	                <? foreach($collectionList as $collection){?>
	                    <option value="<?=$collection->id?>" ><?=$collection->name?></option>
	                <?}?>
	            </select>
	            <span class='error'><?=Arr::get($errors, 'collection_id');?></span>
	        </dd>				        
		</div>
        <dd>
          <input type="submit" class="round bar_button left" name="btnCriar" id="btnCriar" value="confirmar exclusão" />             
        </dd>	    
	</form>
</div>