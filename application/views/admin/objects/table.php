		<span class='list_alert light_blue round'>
		<?
            if(count($objectsList) <= 0){
                echo 'não encontrei objetos com estes critérios.';    
            }else{
                echo 'encontrei: '. count($objectsList).' objeto(s)';
            }
        ?>
		</span>
	<div class="scrollable_content list_body">
		<ul class="list_item">
			<?foreach($objectsList as $objeto){
				$status = "";
	    		$tag = "";
	    		$task_to = "";
	    		$calendar = URL::base().'/public/image/admin/calendar2.png';
				/*
				switch($objeto->status_id){
	    			case 1:
	    				if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
	            			$class_obj = "object_late";
	            		}else{
	        				$class_obj 	= $objeto->statu_class;
	            			$calendar = URL::base().'/public/image/admin/calendar.png';
	        			}
	    				break;
	    			case 2:
	    				

	    				if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
	            			$class_obj = "object_late";
	            		}else{
	        				$class_obj 	= $objeto->statu_class;
	            			$calendar = URL::base().'/public/image/admin/calendar.png';
	        			}	        			
	   				
	    				break;
	    			case 8://finalizado
	    				$class_obj 	= $objeto->statu_class;
	    				$class 		= $objeto->statu_class;
	    				$calendar = URL::base().'/public/image/admin/calendar.png';

	    				break;	
	    			default:
	    				if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
	            			$class_obj = "object_late";
	            		}else{
	        				$class_obj 	= $objeto->statu_class;
	            			$calendar = URL::base().'/public/image/admin/calendar.png';

	        			}	        			
	    		}
	    		*/

	    		if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s")) && $objeto->status_id != '8'){
        			$class_obj = "object_late";
        		}else{
    				$class_obj 	= $objeto->statu_type."_status".$objeto->status_id;
    			}	 

	    		if(is_object($objeto->getStatus($objeto->object_status_id))){
	    			$obj_taskView = $objeto->getStatus($objeto->object_status_id); 
	    			
	    			if($obj_taskView->tag->id == '7' && $obj_taskView->status->id == '7'){
	    				$status = "";
	    				$tag = "";
			    	}else{
			    		$task_class = $obj_taskView->status->type.'_status'.$obj_taskView->status->id;
			    		$status = '<span class="round '.$task_class.' list_faixa left">'.$obj_taskView->status->status.'</span>';
		    			$tag = '<span class="round list_faixa left tag" style="background:'.$obj_taskView->tag->color.'">'.$obj_taskView->tag->tag.'</span>';	
		    		}

		    		if($obj_taskView->task_to != 0){
		    			$nome = explode(" ", $obj_taskView->to->nome); 
		    			$img = ($obj_taskView->to->foto)?($obj_taskView->to->foto):('public/image/admin/default.png');
		    			$task_to = ($status != '') ? Utils_Helper::getUserImage($obj_taskView->to) : '';
                    }
	    		}
			?>
			<li>

				<a class="load" href="<?=URL::base().'admin/objects/view/'.$objeto->id?>" rel="load-content" data-panel="#direita" title="+ informações">
					<div>
						<p><b><?=$objeto->taxonomia?></b></p>
						<hr style="margin:8px 0;" />
						<?if($objeto->supplier_id != 10){ //moderna(interno)?>
							<span class="cyan round list_faixa clear"><?=$objeto->supplier_empresa?></span>
						<?}?>
						<div class="clear">
							<span class="<?=$class_obj?> round list_faixa left"><?=$objeto->statu_status?></span>
							<span class="<?=$class_obj?> round list_faixa"><img src="<?=$calendar?>" height="12" valign='middle'> <?=Utils_Helper::data($objeto->retorno,'d/m/Y')?></span>
						</div>
						<div>
							<div class='left' style="width:25px;"><?=$task_to;?></div>
							<?=$tag;?> 
							<?=$status;?> 
							
						</div>
						
					</div>
				</a>
			</li>
			<?}?>
		</ul>
	</div>
