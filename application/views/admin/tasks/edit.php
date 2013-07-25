<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks" class="bar_button round">Voltar</a>
	</div>
	<form name="frmTask" id="frmTask" method="post" class="form" enctype="multipart/form-data">
		<dl>
			<dt>
           		<?=@$taskVO["title"]?><br/>
                <b>para:</b> <?=@$taskVO['crono_date']?><br/>
                <b>prioridade:</b> <?=@$taskVO['priority']?><br/>
                <b>solicitada por:</b> <?=$taskflows[0]->userInfo->nome;?>
                
			</dt>
			<dd>
				<input type="hidden" name="title" id="title" value="<?=@$taskVO["title"]?>"/>
				<input type="hidden" name="project_id" id="project_id" value="<?=@$taskVO["project_id"]?>"/>
				<input type="hidden" name="crono_date" id="crono_date" value="<?=@$taskVO['crono_date']?>"/>
				<input type="hidden" name="pasta" id="pasta" value="<?=@$taskVO['pasta']?>"/>
		      	<input type="hidden" name="user_id" id="user_id" value="<?=@$taskVO['userInfo_id']?>"/>
		      	<input type="hidden" name="priority_id" id="priority_id" value="<?=@$taskVO['priority_id']?>"/>
			</dd>
            <hr>
			<dt>
				<b>descrição</b><br/>
				<?=$taskflows[0]->description;?>
			</dt>
		    <?=$anexosView?>
		    <dt>
                <label for="statu_id">status atual:</label>
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
            <dt>
            	<label for="description">observações</label>
            </dt>
            <dd>
                  <textarea class="text round" name="description" id="description" style="width:500px; height:200px;"></textarea>
                  <span class='error'><?=Arr::get($errors, 'description');?></span>
            </dd>
            <dd>
              <input type="submit" class="round" name="btnSubmit" id="btnSubmit" data-form="frmTask" value="<?=(@$isUpdate) ? 'Salvar' : 'Criar'?>" />
            </dd>	    
		</dl>
	</form>
	<div class='right'>	
            <span class="header" style="margin-left:5px;">histórico</span>
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
