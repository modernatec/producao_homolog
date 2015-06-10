<div >
    <form name="frmCreateWorkflow" id="frmCreateWorkflow" action="<?=URL::base();?>admin/workflows/salvar/<?=@$workflowVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
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
	            <li class="round"><a id="tab_1" href="#definicao">definição de workflow</a></li>
	            <li class="round"><a id="tab_2" href="#tarefas">tarefas por status</a></li>
	        </ul>  
	    </div>
	    <div class="scrollable_content">
		    <div id="definicao" class="content_hide">
		        <div class="left"> 
		        	<label>selecione o status</label>
			        <ul class="list_item connect round sortable_workflow" >
			        	<?foreach ($statusList as $status) {?>
							<li class="dd-item" id="item-<?=$status->id?>"><span class="left ball" style="background: #<?=$status->color?>"><?=$status->days?></span><?=$status->status?></li>
						<?}?>
			        </ul>
			    </div>
			    <div class="left">
			    	<label>workflow</label>
			    	<input type="hidden" name="item" id="sortable_workflow_itens" />			    
			        <ul class="list_item connect round sortable_workflow" data-fill="sortable_workflow_itens" >
			        	<?foreach ($workflowStatusList as $status) {?>
							<li class="dd-item" id="item-<?=$status->id?>"><span class="left ball" style="background: #<?=$status->color?>"><?=$status->days?></span><?=$status->status?></li>
						<?}?>
			        </ul>
			    </div>	
			</div>
			<div id="tarefas" class="content_hide">   
		        <div class="left"> 
		        	<label>selecione a tarefa</label>
			        <ul class="list_item connect round sortable_workflow">
			        	<?foreach ($tagsList as $tag) {?>
							<li class="dd-item" id="task-<?=$tag->id?>"><span class="left ball" style="background: #<?=$tag->color?>"><?=$tag->days?></span><?=$tag->tag?></li>
						<?}?>
			        </ul>
			    </div>
			    <div class="left">
			    	<label>workflow</label>
			        <?foreach ($workflowStatusList as $status) {?>
			        	<div class="dd-item">
			        		<span class="left ball" style="background: #<?=$status->color?>"><?=$status->days?></span><?=$status->status?>
					    </div>
					    <input type="hidden" name="tasks_status<?=$status->id?>" id="sortable_tasks<?=$status->id?>" />
				        <ul class="list_item connect round sortable_workflow" data-fill="sortable_tasks<?=$status->id?>" >
				        </ul>
			        <?}?>
			    </div>	
			</div>
		</div>
	  </dl>
	</form>
</div>