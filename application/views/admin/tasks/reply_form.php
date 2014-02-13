<div class="boxwired round" style="overflow:auto">
		<form name="frmTask" id="frmTask" action="<?=URL::base();?>admin/tasks/assign_reply/<?=$task->object_id?>" method="post" class="form" enctype="multipart/form-data">
			
			<input type="hidden" name="task_to" value="<?=@$task->userInfo_id?>"/>
			<input type="hidden" name="status_id" value="9"/>
			<input type="hidden" name="topic" value="<?=@$task->topic?>"/>
			<input type="hidden" name="task_id" value="<?=@$task->id?>"/>
			<input type="hidden" name="crono_date" value="<?=date("d-m-Y")?>"/>
			<dl>
	            <dt>
	            	<label for="description">observações</label>
	            </dt>
	            <dd>
	                  <textarea class="text round" name="description" id="description" style="width:600px; height:70px;"></textarea>
	                  <span class='error'><?=Arr::get($errors, 'description');?></span>
	            </dd>
	            <dd>
	              <input type="submit" class="round" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="responder" />
	            </dd>	    
			</dl>
		</form>
		</div>