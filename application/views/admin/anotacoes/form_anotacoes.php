<div class="hist task round hide" id="form_anotacoes" >
  <form name="frmAnotacoes" id="frmAnotacoes" data-panel="#direita" action="<?=URL::base();?>admin/anotacoes/edit/<?=@$anotacao_txt->id?>" method="post" class="form" enctype="multipart/form-data">
  	<input type="hidden" name="object_id" value="<?=$obj->id?>">
    <input type="hidden" name="object_status_id" value="<?=$object_status->id?>">
  	<dl>
        <dd>
          <textarea class="required text round" name="anotacao" placeholder="anotações" id="anotacao" style="width:470px; height:100px;"></textarea>
        </dd>
        <dd>
          <input type="submit" class="round" name="btnCriar" id="btnCriar" data-form="frmAnotacoes" value="criar" /> 
          <input type="button" class="round cancel" name="btnCancel" id="btnCancel" data-show="form_anotacoes"  value="cancelar" />            
        </dd>	    
  	</dl>
  </form>
</div>