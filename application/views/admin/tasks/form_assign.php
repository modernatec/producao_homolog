<div class="boxwired round hide" id="form_assign" style="overflow:auto">
	<label><b>nova tarefa</b></label><hr/>
	<form name="frmCreateTask" id="frmCreateTask" action="<?=URL::base();?>admin/tasks/assign" method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="object_id" value="<?=$obj->id?>">
		<input type="hidden" name="status_id" value="5">
		<dl>
			<div class="left">
				<dt>
		            <label for="topic">assunto:</label>
		        </dt>
		        <dd>
		            <input type="text" name="topic" id="topic" class="required round" style="width:300px;" />
		            <span class='error'><?=Arr::get($errors, 'statu_id');?></span>
		        </dd>
		    </div>  
		    <div class="left">  
				<dt>
		            <label for="crono_date">retorno para:</label>
		        </dt>
		        <dd>
		            <input type="text" name="crono_date" id="crono_date" class="required round date" style="width:100px;" />
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
		                    <option value="<?=$userInfo->id?>" ><?=$userInfo->nome?></option>
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
	                  <textarea class="text required round" name="description" id="description" style="width:600px; height:70px;"></textarea>
	                  <span class='error'><?=Arr::get($errors, 'description');?></span>
	            </dd>
	            <dd>
	              <input type="submit" class="round" name="btnCriar" id="btnCriar" data-form="frmTask" value="criar" />
	              <input type="button" class="round cancel" name="btnCancel" id="btnCancel" data-show="form_assign"  value="cancelar" />
	              
	            </dd>
	        </div>	    
		</dl>
	</form>
</div>