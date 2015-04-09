<label><b>anotações</b></label><hr/>
  <form name="frmAnotacoes" id="frmAnotacoes_edit" data-panel="#direita" action="<?=URL::base();?>admin/anotacoes/edit/<?=@$anotacao_txt->id?>" method="post" class="form" enctype="multipart/form-data">
  	<input type="hidden" name="object_id" value="<?=$object_id?>">
    <input type="hidden" name="object_status_id" value="<?=$status_id?>">
  	<dl>
        <dd>
          <textarea class="required text round" name="anotacao" id="anotacao" style="width:490px; height:100px;"><?=@$anotacao_txt->anotacao?></textarea>
          <span class='error'><?=Arr::get($errors, 'anotacao');?></span>
        </dd>
        <dd>
          <input type="submit" class="round green" name="btnCriar" id="btnCriar" data-form="frmAnotacoes" value="salvar" />             
          <a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a>  
        </dd>	    
  	</dl>
  </form>