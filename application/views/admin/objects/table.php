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
	    		if(strtotime($objeto->retorno) < strtotime(date("Y-m-d H:i:s")) && $objeto->status_id != '8'){
        			$class_obj = "late";
        		}else{
    				$class_obj 	= "";
    			}

    			$diff = '';
                if(!empty($objeto->diff) && $objeto->diff != 0){
                    if($objeto->diff < 0){
                        $diff = '<span class="badge_line green round">'.$objeto->diff.'</span>';
                    }else{
                        $diff = '<span class="badge_line red round">+'.$objeto->diff.'</span>';
                    }
                }

                $retorno = ($objeto->retorno != '') ? Utils_Helper::data($objeto->retorno,'d/m/Y') : 'aguardando definição';
			?>
			<li class="<?=$class_obj?>">
                <?if(strpos($current_auth, 'assistente') === false){?>
                    <a class="right icon icon_excluir" href="<?=URL::base().'admin/objects/delete/'.$objeto->id;?>" data-message="<?=$delete_msg?>">Excluir</a>
                <?}?>
				<div class="item_content">
					<a class="load" href="<?=URL::base().'admin/objects/view/'.$objeto->id?>" rel="load-content" data-panel="#direita">
						<p><b><?=$objeto->title?></b></p>						
						<p>
                        <span class="subtitle"><?=$objeto->taxonomia?><br/>
                        <?=$objeto->statu_status?> | <?=$retorno?> <?=$diff?></span></p>
					</a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
