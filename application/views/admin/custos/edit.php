<label><b>novo valor</b></label><hr/>
<form name="frmCusto2" id="frmCusto2" action="<?=URL::base();?>admin/custos/create/<?=@$objVO['id']?>" method="post" class="form" enctype="multipart/form-data">
	<input type="hidden" name="object_id" value="<?=@$objVO['object_id']?>">
	<div class="left">  
		<dt>
	        <label for="team_id">equipe:</label>
	    </dt>
	    <dd>
	        <select name="team_id" id="team_id" data-target="supplier_id" data-url="admin/custos/getSuppliers" class="required populate round" >
	            <option value="">selecione</option>
	            <? foreach($teamList as $team){?>
	                <option value="<?=$team->id?>" <?=($team->id == @$objVO['team_id']) ? 'selected' : ''?> ><?=$team->name?></option>
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
	            <? foreach($supplierList as $supplier){?>
	                <option value="<?=$supplier->id?>" <?=($supplier->id == @$objVO['supplier_id']) ? 'selected' : ''?> ><?=$supplier->empresa?></option>
	            <?}?>	            
	        </select>
	        <span class='error'><?=Arr::get(@$errors, 'supplier_id');?></span>
	    </dd>
	</div>
	<div class="left">
		<dt>
	        <label for="valor">valor:</label>
	    </dt>
	    <dd>
	        <input type="text" name="valor" id="valor" class="required round" style="width:200px;" value="<?=$objVO['valor']?>" />
	        <span class='error'><?=Arr::get(@$errors, 'valor');?></span>
	    </dd>
	</div>  
	<div class="clear">  				
	    <dt>
	    	<label for="description">observações</label>
	    </dt>
	    <dd>
	          <textarea class="text round" name="description" id="description" style="width:550px; height:70px;"><?=@$objVO['description']?></textarea>
	          <span class='error'><?=Arr::get(@$errors, 'description');?></span>
	    </dd>
	    <dd>
	      <input type="submit" class="round" name="btnCriar" id="btnCriar" data-form="frmTask" value="criar" />
	    </dd>
	</div>	    
</form>
