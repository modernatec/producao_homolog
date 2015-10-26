    <span class='list_alert'>
    <?
        if(count($taskList) <= 0){
            echo 'não encontrei tarefas não iniciadas.';    
        }else{
            echo count($taskList).' tarefas encontradas';
        }
    ?>
    </span>
    <div class="list_body scrollable_content">
    <? 
        if($current_auth != "assistente"){
            $id = "sortable";
        }else{
            $id = "";
        }
                     
        echo '<ul class="list_item" id="'.$id.'">';
        foreach($notifications as $key=>$task){
                $object_late = "";                            
                $diff = '';
                if($task->diff != 0){
                    if($task->diff < 0){
                        $diff = '<span class="list_faixa green round">'.$task->diff.'</span>';
                    }else{
                        $diff = '<span class="list_faixa red round">+'.$task->diff.'</span>';
                    }
                }

                if(strtotime($task->crono_date) < strtotime(date("Y-m-d H:i:s"))){
                    $object_late = "late";                            
                }

                $icon_status = 'list_'.$task->status->status;
                
                $item = View::factory('admin/tasks/task_item')->bind('errors', $errors);
                $item->task = $task;
                $item->object_late = $object_late;
                $item->icon_status = $icon_status;

                echo $item;
        }

        foreach($taskList as $key => $task){
            $object_late = '';

            $diff = '';
            if($task->diff != 0){
                if($task->diff < 0){
                    $diff = '<span class="list_faixa green round">'.$task->diff.'</span>';
                }else{
                    $diff = '<span class="list_faixa red round">+'.$task->diff.'</span>';
                }
            }

            if(strtotime($task->crono_date) < strtotime(date("Y-m-d H:i:s"))){
                $object_late = "late";
            }

            $icon_status = 'list_'.$task->status->status;
            
            $item = View::factory('admin/tasks/task_item')->bind('errors', $errors);
            $item->task = $task;
            $item->object_late = $object_late;
            $item->icon_status = $icon_status;

            echo $item;

        }
        echo '<ul>';
    ?>
    </div>
