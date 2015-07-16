<div >
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
	            <li class="round selected"><a id="tab_1" href="#definicao">definição de workflow</a></li>
	            <?if(count($workflowStatusList) > 0){?>
	            	<li class="round"><a id="tab_2" href="#tarefas">tarefas por status</a></li>
	            <?}?>
	        </ul>  
	    </div>
	    <div class="scrollable_content" >
		    <div id="definicao" >
		        <div class="left"> 
		        	<div class="scrollable_content" data-bottom="false" style="height:500px; padding:0 10px;">
			        	<label>selecione o status</label>
				        <ul class="list_item connect round sortable_workflow" >
				        	<?foreach ($statusList as $status) {?>
								<li class="dd-item" id="item-<?=$status->id?>"><span class="left ball" style="background: <?=$status->color?>"></span><?=$status->status?></li>
							<?}?>
				        </ul>
			        </div>
			    </div>
			    <div class="left">
			    	<div class="scrollable_content" data-bottom="false" style="height:500px; padding:0 10px;">
				    	<label>workflow</label>
				    	<input type="hidden" name="item" id="sortable_workflow_itens" />			    
				        <ul class="list_item connect round sortable_workflow" data-fill="sortable_workflow_itens" >
				        	<?foreach ($workflowStatusList as $workflow_status) {?>
								<li class="dd-item" id="item-<?=$workflow_status->statu->id?>"><span class="left ball" style="background: <?=$workflow_status->statu->color?>"><?=$workflow_status->days?></span><?=$workflow_status->statu->status?></li>
							<?}?>
				        </ul>
				    </div>
			    </div>	
			</div>
			<div id="tarefas" class="content_hide" >   
		        <div class="left"> 
		        	<div class="scrollable_content" data-bottom="false" style="height:500px; padding:0 10px;">
			        	<label>selecione a tarefa</label>
				        <ul class="list_item connect round sortable_workflow">
				        	<?foreach ($tagsList as $tag) { 
				        		$dot = ($tag->sync == '1') ? '*' : '';?>
								<li class="dd-item" id="task-<?=$tag->id?>"><span class="left ball" style="background: <?=$tag->color?>"><?=$tag->days?></span><?=$dot.$tag->tag?></li>
							<?}?>
				        </ul>
				    </div>
			    </div>
			    <div class="left">
			    	<div class="scrollable_content" data-bottom="false" style="height:500px; padding:0 10px;">
			    	<label>workflow</label>
				        <?foreach ($workflowStatusList as $workflow_status) {?>
				        	<div class="dd-item">
				        		<span class="left ball" style="background: <?=$workflow_status->statu->color?>"><?=$workflow_status->days?></span><?=$workflow_status->statu->status?>
						    </div>
						    <input type="hidden" name="tasks_status<?=$workflow_status->status_id?>" id="sortable_tasks<?=$workflow_status->status_id?>" />
					        <ul class="list_item connect round sortable_workflow" data-fill="sortable_tasks<?=$workflow_status->status_id?>" >
					        	<?
					        		foreach ($workflowTagsList as $workflow_tag) {
					        			if($workflow_tag->status_id == $workflow_status->status_id){
					        				$dot = ($workflow_tag->tag->sync == '1') ? '*' : '';
					        	?>
					        		<li class="dd-item" id="task-<?=$workflow_tag->tag->id?>"><span class="left ball" style="background: <?=$workflow_tag->tag->color?>"><?=$workflow_tag->tag->days?></span><?=$dot.$workflow_tag->tag->tag?></li>
					        	<?}}?>
					        </ul>
				        <?}?>
			        </div>
			    </div>	
			</div>
		</div>
	  </dl>
	</form>
</div>