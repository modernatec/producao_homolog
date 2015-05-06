	<div class="list_header round">
		<span class='list_alert light_blue round'><?=$total_objects?> objetos encontrados</span>
		<div class="clear">
			<?=$pagination?>
		</div>
	</div>
	<div class="scrollable_content list_body">
	    <? 
		if(count($objectsList) <= 0){
			echo '<span class="list_alert blue round">nenhum registro encontrado</span>';	
		}else{
		?>
		<ul class="list_item">
			<?foreach($objectsList as $objeto){
				$status = "";
	    		$tag = "";
	    		$task_to = "";
	    		$calendar = URL::base().'/public/image/admin/calendar2.png';
				
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
	    				$mod = "";
	    				if($objeto->supplier_id != 10){//producao externa
	    					$mod = "_out";	
	    				}else{
	    					$mod = "_in"; 
	    				}

	    				if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s"))){
	            			$class_obj = "object_late";
	            		}else{
	        				$class_obj 	= $objeto->statu_class.$mod;
	            			$calendar = URL::base().'/public/image/admin/calendar.png';
	        			}

	        			

	        			if(is_object($objeto->getStatus($objeto->object_status_id))){
			    			$obj_taskView = $objeto->getStatus($objeto->object_status_id); 
			    			
			    			if($obj_taskView->tag->id == '7' && $obj_taskView->status->id == '7'){
			    				$status = "";
			    				$tag = "";
					    	}else{
					    		$status = '<span class="round '.$obj_taskView->status->class.' list_faixa left">'.$obj_taskView->status->status.'</span>';
				    			$tag = '<span class="round list_faixa left '.$obj_taskView->tag->class.'">'.$obj_taskView->tag->tag.'</span>';	
				    		}

				    		if($obj_taskView->task_to != 0){
				    			$nome = explode(" ", $obj_taskView->to->nome); 
				    			$img = ($obj_taskView->to->foto)?($obj_taskView->to->foto):('public/image/admin/default.png');
				    			$task_to = ($status != '') ? Utils_Helper::getUserImage($obj_taskView->to) : '';
                            }
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
	    		//href="
			?>
			<li>

				<a class="load" href="<?=URL::base().'admin/acervo/view/'.$objeto->id?>" rel="load-content" data-panel="#direita" title="+ informações">
					<div>
						<p><b><?=$objeto->title?></b></p><p><?=$objeto->taxonomia?></p>
						<hr style="margin:8px 0;" />
						
						<p><?=$objeto->collection->name?></p>
						<?if($objeto->reaproveitamento == 0){ 
			                $origem = "novo";
			            }elseif($objeto->reaproveitamento == 1){
			                $origem = "reap.";
			            }else{
			                $origem = "reap. integral";
			            }?>
            
						<p>
							<span class="blue round list_faixa left"><?=$objeto->collection->materia->name?></span>
							<span class="blue round list_faixa left"><?=$objeto->collection->ano?></span>
							<span class="blue round list_faixa "><?=$origem?></span>
						</p>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		<?}?>
	</div>
