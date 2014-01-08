<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/tasks/create" class="bar_button round">Criar tarefas</a>
        <a href="<?=URL::base();?>admin/tasks/load" class="bar_button round">Carregar tarefas</a>
	</div>
	<span class="header">minhas tarefas (<?=count($taskList);?>)</span>
    <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Criadas</a></li>
    <li><a href="#tabs-2">Minhas</a></li>
    <li><a href="#tabs-3">Da minha equipe</a></li>
  </ul>
  <div id="tabs-1">
    <table class="list">
        <thead>
            <tr valign="bottom">
                <th width="200">taxonomia</th>
                <th width="100">status atual</th>
                <th width="20">de:</th>
                <th width="20">para:</th>  
                <th width="50">projeto</th>     
                <th width="100">data de entrega</th>
            </tr>
        </thead>
        <tbody>
                <? foreach($taskList as $task){?>
                <tr>
                    <td>
                        <a style='display:block' href="<?=URL::base().'admin/tasks/assign/'.$task->id;?>" title="Editar"><b><?=$task->taxonomia?></b><br/><?=$task->title?></a>
                    </td>
                    <td>
                        <?
                            $steps = $task->steps->order_by('status_tasks.id', 'DESC')->limit('1')->find_all();
                            echo $steps[0]->step;
                            echo '<br/>';
                            $status = $task->status->order_by('status_tasks.id', 'DESC')->limit('1')->find_all();
                            echo $status[0]->status;
                        ?>
                    </td>
                    <td>
                        <img class='round_imgList' src='<?=URL::base();?><?=$task->userInfo->foto?>' height="25" title="<?=ucfirst($task->userInfo->nome);?>" /> 
                    </td>       
                    <td>
                        <?
                            $task_user = ORM::factory('tasks_user')->where('task_id', '=', $task->id)->order_by('id', 'DESC')->limit('1')->find_all();
                        ?>
                            <img class='round_imgList' src='<?=URL::base();?><?=$task_user[0]->userInfo->foto?>' height="25" title="<?=ucfirst($task_user[0]->userInfo->nome);?>" /> 
                    </td>
                    <td>
                        <?=$task->project->name;?>
                    </td>   
                    <td><?=Utils_Helper::data($task->crono_date)?></td>         
                </tr>
                <? }?>
        </tbody>
    </table>  
  </div>
  <div id="tabs-2">
    <p>Minhas</p>
  </div>
  <div id="tabs-3">
      <?
        if(isset($taskTeam)){
        ?>
        <span class="header">tarefas da minha equipe</span>
        <table class="list">
            <thead>
                <tr valign="bottom">
                    <th width="200">taxonomia</th>
                    <th width="100">status atual</th>
                    <th width="20">de:</th>
                    <th width="20">para:</th>  
                    <th width="50">projeto</th>     
                    <th width="100">data de entrega</th>
                </tr>
            </thead>
            <tbody>
                    <? foreach($taskTeam as $task){?>
                    <tr>
                        <td>
                            <a style='display:block' href="<?=URL::base().'admin/tasks/assign/'.$task->id;?>" title="Editar"><?=$task->taxonomia?></a>
                            <span class='title_list'><?=$task->title?></span>
                        </td>
                        <td>
                            <?
                                $status = $task->status->order_by('status_tasks.id', 'DESC')->limit('1')->find_all();
                                echo $status[0]->status;
                            ?>
                        </td>
                        <td>
                            <img class='round_imgList' src='<?=URL::base();?><?=$task->userInfo->foto?>' height="25" title="<?=ucfirst($task->userInfo->nome);?>" /> 
                        </td>       
                        <td>
                            <?
                                $task_user = ORM::factory('tasks_user')->where('task_id', '=', $task->id)->order_by('id', 'DESC')->limit('1')->find_all();
                            ?>
                                <img class='round_imgList' src='<?=URL::base();?><?=$task_user[0]->userInfo->foto?>' height="25" title="<?=ucfirst($task_user[0]->userInfo->nome);?>" /> 
                        </td>
                        <td>
                            <span class="title_list"><?=$task->project->name;?></span>
                        </td> 
                        <td><?=Utils_Helper::data($task->crono_date)?></td>         
                    </tr>
                    <? }?>
            </tbody>
        </table>
        <? }?>
  </div>
</div>
	

    
</div>