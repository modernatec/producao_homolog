<div class="header">
	<a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white" >fechar</div>
    </a>
    <span><?=$delete_msg?></span>
</div>
<div class="left panel_content" style="min-width:478px;">
	<p class="round panel_gray"><?=$typeObject->name?></p>
	<br/>
	
	<p><b>Atenção!</b></p>
	<p>Esta tipologia possuí <label><?=$total_objects?> OED</label>, é necessário movê-los para outra tipologia:</p>
	<form name="frmDeleteTypeObject" id="frmDeleteTypeObject"  data-panel="#direita" action="<?=URL::base();?>admin/typeobjects/delete/<?=$typeObject->id?>" method="post" class="form">
		<div>
            <dd>
	            <select name="typeobject_id" id="typeobject_id" class="required round" style="width:300px;" >
	                <option value="">selecione</option>
	                <? foreach($typeList as $type){?>
	                    <option value="<?=$type->id?>" ><?=$type->name?></option>
	                <?}?>
	            </select>
	            <span class='error'><?=Arr::get($errors, 'typeobject_id');?></span>
	        </dd>				        
		</div>
        <dd>
          <input type="submit" class="round bar_button left" name="btnCriar" id="btnCriar" value="confirmar exclusão" />             
        </dd>	    
	</form>
</div>