<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks/create" class="bar_button round">Criar tarefas</a>
	</div>
	<span class="header">tarefas</span>
	<table class="list">
		<thead>
                    <tr valign="bottom">
			<th>nome</th>
			<th>status atual</th>
			<th>
                        <?
                        if($showFiltro){
                        ?>
                        <select id="taks_to" name="task_to" onchange="window.location = '<?=URL::base();?>admin/tasks/filter/'+this.value">
                            <option value=''>Todos</option>
                            <?foreach($usersList as $user){?>
                            <option value="<?=$user->id?>" <?=($user->id == $task_to) ? 'selected' : ''?>><?=$user->userInfos->nome?></option>
                            <?}?>
                        </select>
                        <br/>
                        <?                         
                        }
                        ?>
                        responsável
                        </th>			
			<th>prioridade</th>
			<th>data de entrega</th>
                    </tr>
		</thead>
		<tbody>
                    <? foreach($taskList as $task){
                        ?>
                    <tr>
                        <td><a style='display:block' href="<?=URL::base().'admin/tasks/edit/'.$task->id;?>" title="Editar"><?=$task->title?></a></td>
                        <td>
                            <?
                                $status = $task->status->order_by('id', 'DESC')->limit('1')->find_all();
                                echo $status[0]->status;
                            ?>
                        </td>		
                        <td>
                            <?
                                $task_user = ORM::factory('tasks_user')->where('task_id', '=', $task->id)->order_by('id', 'DESC')->limit('1')->find_all();
                                echo $task_user[0]->user->userInfos->nome;
                            ?>
                        </td>
                        <td><?=$task->priority->priority?></td>	
                        <td><?=Utils_Helper::data($task->crono_date)?></td>			
                    </tr>
                    <?}?>
		</tbody>
	</table>

</div>