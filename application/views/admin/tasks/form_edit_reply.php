<label><b>editar tarefa</b></label><hr/>
<form name="frmEditTask" id="frmEditTask" action="<?=URL::base();?>admin/tasks/edit/<?=@$taskVO['id']?>" method="post" class="form">
	
	<input type="hidden" name="object_id" value="<?=@$taskVO['object_id']?>">
	<input type="hidden" name="status_id" value="<?=@$taskVO['status_id']?>">
    <input type="hidden" name="topic" value="<?=@$taskVO['topic']?>">
    <input type="hidden" name="task_to" value="<?=@$taskVO['task_to']?>">
    <input type="hidden" name="task_id" value="<?=@$taskVO['task_id']?>">
	<dl>
        <div class="clear">		
            <dt>
            	<label for="description">observações</label>
            </dt>
            <dd>
                  <textarea class="text round" name="description" id="description" style="width:600px; height:70px;"><?=@$taskVO['description']?></textarea>
                  <span class='error'><?=Arr::get($errors, 'description');?></span>
            </dd>
        </div>
        <dd>
          <input type="submit" class="round" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="salvar" />             
        </dd>	    
	</dl>
</form>