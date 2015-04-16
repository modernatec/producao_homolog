<div class="fixed clear">
	<div class="list_header round">
		<div class="table_info round">
			<div class="left"><?=count($objectsList)?> objetos encontrados</div>
		</div>
	</div>
	<div class="scrollable_content list_body">
	    <? 
		if(count($objectsList) <= 0){
			echo '<span class="list_alert round">nenhum registro encontrado</span>';	
		}else{
		?>
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
    				$class_obj 	= $objeto->statu_class;
    			}	 

	    		if(is_object($objeto->getStatus($objeto->object_status_id))){
	    			$obj_taskView = $objeto->getStatus($objeto->object_status_id); 
	    			
	    			if($obj_taskView->tag->id == '7' && $obj_taskView->status->id == '7'){
	    				$status = "";
	    				$tag = "";
			    	}else{
			    		$status = '<span class="round '.$obj_taskView->status->class.' list_faixa left">'.$obj_taskView->status->status.'</span>';
		    			$tag = '<span class="round list_faixa left tag" style="background:#'.$obj_taskView->tag->class.'">'.$obj_taskView->tag->tag.'</span>';	
		    		}

		    		if($obj_taskView->task_to != 0){
		    			$nome = explode(" ", $obj_taskView->to->nome); 
		    			$img = ($obj_taskView->to->foto)?($obj_taskView->to->foto):('public/image/admin/default.png');
		    			$task_to = ($status != '') ? Utils_Helper::getUserImage($obj_taskView->to) : '';
                    }
	    		}
	    		//href="
			?>
			<li>

				<a class="load" href="<?=URL::base().'admin/objects/view/'.$objeto->id?>" rel="load-content" data-panel="#direita" title="+ informações">
					<div>
						<p><b><?=$objeto->taxonomia?></b></p>
						<hr style="margin:8px 0;" />
						<?if($objeto->supplier_id != 10){ //moderna(interno)?>
							<p><span class="cyan round list_faixa"><?=$objeto->supplier_empresa?></span></p>
						<?}?>
						<p>
							<span class="<?=$class_obj?> round list_faixa left"><?=$objeto->statu_status?> &bull; <?=$objeto->prova?></span>
							<span class="<?=$class_obj?> round list_faixa"><img src="<?=$calendar?>" height="12" valign='middle'> <?=Utils_Helper::data($objeto->retorno,'d/m/Y')?></span>
							<div>
								<div class='left' style="width:25px;"><?=$task_to;?></div>
								<?=$tag;?> 
								<?=$status;?> 
								
							</div>
						</p>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		<?}?>
	</div>
</div>