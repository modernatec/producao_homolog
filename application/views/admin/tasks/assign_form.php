<div class="boxwired round hide" id="form_assign" style="overflow:auto">
	<label><b>nova tarefa</b></label><hr/>
	<form name="frmTask" id="frmTask" action="<?=URL::base();?>admin/tasks/assign" method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="object_id" value="<?=$obj->id?>">
		<input type="hidden" name="status_id" value="5">
		<dl>
			<div class="left">
				<dt>
		            <label for="topic">assunto:</label>
		        </dt>
		        <dd>
		            <input type="text" name="topic" id="topic" class="round" style="width:400px;" />
		            <span class='error'><?=Arr::get($errors, 'statu_id');?></span>
		        </dd>
		    </div>    
			<dt>
	            <label for="crono_date">retorno para:</label>
	        </dt>
	        <dd>
	            <input type="text" name="crono_date" id="crono_date" class="round date" style="width:100px;" />
	            <span class='error'><?=Arr::get($errors, 'crono_date');?></span>
	        </dd>			
            <dt>
            	<label for="description">observações</label>
            </dt>
            <dd>
                  <textarea class="text round" name="description" id="description" style="width:600px; height:70px;"></textarea>
                  <span class='error'><?=Arr::get($errors, 'description');?></span>
            </dd>
            <dd>
              <input type="submit" class="round" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="criar" />
              <input type="button" class="round cancel" name="btnCancel" id="btnCancel" data-show="form_assign"  value="cancelar" />
              
            </dd>	    
		</dl>
	</form>
</div>