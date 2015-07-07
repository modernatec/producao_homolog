	<span class='list_alert light_blue round'>
	<?
        if(count($objectsList) <= 0){
            echo 'não encontrei objetos com estes critérios.';    
        }else{
            echo 'encontrei '. count($objectsList).' objeto(s)';
        }
    ?>
	</span>
	<div class="scrollable_content list_body">
		<ul class="list_item">
			<?foreach($objectsList as $objeto){
	    		$calendar = URL::base().'/public/image/admin/calendar2.png';

	    		if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s")) && $objeto->status_id != '8'){
        			$class_obj = "object_late";
        		}else{
    				$class_obj 	= $objeto->statu_type."_status".$objeto->status_id;
    			}	 

    			$diff = '';
                if($objeto->diff != 0){
                    if($objeto->diff < 0){
                        $diff = '<span class="list_faixa green round">'.$objeto->diff.'</span>';
                        //$status_class = 'green';
                    }else{
                        $diff = '<span class="list_faixa red round">+'.$objeto->diff.'</span>';
                        $status_class = 'red';
                    }
                }

    			$taskList = $objeto->tasks->where('ended', '=', '0')->find_all();
			?>
			<li>
				<a class="load" href="<?=URL::base().'admin/objects/view/'.$objeto->id?>" rel="load-content" data-panel="#direita" title="+ informações">
					<p><b><?=$objeto->title?></b><br/><?=$objeto->taxonomia?></p>
					<hr style="margin:4px 0;" />
					<div class="clear">
						<span class="<?=$class_obj?> round list_faixa left"><?=$objeto->statu_status?></span>
						<span class="<?=$class_obj?> round list_faixa"><img src="<?=$calendar?>" height="12" valign='middle'> <?=($objeto->retorno != '') ? Utils_Helper::data($objeto->retorno,'d/m/Y') : 'à definir'?></span><?=$diff?>
					</div>
					<?foreach ($taskList as $task) {
						$task_to = ($task->task_to != 0) ? Utils_Helper::getUserImage($task->task_to) : '<div class="round_imgList"><span>?</span></div>';

						$diff = '';
		                if($task->diff != 0){
                            if($task->diff < 0){
                                $diff = '<span class="list_faixa round">'.$task->diff.'</span>';
                                //$color = $task->tag->color;
                            }else{
                                $diff = '<span class="list_faixa red round">+'.$task->diff.'</span>';
                                $color = 'red';
                            }
                        }
					?>
						<div class="clear task_line" >
							<div class='left'><?=$task_to;?></div>
							<span class="round list_faixa left tag" style="background:<?=$task->tag->color?>"><?=$task->tag->tag?></span>	
							<span class="round <?=$task->status->type.'_status'.$task->status->id?> list_faixa left"><?=$task->status->status;?></span><?=$diff?>
						</div>
					<?}?>
				</a>
			</li>
			<?}?>
		</ul>
	</div>
