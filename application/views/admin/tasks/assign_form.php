<div class="boxwired round" style="overflow:auto">
		<form name="frmTask" id="frmTask" action="<?=URL::base();?>admin/tasks/assign/<?=$obj->id?>" method="post" class="form" enctype="multipart/form-data">
			
			<dl>
			    <div class="left">
					<dt>
			            <label for="status_id">status:</label>
			        </dt>
			        <dd>
			            <select name="status_id" id="status_id" style="width:150px;">
			                <option value="">selecione</option>
			                <? foreach($statusList as $status){?>
			                    <option value="<?=$status->id?>" ><?=$status->status?></option>
			                <?}?>
			            </select>
			            <span class='error'><?=Arr::get($errors, 'status_id');?></span>
			        </dd>				        
				</div>
				<div>
					<dt>
			            <label for="crono_date">retorno para:</label>
			        </dt>
			        <dd>
			            <input type="text" name="crono_date" id="crono_date" class="round date" style="width:100px;" />
			            <span class='error'><?=Arr::get($errors, 'crono_date');?></span>
			        </dd>
				</div>
				<dt>
		            <label for="topic">assunto:</label>
		        </dt>
		        <dd>
		            <input type="text" name="topic" id="topic" class="round" style="width:400px;" />
		            <span class='error'><?=Arr::get($errors, 'statu_id');?></span>
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
	            </dd>	    
			</dl>
		</form>
		</div>