<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks" class="bar_button round">Voltar</a>
	</div>
	<?	
		$title = ($task->title) ? ($task->title) : (Arr::get($values, 'title'));
        $description = ($statusHist[0]->description) ? ($statusHist[0]->description) : (Arr::get($values, 'description'));
        $crono_date = ($task->crono_date) ? ($task->crono_date) : (Arr::get($values, 'crono_date'));

        $status_id = ($statusHist[0]->status_id) ? ($statusHist[0]->status_id) : (Arr::get($values, 'statu_id'));

        $project_id = ($task->project_id) ? ($task->project_id) : (Arr::get($values, 'project_id'));
        $user_id = ($task->user_id) ? ($task->user_id) : (Arr::get($values, 'user_id'));
        $priority_id = ($task->priority_id) ? ($task->priority_id) : (Arr::get($values, 'priority_id'));
        $pasta = ($task->pasta) ? ($task->pasta) : (Arr::get($values, 'pasta'));
    ?>   

	<form name="frmTask" id="frmTask" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	  	<dt>
	      <label for="project_id">projeto</label>
	    </dt>
	    <dd>
	      <select name="project_id" id="project_id" style="width:150px;">
	     	<option value="">selecione</option>
	      	<?foreach($projectList as $project){?>
	      	<option value="<?=$project->id?>" <?=($project->id == $project_id) ? 'selected' : ''?>><?=$project->name?></option>
	      	<?}?>
	      </select>
	      <span class='error'><?=($errors) ? $errors['project_id'] : '';?></span>
	    </dd>
	    <dt>
	      <label for="title">título</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="title" id="title" style="width:500px;" value="<?=$title?>"/>
	      <span class='error'><?=Arr::get($errors, 'title');?></span>
	    </dd>
	    <dt>
	      <label for="crono_date">data de entrega</label>
	    </dt>
	    <dd>
                <input type="text" class="text round" name="crono_date" id="crono_date" style="width:100px;"  value="<?=Utils_Helper::data($crono_date)?>"/>
	      <span class='error'><?=Arr::get($errors, 'crono_date');?></span>
	    </dd>
	    <dt>
	      <label for="pasta">pasta</label>
	    </dt>
	    <dd>
                <input type="text" class="text round" name="pasta" id="pasta" style="width:500px;"  value="<?=$pasta?>"/>
	      <span class='error'><?=Arr::get($errors, 'pasta');?></span>
	    </dd>
	    <dt>
	      <label for="task_to">usuário responsável</label>
	    </dt>
	    <dd>
	      <select name="task_to" id="task_to" style="width:150px;">
	     	<option value="">selecione</option>
	      	<?foreach($usersList as $user){?>
	      	<option value="<?=$user->id?>" <?=($user->id == $user_id) ? 'selected' : ''?>><?=$user->userInfos->nome?></option>
	      	<?}?>
	      </select>
	      <span class='error'><?=($errors) ? $errors['task_to'] : '';?></span>
	    </dd>
	    <dt>
	      <label for="priority_id">prioridade</label>
	    </dt>
	    <dd>
	      <select name="priority_id" id="priority_id" style="width:150px;">
	      	<option value="">selecione</option>
	      	<?foreach($priorityList as $priority){?>
	      	<option value="<?=$priority->id?>" <?=($priority->id == $priority_id) ? 'selected' : ''?>><?=$priority->priority?></option>
	      	<?}?>
	      </select>
	      <span class='error'><?=Arr::get($errors, 'priority_id');?></span>
	    </dd>
	    <?
	    	echo View::factory('admin/tasks/status_task')
	        					->bind('statusList', $statusList)
	        					->bind('status_task', $taskflows[0])
	        					->bind('isUpdate', $isUpdate)
	        					->bind('usersList', $usersList);
		?>	
	  </dl>
	</form>
	<div class='right'>	
	<?
		echo '<span class="header" style="margin-left:5px;">histórico</span>';

		foreach($taskflows as $status_task){
	    	echo View::factory('admin/tasks/hist_task')
        					->bind('statusList', $statusList)
        					->bind('status_task', $status_task);
        }
	?>
	</div>
</div>
