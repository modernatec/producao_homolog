<dt>
  	<label for="statu_id"><b>status atual: </b> </label>
</dt>
<dd>
  	<select name="statu_id" id="statu_id" style="width:150px;">
 		<option value="">selecione</option>
  		<?foreach($statusList as $status){?>
  			<option value="<?=$status->id?>" <?=($status->id == $status_task->status_id) ? 'selected' : ''?>><?=$status->status?></option>
  		<?}?>
  	</select>
	<input type='hidden' name='status_task_id' value='<?=$status_task->id?>'/>
  	<input type='hidden' name='old_status' value='<?=$status_task->status_id?>'/>
  	<span class='error'><?=($errors) ? $errors['project_id'] : '';?></span>
</dd>
<dt>
  	<label for="description">descrição</label>
</dt>
<dd>
  <textarea class="text round" name="description" id="description" style="width:500px; height:200px;"></textarea>
  <span class='error'><?=Arr::get($errors, 'description');?></span>
</dd>
<dd>
  <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<?=($isUpdate) ? 'Salvar' : 'Criar'?>" />
</dd>