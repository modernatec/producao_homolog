<div class="hist task round hide" id="form_assign" >
	<label><b>nova tarefa</b></label><hr/>
	<form name="frmCreateTask" id="frmCreateTask" action="<?=URL::base();?>admin/tasks/salvar" method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="object_id" value="<?=$obj->id?>">
		<input type="hidden" name="object_status_id" value="<?=$object_status->id?>">
		<dl>
			<div class="left">
		        <dd>
		            <select name="tag_id" id="tag_id" class="round" style="width:150px;">
		                <option value="0">tag:</option>
		                <? foreach($tagList as $tag){?>
		                    <option value="<?=$tag->id?>" ><?=$tag->tag?></option>
		                <?}?>
		            </select>
		            <span class='error'><?=Arr::get(@$errors, 'tag_id');?></span>
		        </dd>
		    </div>  
		    <div class="left">  
		        <dd>
		            <input type="text" name="crono_date" placeholder="retorno para:" id="crono_date" class="required round date" style="width:100px;" />
		            <span class='error'><?=Arr::get(@$errors, 'crono_date');?></span>
		        </dd>
	        </div>
	        <div class="left">  
		        <dd>
		            <select name="task_to" id="task_to" class="round" style="width:150px;">
		                <option value="0">para:</option>
		                <? foreach($teamList as $userInfo){?>
		                    <option value="<?=$userInfo->id?>" ><?=$userInfo->nome?></option>
		                <?}?>
		            </select>
		            <span class='error'><?=Arr::get(@$errors, 'task_to');?></span>
		        </dd>
		    </div>
		    <div class="clear"> 
	            <dd>
	                  <textarea class="text required round" placeholder="observações" name="description" id="description" style="width:573px; height:70px;"></textarea>
	                  <span class='error'><?=Arr::get(@$errors, 'description');?></span>
	            </dd>
	            <dd>
	              <input type="submit" class="round" name="btnCriar" id="btnCriar" data-form="frmTask" value="criar" />
	              <input type="button" class="round cancel" name="btnCancel" id="btnCancel" data-show="form_assign"  value="cancelar" />
	              
	            </dd>
	        </div>	    
		</dl>
	</form>
</div>