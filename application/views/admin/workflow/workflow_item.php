<li class="dd-item round card" id="task-<?=$tag->id?>">
	
	<div class="card_header">
		
		<a class="remover <?=$show?>" >
			<div class="right icon icon_excluir" title="remover item">fechar</div>
		</a>
		<?=$tag->tag?>
	</div>
	<div class="infos card_body <?=$show?>">						        				
		<div class="clear left">
	        <label for="days">qtd. dias</label>
	        <dd>
	            <input type="text" class="text <?=$required?> info round" placeholder="qtd. dias" name="days_<?=@$workflow_status->status_id?>[]" data-id="days_" style="width:40px;" value="<?=@$workflow_tag->days?>"/>
	            <span class='error'><?=Arr::get($errors, 'days');?></span>
	        </dd>   
	    </div>
	    <div class="left">
	    	<label for="sync_<?=$key?>">concomitante</label>
	        <dd>
	            <select class="<?=$required?> info round" name="sync_<?=@$workflow_status->status_id?>[]" data-id="sync_" >
	                <option value='0' <?=(@$workflow_tag->sync == '0') ? 'selected="selected"' : ''?> >não</option>
	                <option value='1' <?=(@$workflow_tag->sync == '1') ? 'selected="selected"' : ''?> >sim</option>
	            </select>
	            <span class='error'><?=Arr::get($errors, 'sync');?></span>
	        </dd>  
	    </div>
	    
	    <div class="left">
	        <label for="next_tag_id">ação automática</label>
	        <dd>
	            <select class="<?=$required?> info round" style="width:120px;" name="next_tag_id_<?=@$workflow_status->status_id?>[]" data-id="next_tag_id_" >
	                <option value='0' >nenhuma</option>
	                <?foreach ($tagsList_sub as $tag_sub) {?>
	                    <option value='<?=$tag_sub->id?>' <?=(@$workflow_tag->next_tag_id == $tag_sub->id ) ? 'selected="selected"' : '';?> ><?=$tag_sub->tag?></option>
	                <?}?>
	                
	            </select>
	            <span class='error'><?=Arr::get($errors, 'next_tag_id');?></span>
	        </dd>  
	    </div>
	    <div class="left">
	        <label for="to">responsável</label>
	        <dd>
	            <select class="<?=$required?> info round" style="width:120px;"  name="to_<?=@$workflow_status->status_id?>[]" data-id="to_" >
	                <option value='0' <?=(@$workflow_tag->to == '0') ? 'selected="selected"' : ''?> >time</option>
	                <option value='1' <?=(@$workflow_tag->to == '1') ? 'selected="selected"' : ''?> >responsável pela coleção</option>
	                
	            </select>
	            <span class='error'><?=Arr::get($errors, 'sync');?></span>
	        </dd>  
	    </div>
	    
	
	</div>
</li>