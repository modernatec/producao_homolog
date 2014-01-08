<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks" class="bar_button round">Voltar</a>
	</div>
	<form name="frmTask" id="frmTask" method="post" class="form" enctype="multipart/form-data">
	  <dl>
	  	<dt>
	      	<label for="project_id">projeto</label>
	    </dt>
	    <dd>
        	<input type="hidden" name="project_id" id="project_id" value="<?=@$taskVO["project_id"]?>"/>
            <?=@$taskVO["project_name"]?>
	    </dd>
	    <dt>
	      	<label for="title">título</label>
	    </dt>
	    <dd>
        	<input type="hidden" name="title" id="title" value="<?=@$taskVO["title"]?>"/>
            <?=@$taskVO["title"]?>
	    </dd>
        <dt>
	      	<label for="pasta">taxonomia</label>
	    </dt>
	    <dd>
        	<input type="hidden" name="pasta" id="pasta" width="100" value="<?=@$taskVO["pasta"]?>"/>
            <?=@$taskVO["pasta"]?>
	    </dd>
	    <dt>
	      	<label for="crono_date">data de entrega</label>
	    </dt>
	    <dd>
           	<input type="text" class="text round" name="crono_date" id="crono_date" style="width:100px;"  value="<?=@$taskVO['crono_date']?>"/>
	      	<span class='error'><?=Arr::get($errors, 'crono_date');?></span>
	    </dd>
        <dt>
	      <label for="team">equipe responsável</label>
	    </dt>
	    <dd>
	      <select name="team" id="team" style="width:150px;" onchange="getUsersByEquipe(this.value)">
	     	<option value="">selecione</option>
	      	<? foreach($teamsList as $team){?>
		      	<option value="<?=$team->id?>" <?=((@$taskVO["team_id"] == $team->id)?('selected'):(''))?> ><?=$team->name?></option>
	      	<? }?>
	      </select>
	      <span class='error'><?=($errors) ? $errors['task_to'] : '';?></span>
	    </dd>
	    <dt>
	      <label for="task_to">usuário responsável</label>
	    </dt>
	    <dd>
	      <select name="task_to" id="task_to" style="width:150px;">
	     	<option value="">Selecione</option>	  
            <? 
				if(isset($taskVO["equipeUsers"])){
					foreach($taskVO["equipeUsers"] as $userInfo){?>
					<option value="<?=$userInfo->id?>" <?=((@$taskVO["userInfo_id"] == $userInfo->id)?('selected'):(''))?> ><?=$userInfo->nome?></option>
	      	<? }}?>   	
	      </select>
          
	      <span class='error'><?=($errors) ? $errors['task_to'] : '';?></span>
	    </dd>
	    <dt>
	      <label for="priority_id">prioridade</label>
	    </dt>
	    <dd>
	      <select name="priority_id" id="priority_id" style="width:150px;">
	      	<option value="">selecione</option>
	      	<? foreach($priorityList as $priority){?>
	      	<option value="<?=$priority->id?>" <?=((@$taskVO["priority_id"] == $priority->id)?('selected'):(''))?> ><?=$priority->priority?></option>
	      	<? }?>
	      </select>
	      <span class='error'><?=Arr::get($errors, 'priority_id');?></span>
	    </dd>
        
        <dt>
            <label for="statu_id"><b>status atual: </b> </label>
        </dt>
        <dd>
            <select name="statu_id" id="statu_id" style="width:150px;">
                <option value="">selecione</option>
                <? foreach($statusList as $status){?>
                    <option value="<?=$status->id?>" ><?=$status->status?></option>
                <?}?>
            </select>
            <span class='error'><?=($errors) ? $errors['statu_id'] : '';?></span>
        </dd>
        <?=$anexosView?>
        <dt>
            <label for="description">descrição</label>
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