<label><b>editar tarefa</b></label><hr/>
<form name="frmCreateTask2" id="frmCreateTask2" action="<?=URL::base();?>admin/tasks/edit/<?=@$taskVO['id']?>" method="post" class="form">
	
	<input type="hidden" name="object_id" value="<?=@$taskVO['object_id']?>">
	<input type="hidden" name="status_id" value="5">
	<dl>
		<div class="left">
			<dt>
	            <label for="topic">assunto:</label>
	        </dt>
	        <dd>
	            <input type="text" name="topic" id="topic" class="required round" style="width:300px;" value="<?=@$taskVO['topic']?>" />
	            <span class='error'><?=Arr::get($errors, 'statu_id');?></span>
	        </dd>
	    </div>  
        <div class="left">  
    		<dt>
                <label for="crono_date">retorno para:</label>
            </dt>
            <dd>
                <input type="text" name="crono_date" id="crono_date3" class="required round date" style="width:100px;" value="<?=@$taskVO['crono_date']?>" />
                <span class='error'><?=Arr::get($errors, 'crono_date');?></span>
            </dd>
        </div>	
        <div class="left">  
            <dt>
                <label for="task_to">para:</label>
            </dt>
            <dd>
                <select name="task_to" id="task_to" class="required round" style="width:150px;">
                    <option value="">selecione</option>
                    <? foreach($teamList as $userInfo){?>
                        <option value="<?=$userInfo->id?>" <?=($taskVO['task_to'] == $userInfo->id) ? "selected" : ""?> ><?=$userInfo->nome?></option>
                    <?}?>
                </select>
                <span class='error'><?=Arr::get($errors, 'task_to');?></span>
            </dd>
        </div>
        <div class="clear">		
            <dt>
            	<label for="description">observações</label>
            </dt>
            <dd>
                  <textarea class="text required round" name="description" id="description" style="width:600px; height:70px;"><?=@$taskVO['description']?></textarea>
                  <span class='error'><?=Arr::get($errors, 'description');?></span>
            </dd>
        </div>
        <input type="text" name="object_status_id" placeholder="id do status" value="<?=@$taskVO['object_status_id']?>" />
        <dd>
          <input type="submit" class="round" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="salvar" />             
        </dd>	    
	</dl>
</form>