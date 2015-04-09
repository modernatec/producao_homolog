<form name="frmEditTask" id="frmEditTask"  data-panel="#direita" action="<?=URL::base();?>admin/taskstatus/edit/<?=@$taskVO['id']?>" method="post" class="form">
	<dl>
        <div class="clear">		
            <dd>
                  <textarea class="text round" name="description" id="description" placeholder="observações" style="width:550px; height:300px;"><?=@$taskVO['description']?></textarea>
                  <span class='error'><?=Arr::get($errors, 'description');?></span>
            </dd>
        </div>
        <dd>
          <input type="submit" class="round green" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="salvar" />
          <a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a>             
        </dd>	    
	</dl>
</form>