<div class="header">
	<a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white"  title="fechar">fechar</div>
    </a>
    <span>workflow</span>
</div>
<div class="grayBg">
    <form name="frmCreateWorkflow" id="frmCreateWorkflow" action="<?=URL::base();?>admin/workflows/salvar/<?=@$workflowVO["id"]?>"class="form">
	  
	  	<div class="panel_content" style="padding-bottom:0">
		  	<div><label for="name">nome</label></div>
		  	<div class="left">			  	
		        <dd>
		            <input type="text" class="text required round" placeHolder="nome do workflow" name="name" id="name" style="width:500px;" value="<?=@$workflowVO['name'];?>"/>
		            <span class='error'><?=Arr::get($errors, 'name');?></span>
		        </dd> 
		    </div>
		    <div>
		        <dd>
			      <input type="submit" class="bar_button" name="btnSubmit" id="btnSubmit" value="Salvar" />
			    </dd>
			</div>
		    <div class="clear tabs_panel">
				<ul class="tabs">
				    <li class="roundTop selected"><a id="tab_1" data-show="#definicao">definição de workflow</a></li>
		            <?if(count($workflowStatusList) > 0){?>
		            	<li class="roundTop "><a id="tab_2" data-show="#tarefas">tarefas por status</a></li>
		            <?}?>
				</ul>  
			</div>
	    </div>
	    <div class="whiteBg" >
		    <div id="definicao" class="panel_content content_hide scrollable_content" >
		        <div class="left" > 
		        	<div style="width:200px;">
			        	<label>selecione o status</label>
				        <ul class="list_item connect round sortable_status_workflow" >
				        	<?foreach ($statusList as $status) {?>
								<li class="dd-item" id="item-<?=$status->id?>"><span class="left ball" style="background: <?=$status->color?>"></span><?=$status->status?></li>
							<?}?>
				        </ul>
			        </div>
			    </div>
			    <div class="left" style="padding:0 5px;">
			    	<label>workflow</label>
			    	<div style="width:200px;">
				    	
				    	<input type="hidden" name="item" id="sortable_workflow_itens" />			    
				        <ul class="list_item connect round sortable_status_workflow" data-fill="sortable_workflow_itens" >
				        	<?foreach ($workflowStatusList as $workflow_status) {?>
								<li class="dd-item" id="item-<?=$workflow_status->statu->id?>"><span class="left ball" style="background: <?=$workflow_status->statu->color?>"><?=$workflow_status->days?></span><?=$workflow_status->statu->status?></li>
							<?}?>
				        </ul>
				    </div>
			    </div>	
			</div>
			<div id="tarefas" class="panel_content content_hide" >  
		        <div class="left"> 
		        	<label>selecione a tarefa</label>
		        	<div class="scrollable_content" style="width:250px;">
			        	
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
									                <option value='0' >time</option>
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
			    <div class="left workflow_tasks">
			    	<label>workflow</label>
			    	<div class="scrollable_content" >
			    	
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
											                <option value='0' <?=($workflow_tag->to == '0') ? 'selected="selected"' : ''?> >time</option>
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
	</form>
</div>