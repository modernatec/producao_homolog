<div class="header">
    <a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white" title="fechar">fechar</div>
    </a>
    <span>Editar resposta</span>

</div>

<div class="left panel_content" style="min-width:478px;">
  <form name="frmEditTask" id="frmEditTask" data-panel="#direita" action="<?=URL::base();?>admin/tasks_status/edit/<?=@$taskVO['id']?>" method="post" class="form">
  	<dl>
          <div class="clear">		
              <dd>
                    <textarea class="text round" name="description" id="description" placeholder="observações"  style="width:420px; height:300px;"><?=@$taskVO['description']?></textarea>
                    <span class='error'><?=Arr::get($errors, 'description');?></span>
              </dd>
          </div>
          <dd>
            <input type="submit" class="bar_button round" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="salvar" />
            <!--a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a-->
          </dd>	    
  	</dl>
  </form>
</div>