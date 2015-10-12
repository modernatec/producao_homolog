    <div class="list_bar">
        <a href="<?=URL::base();?>admin/objects/edit" rel="load-content" data-panel="#direita" class="bar_button round">catalogar objeto</a>
    </div>        

	<span class='list_alert'>
	<?
        if(count($objectsList) <= 0){
            echo 'não encontrei objetos com estes critérios.';    
        }else{
            echo count($objectsList).' objetos encontrados';
        }
    ?>
	</span>
	<div class="scrollable_content list_body">
		<ul class="list_item">
			<?foreach($objectsList as $objeto){
	    		$calendar = URL::base().'/public/image/admin/calendar2.png';
	    		$class_obj = "object_late";

	    		//$status = $objeto->status->order_by('id', 'DESC')->limit(1)->find();
	    		/*
	    		$last_status = ORM::factory('objects_statu')->where('object_id', '=', $objeto->id)->order_by('id', 'DESC')->limit('1')->find();
	    		//var_dump($last_status->status->status);
				*/
	    		
	    		if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s")) && $objeto->status_id != '8'){
        			$class_obj = "object_late";
        		}else{
    				$class_obj 	= "object_status".$objeto->status_id;
    			}
    			

    			$diff = '';
                if(!empty($objeto->diff) && $objeto->diff != 0){
                    if($objeto->diff < 0){
                        $diff = '<span class="badge_line green round">'.$objeto->diff.'</span>';
                        //$status_class = 'green';
                    }else{
                        $diff = '<span class="badge_line red round">+'.$objeto->diff.'</span>';
                        $status_class = 'red';
                    }
                }

    			$taskList = $objeto->tasks->where('ended', '=', '0')->find_all();
			?>
			<li>
				<div class="item_content">
					<a class="load" href="<?=URL::base().'admin/objects/view/'.$objeto->id?>" rel="load-content" data-panel="#direita" title="+ informações">
						<p><b><?=$objeto->title?></b></p>
						<p><?=$objeto->taxonomia?></p>
						<p><?=$objeto->statu_status?> | <?=($objeto->retorno != '') ? Utils_Helper::data($objeto->retorno,'d/m/Y') : 'aguardando definição'?> <?=$diff?></p>
					</a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
