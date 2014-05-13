<div class="boxwired round hide" id="form_assign" style="overflow:auto;">
	<label><b>novo valor</b></label><hr/>
	<form name="frmCusto" id="frmCusto" action="<?=URL::base();?>admin/custos/create" method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="object_id" value="<?=$obj->id?>">
		<div class="left">  
			<dt>
		        <label for="team_id">equipe:</label>
		    </dt>
		    <dd>
		        <select name="team_id" id="team_id" data-target="supplier_id" data-url="admin/custos/getSuppliers" class="required populate round" >
		            <option value="">selecione</option>
		            <? foreach($teamList as $team){?>
		                <option value="<?=$team->id?>" ><?=$team->name?></option>
		            <?}?>
		        </select>
		        <span class='error'><?=Arr::get(@$errors, 'team_id');?></span>
		    </dd>
		</div>
		<div class="left">  
		    <dt>
		        <label for="supplier_id">fornecedor:</label>
		    </dt>
		    <dd>
		        <select name="supplier_id" id="supplier_id" class="required round" style="width:150px;">
		            <option value="">selecione</option>
		            
		        </select>
		        <span class='error'><?=Arr::get(@$errors, 'supplier_id');?></span>
		    </dd>
		</div>
		<div class="left">
			<dt>
		        <label for="valor">valor:</label>
		    </dt>
		    <dd>
		        <input type="text" name="valor" id="valor" class="required round" style="width:200px;" />
		        <span class='error'><?=Arr::get(@$errors, 'valor');?></span>
		    </dd>
		</div>  
		<div class="clear">  				
		    <dt>
		    	<label for="description">observações</label>
		    </dt>
		    <dd>
		          <textarea class="text required round" name="description" id="description" style="width:550px; height:70px;"></textarea>
		          <span class='error'><?=Arr::get(@$errors, 'description');?></span>
		    </dd>
		    <dd>
		      <input type="submit" class="round" name="btnCriar" id="btnCriar" data-form="frmTask" value="criar" />
		      <input type="button" class="round cancel" name="btnCancel" id="btnCancel" data-show="form_assign"  value="cancelar" />
		      
		    </dd>
		</div>	    
	</form>
</div>