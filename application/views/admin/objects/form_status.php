<div class="boxwired round hide" id="form_status" style="overflow:auto">
	<label><b>alterar status</b></label><hr/>
	<form name="frmStatus" id="frmStatus" action="<?=URL::base();?>admin/objects/updateStatus" method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="object_id" value="<?=$obj->id?>">
		<dl>
			<div class="left">
				<dt>
		            <label for="status_id">status:</label>
		        </dt>
		        <dd>
		            <select name="status_id" id="status_id" class="required round" style="width:150px;">
		                <option value="">selecione</option>
		                <? foreach($statusList as $status){?>
		                    <option value="<?=$status->id?>" ><?=$status->status?></option>
		                <?}?>
		            </select>
		            <span class='error'><?=Arr::get(@$errors, 'status_id');?></span>
		        </dd>				        
			</div>
			<div class="left">
				<dt>
		            <label for="prova">prova:</label>
		        </dt>
		        <dd>
		            <select name="prova" id="prova" class="required round" style="width:150px;">
		                <option value="">selecione</option>
		                <? for($i = 1; $i < 11; $i++){
		                		if($i < 10){
		                			$i = '0'.$i;
		                		}
		                ?>
		                    <option value="prova<?=$i?>" >prova <?=$i?></option>
		                <?}?>
		            </select>
		            <span class='error'><?=Arr::get(@$errors, 'status_id');?></span>
		        </dd>				        
			</div>
			<dt>
	            <label for="crono_date">retorno para:</label>
	        </dt>
	        <dd>
	            <input type="text" name="crono_date" id="crono_date_status" class="round required date" style="width:100px;" />
	            <span class='error'><?=Arr::get(@$errors, 'crono_date');?></span>
	        </dd>			
            <dt>
            	<label for="description">observações</label>
            </dt>
            <dd>
                  <textarea class="text round" name="description" id="description" style="width:600px; height:70px;"></textarea>
                  <span class='error'><?=Arr::get(@$errors, 'description');?></span>
            </dd>
            <dd>
              
              <input type="submit" class="round" name="btnCriar" id="btnCriar" data-form="frmStatus" value="criar" />
              <input type="button" class="round cancel" name="btnCancel" id="btnCancel" data-show="form_status"  value="cancelar" />
              
            </dd>	    
		</dl>
	</form>
</div>