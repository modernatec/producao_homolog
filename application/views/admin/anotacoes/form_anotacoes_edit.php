<div class="header">
    <div class="left icon icon_task_white">tarefas</div>
    <span>Anotações</span>
</div>
  <form name="frmAnotacoes" id="frmAnotacoes_edit" data-panel="#direita" action="<?=URL::base();?>admin/anotacoes/edit/<?=@$anotacao_txt->id?>" method="post" class="form">
  	<input type="hidden" name="object_id" value="<?=$object_id?>">
    <input type="hidden" name="object_status_id" value="<?=$status_id?>">
  	<dl>
        <dd>
          <textarea class="required text round" name="anotacao" id="description" style="width:420px; height:100px;"><?=@$anotacao_txt->anotacao?></textarea>
          <span class='error'><?=Arr::get($errors, 'anotacao');?></span>
        </dd>
        <dd>
          <input type="submit" class="round" name="btnCriar" id="btnCriar" data-form="frmAnotacoes" value="salvar" />             
          <a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a>  
        </dd>	    
  	</dl>
  </form>