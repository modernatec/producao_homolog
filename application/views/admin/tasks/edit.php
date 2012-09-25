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
		<dl>
			<dt>
				<label for="project_id"><b><?=$task->project->name?></b></label>
			</dt>
			<dd>
				<input type='hidden' name='project_id' value='<?=$task->project->id?>' />
			</dd>
			<dt>
				<label for="title"><?=$task->title?></label>
			</dt>
			<dd>
				<input type="hidden" name="title" id="title" value="<?=$task->title?>"/>
			</dd>
			<dt>
				<hr>
				<label for="crono_date"><b>data de entrega:</b> <?=Utils_Helper::data($task->crono_date)?></label>
			</dt>
			<dd>
				<input type="hidden" name="crono_date" id="crono_date" value="<?=$task->crono_date?>"/>
			</dd>
			<dt>
				<label for="pasta"><b>pasta:</b> <?=$pasta?></label>
			</dt>
			<dd>
				<input type="hidden" name="pasta" id="pasta" value="<?=$task->pasta?>"/>
			</dd>
	    	<dt>
	      		<label for="user_id"><b>criada por:</b> <?=$task->user->userInfos->nome?></label>
	    	</dt>
		    <dd>
		      	<input type="hidden" name="user_id" id="user_id" value="<?=$task->user->id?>"/>
		    </dd>
		    <dt>
		      	<label for="priority_id"><b>prioridade: </b> <?=$task->priority->priority?></label>
		    </dt>
		    <dd>
		      	<input type="hidden" name="priority_id" id="priority_id" value="<?=$task->priority->id?>"/>
		    </dd>
		    <dt>
		      	<label for="arquivo">Anexar arquivo</label>
		    </dt>	    
		    <dd>
		        <input type="file" class="text required round" name="arquivo" id="arquivo" style="width:300px;" />
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
		<span class="header" style="margin-left:5px;">histórico</span>
	<?
		foreach($taskflows as $status_task){
	    	echo View::factory('admin/tasks/hist_task')
        					->bind('statusList', $statusList)
        					->bind('status_task', $status_task);
        }
	?>
	</div>
</div>
