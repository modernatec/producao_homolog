<form name="frmEditTask" id="frmEditTask" action="<?=URL::base();?>admin/taskstatus/edit/<?=@$taskVO['id']?>" method="post" class="form">
	<dl>
        <div class="clear">		
            <dd>
                  <textarea class="text round" name="description" id="description" placeholder="observações" style="width:600px; height:70px;"><?=@$taskVO['description']?></textarea>
                  <span class='error'><?=Arr::get($errors, 'description');?></span>
            </dd>
        </div>
        <dd>
          <input type="submit" class="round" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="salvar" />             
        </dd>	    
	</dl>
</form>