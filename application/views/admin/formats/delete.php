<div class="header">
	<a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white" >fechar</div>
    </a>
    <span><?=$delete_msg?></span>
</div>
<div class="left panel_content" style="min-width:478px;">
	<p class="round panel_gray"><?=$format->name?></p>
	<br/>
	
	<p><b>Atenção!</b></p>
	<p>Este formato final possuí <label><?=$total_objects?> OED</label>, é necessário movê-los para outro formato:</p>
	<form name="frmDeleteFormat" id="frmDeleteFormat"  data-panel="#direita" action="<?=URL::base();?>admin/formats/delete/<?=$format->id?>" method="post" class="form">
		<div>
            <dd>
	            <select name="format_id" id="format_id" class="required round" style="width:300px;" >
	                <option value="">selecione</option>
	                <? foreach($formatList as $format){?>
	                    <option value="<?=$format->id?>" ><?=$format->name?></option>
	                <?}?>
	            </select>
	            <span class='error'><?=Arr::get($errors, 'format_id');?></span>
	        </dd>				        
		</div>
        <dd>
          <input type="submit" class="round bar_button left" name="btnCriar" id="btnCriar" value="confirmar exclusão" />             
        </dd>	    
	</form>
</div>