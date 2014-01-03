<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks" class="bar_button round">Voltar</a>
		<a href="<?=URL::base().'admin/tasks/edit/'.$taskVO['id'];?>" class="bar_button round">Editar</a>
	</div>
	<ul>
	<?
		if(isset($projectStepsList)){
			foreach($projectStepsList as $step){
				echo '<li class="stepList">'.$step->step.'</li>';
			}	
		}
	?>
	</ul>
	<form name="frmTask" id="frmTask" method="post" class="form" enctype="multipart/form-data">
		<dl>
			<dt>
           		<h1><?=@$taskVO["title"]?></h1><br/>
           		<b>taxonomia:</b> <?=@$taskVO["taxonomia"]?><br/>
                <b>para:</b> <?=@$taskVO['crono_date']?><br/>
			</dt>
			<dd>
				<input type="hidden" name="title" id="title" value="<?=@$taskVO["title"]?>"/>
				<input type="hidden" name="project_id" id="project_id" value="<?=@$taskVO["project_id"]?>"/>
				<input type="hidden" name="crono_date" id="crono_date" value="<?=@$taskVO['crono_date']?>"/>
				<input type="hidden" name="pasta" id="pasta" value="<?=@$taskVO['pasta']?>"/>
		      	<input type="hidden" name="user_id" id="user_id" value="<?=@$taskVO['userInfo_id']?>"/>
			</dd>
            <hr>
            <dt>
            	<label for="description">Passo:</label>
            </dt>
            <dd>
            	<select name='step'>
            <?
				if(isset($projectStepsList)){
					foreach($projectStepsList as $step){
						echo '<option value="'.$step->id.'">'.$step->step.'</option>';
					}	
				}
			?>
				</select>
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
