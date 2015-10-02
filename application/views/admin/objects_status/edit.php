<div class="header">
    <div class="left icon icon_status_white">tarefas</div>
    <span><?=$title?></span>
</div>
<div class="left" style="min-width:478px;">
	<form name="frmStatus2" id="frmStatus2"  data-panel="#direita" action="<?=URL::base();?>admin/objects/updateStatus/<?=$objVO['id']?>" method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="object_id" value="<?=$objVO['object_id']?>">
			<div class="left">
				<dt>
		            <label for="status_id">status:</label>
		        </dt>
		        <dd>
		            <select name="status_id" id="status_id" data-workflow="<?=$obj->workflow_id?>" class="required round" style="width:150px;" >
		                <option value="">selecione</option>
		                <? foreach($statusList as $workflow_status){?>
		                    <option value="<?=$workflow_status->statu->id?>" data-days="<?=$workflow_status->days?>" <?=($objVO['status_id'] == $workflow_status->status_id) ? "selected" : ""?> ><?=$workflow_status->statu->status?></option>
		                <?}?>
		            </select>
		            <span class='error'><?=Arr::get($errors, 'status_id');?></span>
		        </dd>				        
			</div>
			<div class="left">
				<dt>
		            <label for="crono_date">retorno para:</label>
		        </dt>
		        <dd>
		            <input type="text" name="crono_date" id="crono_date" class="round required date" style="width:100px;" value="<?=$objVO['crono_date']?>" />
		            <span class='error'><?=Arr::get($errors, 'crono_date');?></span>
		        </dd>
	        </div>
	        <div class="clear">			
	            <dt>
	            	<label for="description">observações</label>
	            </dt>
	            <dd>
	                  <textarea class="text round" name="description" id="description" style="width:420px; height:300px;"><?=$objVO['description']?></textarea>
	                  <span class='error'><?=Arr::get($errors, 'description');?></span>
	            </dd>
            </div>
            <dd>
              <input type="submit" class="round bar_button left" name="btnCriar" id="btnCriar" data-form="frmStatus" value="salvar" />             
              <a href="javascript:void(0)" class="close_pop bar_button left round">cancelar</a>      
            </dd>	    
	</form>
</div>
<div class="append left" id="sequence">

</div>