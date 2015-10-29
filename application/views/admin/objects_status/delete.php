<div class="header">
	<a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white" >fechar</div>
    </a>
    <span><?=$delete_msg?></span>
</div>
<div class="left panel_content" style="min-width:478px;">
	<p class="round panel_gray"><?=$status->status?></p>
	<br/>

	<p><b>Atenção!</b></p>
	<p>Este status possuí <label><?=$total_objects?> OED</label>, é necessário movê-los para outro status:</p>
	<form name="frmDeleteStatus" id="frmDeleteStatus"  data-panel="#direita" action="<?=URL::base();?>admin/status_objects/delete/<?=$status->id?>" method="post" class="form">
		<div>
            <dd>
	            <select name="status_id" id="status_id" class="required round" style="width:300px;" >
	                <option value="">selecione</option>
	                <? foreach($statusList as $status){?>
	                    <option value="<?=$status->id?>" ><?=$status->status?></option>
	                <?}?>
	            </select>
	            <span class='error'><?=Arr::get($errors, 'status_id');?></span>
	        </dd>				        
		</div>
        <dd>
          <input type="submit" class="round bar_button left" name="btnCriar" id="btnCriar" value="confirmar exclusão" />             
        </dd>	    
	</form>
</div>