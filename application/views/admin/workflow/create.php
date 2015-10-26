<div class="header">
	<a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white"  title="fechar">fechar</div>
    </a>
    <span>workflow</span>
</div>
<div>
    <form name="frmCreateWorkflow" id="frmCreateWorkflow" action="<?=URL::base();?>admin/workflows/salvar/<?=@$workflowVO["id"]?>"class="form">
	  
	  	<div class="panel_gray" style="padding-bottom:0">
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
	    <div>
		    <div id="definicao" class="panel_content content_hide scrollable_content" >
		        <div class="left" > 
		        	<div style="width:200px;">
			        	<label>selecione o status</label>
				        <ul class="list_item connect round sortable_status_workflow" >
				        	<?foreach ($statusList as $status) {?>
								<li class="dd-item round" id="item-<?=$status->id?>"><?=$status->status?></li>
							<?}?>
				        </ul>
			        </div>
			    </div>
			    <div class="left" style="padding:0 5px; border-left: 1px #AFBCBF solid">
			    	<label>workflow</label>
			    	<div style="width:200px;">
				    	
				    	<input type="hidden" name="item" id="sortable_workflow_itens" />			    
				        <ul class="list_item connect round sortable_status_workflow" data-fill="sortable_workflow_itens" >
				        	<?foreach ($workflowStatusList as $workflow_status) {?>
								<li class="dd-item round" id="item-<?=$workflow_status->statu->id?>"><span class="right cyan ball"><?=$workflow_status->days?></span><?=$workflow_status->statu->status?></li>
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

				        	foreach ($tagsList as $key => $tag) {
								$item = View::factory('admin/workflow/workflow_item')
		        					->bind('errors', $errors)
									->bind('message', $message);

								$item->key = $key;
								$item->tagsList_sub = $tagsList_sub;
		        				$item->workflow_tag = $tag;
		        				$item->workflow_status = $workflow_status;
		        				$item->show = 'hide';

		        				echo $item->render();
							}
							?>
				        </ul>
				    </div>
			    </div>
			    <div class="left workflow_tasks">
			    	<label>workflow</label>
			    	<div class="scrollable_content" >
			    	
			    	<div style="width:<?=count($workflowStatusList) * 420;?>px;">
				        <?foreach ($workflowStatusList as $workflow_status) {?>
				        	<div class="left" style="width:415px;">
					        	<div class="workflow_tasks_header round" style="background: <?=$workflow_status->statu->team->color?>"><span class="right cyan ball"><?=$workflow_status->days?></span><?=$workflow_status->statu->status?></div>
							    <input type="hidden" name="tasks_status<?=$workflow_status->status_id?>" id="sortable_tasks<?=$workflow_status->status_id?>" />
						        <ul class="list_item connect round sortable_workflow drop" data-fill="sortable_tasks<?=$workflow_status->status_id?>" data-status="<?=$workflow_status->status_id?>" >
						        	<?
						        		foreach ($workflowTagsList as $key => $workflow_tag) {
						        			if($workflow_tag->status_id == $workflow_status->status_id){
						        				$item = View::factory('admin/workflow/workflow_item')
						        					->bind('errors', $errors)
													->bind('message', $message);

												$item->key = $key;
												$item->tagsList_sub = $tagsList_sub;
						        				$item->workflow_tag = $workflow_tag;
						        				$item->workflow_status = $workflow_status;
						        				$item->show = '';

						        				echo $item->render();			
						        			}
						        		}
						        	?>
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