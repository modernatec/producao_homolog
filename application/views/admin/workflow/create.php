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
        <div class="left"> 
        	<label>status</label>
        	<div class="scrollable_content">
		        <ul class="list_item connect round" id="sortable_workflow">
		        	<?foreach ($statusList as $status) {?>
						<li class="dd-item" id="item-<?=$status->id?>"><span class="left ball" style="background: #<?=$status->color?>"><?=$status->days?></span><?=$status->status?></li>
					<?}?>
		        </ul>
		    </div>
	    </div>
	    <div class="left">
	    	<label>workflow</label>
		    <div class="scrollable_content">	        
	        	<input type="hidden" name="item" id="sortable_workflow2_itens" />
		        <ul class="list_item connect round" id="sortable_workflow2">
		        	
		        	<?foreach ($workflowStatusList as $status) {?>
						<li class="dd-item" id="item-<?=$status->id?>"><span class="left ball" style="background: #<?=$status->color?>"><?=$status->days?></span><?=$status->status?></li>
					<?}?>
		        </ul>
	        </div>
	    </div>
	    
	  </dl>
	</form>
</div>