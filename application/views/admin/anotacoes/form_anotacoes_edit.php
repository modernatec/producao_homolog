<div class="header">
    <a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white" title="fechar">fechar</div>
    </a>
    <span>Nova anotação</span>

</div>

<div class="left panel_content" style="min-width:478px;">
  <form name="frmAnotacoes_edit" id="frmAnotacoes_edit" data-panel="#direita" action="<?=URL::base();?>admin/anotacoes/edit/<?=@$anotacao->id?>" method="post" class="form">
  	<input type="hidden" name="object_id" value="<?=$object_id?>">
    <input type="hidden" name="object_status_id" value="<?=$status_id?>">
  	<dl>
        <dd>
          <textarea class="required text round" name="anotacao" id="anotacao" style="width:420px; height:100px;"><?=@$anotacao->anotacao?></textarea>
          <span class='error'><?=Arr::get($errors, 'anotacao');?></span>
        </dd>
        <dd>
          <input type="submit" class="bar_button round" name="btnCriar" id="btnCriar" value="salvar" />             
          <!--a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a-->  
        </dd>	    
  	</dl>
  </form>
</div>