<label><b>editar tarefa</b></label><hr/>
<form name="frmCreateTask2" id="frmCreateTask2"  data-panel="#direita" action="<?=URL::base();?>admin/tasks/salvar/<?=@$taskVO['id']?>" method="post" class="form">
	
	<input type="hidden" name="object_id" value="<?=@$taskVO['object_id']?>">
	<input type="hidden" name="status_id" value="5">
    <input type="hidden" name="object_status_id" value="<?=@$taskVO['object_status_id']?>">
	<dl>
		<div class="left">
			<dt>
	            <label for="tag_id">tarefas</label>
	        </dt>
	        <dd>
	            <select name="tag_id" id="tag_id" class="round" style="width:150px;" data-server="<?=URL::base();?>admin/tasks/setDate/">
	                <option value="0">selecione</option>
	                <? foreach($tagList as $tag){?>
	                    <option value="<?=$tag->id?>" data-days="<?=$tag->days?>" <?=($taskVO['tag_id'] == $tag->id) ? "selected" : ""?> ><?=$tag->tag?></option>
	                <?}?>
	            </select>
	            <span class='error'><?=Arr::get(@$errors, 'tag_id');?></span>
	        </dd>
	    </div>  
        <div class="left">  
    		<dt>
                <label for="crono_date">retorno para:</label>
            </dt>
            <dd>
                <input type="text" name="crono_date" id="crono_date" class="required round date" style="width:100px;" value="<?=@$taskVO['crono_date']?>" />
                <span class='error'><?=Arr::get($errors, 'crono_date');?></span>
            </dd>
        </div>	
        <div class="left">  
            <dt>
                <label for="task_to">para:</label>
            </dt>
            <dd>
                <select name="task_to" id="task_to" class="round" style="width:150px;">
                    <option value="0">selecione</option>
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
                  <textarea class="text required round" name="description" id="description" style="width:420px; height:300px;"><?=@$taskVO['description']?></textarea>
                  <span class='error'><?=Arr::get($errors, 'description');?></span>
            </dd>
        </div>
        <!--input type="checkbox" name="sendmail" id="sendmail" value="1"><label for="sendmail">enviar e-mail de atualização</label-->
        <dd>
          <input type="submit" class="round green" value="salvar" />  
          <a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a>                  
        </dd>	    
	</dl>
</form>