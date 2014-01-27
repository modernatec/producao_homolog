<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks" class="bar_button round">Voltar</a>

	</div>
	
	<div class="box round left">
   		<b>título:</b> <?=@$objVO["title"]?><br/>
   		<b>taxonomia:</b> <?=@$objVO["taxonomia"]?><br/>
		<b>obs:</b> <?=@$taskVO['sinopse']?><br/>
	</div>
	<div class="left">
		<div class="boxwired round" style="overflow:auto">
		<form name="frmTask" id="frmTask" method="post" class="form" enctype="multipart/form-data">
			<input type="hidden" name="pasta" id="pasta" value="<?=@$taskVO['pasta']?>"/>
	      	<input type="hidden" name="user_id" id="user_id" value="<?=@$taskVO['userInfo_id']?>"/>
			<dl>
				<div class="left">
					<dt>
			            <label for="step">ação:</label>
			        </dt>
			        <dd>
			            <select name="step" id="step" style="width:150px;">
			                <option value="">selecione</option>
			                <? foreach($stepList as $step){?>
			                    <option value="<?=$step->id?>" ><?=$step->step?></option>
			                <?}?>
			            </select>
			            <span class='error'><?=Arr::get($errors, 'statu_id');?></span>
			        </dd>	
			    </div>
				<div class="left">
			        <dt>
			        	<label for="task_to">usuário responsável</label>
			        </dt>
			        <dd>
						<select name="task_to" id="task_to" style="width:150px;">
							<option value="">Selecione</option>	  
						<? 
							if(isset($taskVO["equipeUsers"])){
								foreach($taskVO["equipeUsers"] as $userInfo){?>
								<option value="<?=$userInfo->id?>" ><?=$userInfo->nome?></option>
							<? }}?>   	
						</select>

						<span class='error'><?=($errors) ? $errors['task_to'] : '';?></span>
				    </dd>
			    </div>
			    <div>
					<dt>
			            <label for="statu_id">status:</label>
			        </dt>
			        <dd>
			            <select name="statu_id" id="statu_id" style="width:150px;">
			                <option value="">selecione</option>
			                <? foreach($statusList as $status){?>
			                    <option value="<?=$status->id?>" ><?=$status->status?></option>
			                <?}?>
			            </select>
			            <span class='error'><?=Arr::get($errors, 'statu_id');?></span>
			        </dd>	
			        
				</div>
	            <dt>
	            	<label for="description">observações</label>
	            </dt>
	            <dd>
	                  <textarea class="text round" name="description" id="description" style="width:600px; height:70px;"></textarea>
	                  <span class='error'><?=Arr::get($errors, 'description');?></span>
	            </dd>
	            <dd>
	              <input type="submit" class="round" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="<?=(@$isUpdate) ? 'Salvar' : 'Criar'?>" />
	            </dd>	    
			</dl>
		</form>
		</div>
		<div>	
			<?
				if(isset($taskflows)){
					foreach($taskflows as $status_task){
						echo View::factory('admin/tasks/hist_task')
							->bind('statusList', $statusList)
							->bind('status_task', $status_task)
							->bind('cntStsTsk', $cntStsTsk); 
					}	
				}
			?>
		</div>
	</div>	
	
</div>
