<a href="javascript:void(0)" class="close_pop bar_button round right">fechar</a> 
<div style="width:1150px">

    <form name="frmCreateWorkflow" id="frmCreateWorkflow" action="<?=URL::base();?>admin/workflows/salvar/<?=@$workflowVO["id"]?>"class="form">
	  <dl>
	  	<label for="name">nome</label>
        <dd>
            <input type="text" class="text required round" placeHolder="nome do workflow" name="name" id="name" style="width:500px;" value="<?=@$workflowVO['name'];?>"/>
            <span class='error'><?=Arr::get($errors, 'name');?></span>
        </dd> 
        <dd class="clear">
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="Salvar" />
	    </dd>
	    <div class="tabs_holder">
	        <ul class="tabs">
	            <li class="round selected"><a id="tab_1" data-show="#definicao">definição de workflow</a></li>
	            <?if(count($workflowStatusList) > 0){?>
	            	<li class="round"><a id="tab_2" data-show="#tarefas">tarefas por status</a></li>
	            <?}?>
	        </ul>  
	    </div>
	    <div class="scrollable_content" >
		    <div id="definicao" class="content_hide" >
		        <div class="left"> 
		        	<div class="scrollable_content" data-bottom="false" style="height:600px;">
			        	<label>selecione o status</label>
				        <ul class="list_item connect round sortable_status_workflow" >
				        	<?foreach ($statusList as $status) {?>
								<li class="dd-item" id="item-<?=$status->id?>"><span class="left ball" style="background: <?=$status->color?>"></span><?=$status->status?></li>
							<?}?>
				        </ul>
			        </div>
			    </div>
			    <div class="left">
			    	<div class="scrollable_content" data-bottom="false" style="height:600px;">
				    	<label>workflow</label>
				    	<input type="hidden" name="item" id="sortable_workflow_itens" />			    
				        <ul class="list_item connect round sortable_status_workflow" data-fill="sortable_workflow_itens" >
				        	<?foreach ($workflowStatusList as $workflow_status) {?>
								<li class="dd-item" id="item-<?=$workflow_status->statu->id?>"><span class="left ball" style="background: <?=$workflow_status->statu->color?>"><?=$workflow_status->days?></span><?=$workflow_status->statu->status?></li>
							<?}?>
				        </ul>
				    </div>
			    </div>	
			</div>
			<div id="tarefas" class="content_hide" >  
		        <div class="left"> 
		        	<div class="scrollable_content" data-bottom="false" style="height:600px;">
			        	<label>selecione a tarefa</label>
				        <ul class="list_item round connect sortable_workflow" id="workflow_task">
				        	<?

				        	foreach ($tagsList as $tag) {?>
								<li class="dd-item" id="task-<?=$tag->id?>" rel="task-<?=$tag->id?>">
									<a class="remover hide right" href="javascript:void(0)" title="remover item">remover</a>
									<div class="list_faixa_workflow round" style="background: <?=$tag->color?>"><?=$tag->tag?></div>
									<div class="infos hide">
										<div class="clear left">
									        <label for="days">qtd. dias</label>
									        <dd>
									            <input type="text" class="text required info round" placeholder="qtd. dias" name="days" id="days" style="width:40px;" value="0"/>
									            <span class='error'><?=Arr::get($errors, 'days');?></span>
									        </dd>   
									    </div>
									    <div class="left">
									    	<label for="sync">concomitante</label>
									        <dd>
									            <select class="required info round" name="sync" id="sync" >
									                <option value='0'  >não</option>
									                <option value='1' >sim</option>
									            </select>
									            <span class='error'><?=Arr::get($errors, 'sync');?></span>
									        </dd>  
									    </div>
									    
									    <div class="left">
									        <label for="next_tag_id">ação automática</label>
									        <dd>
									            <select class="required info round" style="width:120px;" name="next_tag_id" id="next_tag_id" >
									                <option value='0' >nenhuma</option>
									                <?foreach ($tagsList_sub as $tag_sub) {?>
									                    <option value='<?=$tag_sub->id?>' ><?=$tag_sub->tag?></option>
									                <?}?>
									                
									            </select>
									            <span class='error'><?=Arr::get($errors, 'next_tag_id');?></span>
									        </dd>  
									    </div>
									    <div class="left">
									        <label for="to">responsável</label>
									        <dd>
									            <select class="required info round" style="width:120px;"  name="to" id="to" >
									                <option value='0' >em aberto</option>
									                <option value='1' >responsável pela coleção</option>
									                
									            </select>
									            <span class='error'><?=Arr::get($errors, 'sync');?></span>
									        </dd>  
									    </div>
									</div>
								</li>
							<?}?>
				        </ul>
				    </div>
			    </div>
			    <div class="left">
			    	<div class="scrollable_x" data-bottom="false" style="width:850px; height:600px;">
			    	<label>workflow</label>
			    	<div style="width:<?=count($workflowStatusList) * 420;?>px;">
				        <?foreach ($workflowStatusList as $workflow_status) {?>
				        	<div class="left" style="width:415px;">
					        	<div >
					        		<div class="list_faixa_workflow round" style="background: <?=$workflow_status->statu->color?>"><?=$workflow_status->days?> - <?=$workflow_status->statu->status?></div>
							    </div>
							    <input type="hidden" name="tasks_status<?=$workflow_status->status_id?>" id="sortable_tasks<?=$workflow_status->status_id?>" />
						        <ul class="list_item connect round sortable_workflow drop" data-fill="sortable_tasks<?=$workflow_status->status_id?>" data-status="<?=$workflow_status->status_id?>" >
						        	<?
						        		foreach ($workflowTagsList as $key=> $workflow_tag) {
						        			if($workflow_tag->status_id == $workflow_status->status_id){
						        				
						        	?>
						        		<li class="dd-item" id="task-<?=$workflow_tag->tag->id?>">
						        			<a class="remover right" href="javascript:void(0)" title="remover item">remover</a>
						        			<div class="list_faixa_workflow round" style="background: <?=$workflow_tag->tag->color?>"><?=$workflow_tag->tag->tag?></div>
						        			<div class="infos">						        				
												<div class="clear left">
											        <label for="days">qtd. dias</label>
											        <dd>
											            <input type="text" class="text required info round" placeholder="qtd. dias" name="days_<?=$workflow_status->status_id?>[]" id="days" style="width:40px;" value="<?=$workflow_tag->days?>"/>
											            <span class='error'><?=Arr::get($errors, 'days');?></span>
											        </dd>   
											    </div>
											    <div class="left">
											    	<label for="sync_<?=$key?>">concomitante</label>
											        <dd>
											            <select class="required info round" name="sync_<?=$workflow_status->status_id?>[]" id="sync_<?=$key?>" >
											                <option value='0' <?=($workflow_tag->sync == '0') ? 'selected="selected"' : ''?> >não</option>
											                <option value='1' <?=($workflow_tag->sync == '1') ? 'selected="selected"' : ''?> >sim</option>
											            </select>
											            <span class='error'><?=Arr::get($errors, 'sync');?></span>
											        </dd>  
											    </div>
											    
											    <div class="left">
											        <label for="next_tag_id">ação automática</label>
											        <dd>
											            <select class="required info round" style="width:120px;" name="next_tag_id_<?=$workflow_status->status_id?>[]" id="next_tag_id" >
											                <option value='0' >nenhuma</option>
											                <?foreach ($tagsList_sub as $tag_sub) {?>
											                    <option value='<?=$tag_sub->id?>' <?=($workflow_tag->next_tag_id == $tag_sub->id ) ? 'selected="selected"' : '';?> ><?=$tag_sub->tag?></option>
											                <?}?>
											                
											            </select>
											            <span class='error'><?=Arr::get($errors, 'next_tag_id');?></span>
											        </dd>  
											    </div>
											    <div class="left">
											        <label for="to">responsável</label>
											        <dd>
											            <select class="required info round" style="width:120px;"  name="to_<?=$workflow_status->status_id?>[]" id="to" >
											                <option value='0' <?=($workflow_tag->to == '0') ? 'selected="selected"' : ''?> >em aberto</option>
											                <option value='1' <?=($workflow_tag->to == '1') ? 'selected="selected"' : ''?> >responsável pela coleção</option>
											                
											            </select>
											            <span class='error'><?=Arr::get($errors, 'sync');?></span>
											        </dd>  
											    </div>
											    
											
											</div>
						        		</li>
						        	<?}}?>
						        </ul>
						    </div>
				        <?}?>
				    </div>
			        </div>
			    </div>	
			</div>
		</div>
	  </dl>
	</form>
</div>