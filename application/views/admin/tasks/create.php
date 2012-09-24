<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks" class="bar_button round">Voltar</a>
	</div>
	<?	
		$title = ($task->title) ? ($task->title) : (Arr::get($values, 'title'));
        $description = ($task->description) ? ($task->description) : (Arr::get($values, 'description'));
        $crono_date = ($task->crono_date) ? ($task->crono_date) : (Arr::get($values, 'crono_date'));

        $project_id = ($task->project_id) ? ($task->project_id) : (Arr::get($values, 'project_id'));
        $user_id = ($task->user_id) ? ($task->user_id) : (Arr::get($values, 'user_id'));
        $priority_id = ($task->priority_id) ? ($task->priority_id) : (Arr::get($values, 'priority_id'));
    ?>   

	<form name="frmTask" id="frmTask" method="post" class="form">
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
	      <input type="text" class="text round" name="crono_date" id="crono_date" style="width:100px;"  value="<?=$crono_date?>"/>
	      <span class='error'><?=Arr::get($errors, 'crono_date');?></span>
	    </dd>
	    <dt>
	      <label for="user_id">usuário responsável</label>
	    </dt>
	    <dd>
	      <select name="user_id" id="user_id" style="width:150px;">
	     	<option value="">selecione</option>
	      	<?foreach($usersList as $user){?>
	      	<option value="<?=$user->id?>" <?=($user->id == $user_id) ? 'selected' : ''?>><?=$user->name?></option>
	      	<?}?>
	      </select>
	      <span class='error'><?=($errors) ? $errors['user_id'] : '';?></span>
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
	    <dt>
	      <label for="description">descrição</label>
	    </dt>
	    <dd>
	      <textarea class="text round" name="description" id="description" style="width:500px; height:200px;"><?=$description;?></textarea>
	      <span class='error'><?=Arr::get($errors, 'description');?></span>
	    </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="Criar" />
	    </dd>
	  </dl>
	</form>
</div>
