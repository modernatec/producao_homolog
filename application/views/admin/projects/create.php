<div class="fixed clear">    
    <form name="frmCreateProject" id="frmCreateProject" action="<?=URL::base();?>admin/projects/salvar/<?=@$projectVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
	    <dt>
	      <label for="name">projeto</label>
	    </dt>
	    <dd>
	      <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=@$projectVO['name'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>
	    <div class="left">
		    <dt>
		      <label for="target">segmento</label>
		    </dt>
		    <dd>
		      <select name="segmento_id" id="segmento_id" class="required round" style="width:150px;">
	                <option value="">selecione</option>
	                <? foreach($segmentosList as $segmento){?>
	                <option value="<?=$segmento->id?>" <?=((@$projectVO["segmento_id"] == $segmento->id)?('selected'):(''))?> ><?=$segmento->name?></option>
	                <? }?>
	            </select>
	            <span class='error'><?=($errors) ? $errors['segmento_id'] : '';?></span>
		    </dd>
		</div>
		<div class="left">
	    <dt>
	      <label for="status">status</label>
	    </dt>
	    <dd>
	      <select class="required round" name="status" id="status" style="width:150px;">
                <option value='1' <?=(($projectVO['status']==1)?('selected="selected"'):(''))?>>em produção</option>
                <option value='0' <?=(($projectVO['status']==0)?('selected="selected"'):(''))?>>finalizado</option>
            </select>
            <span class='error'><?=($errors) ? $errors['status'] : '';?></span>
	    </dd>
	    </div>
	    
	    <dt>
	      <label for="ano">ano</label>
	    </dt>
	    <dd>
			<select name="ano" id="ano" class="required round">
			<option value="">selecione</option>
			<? 
			for($i = date("Y") - 10; $i <= date("Y") + 5; $i++){?>
			<option value="<?=$i?>" <?=((@$projectVO["ano"] == $i)?('selected'):(''))?> ><?=$i;?></option>
			<?}?>
			</select>
			<span class='error'><?=($errors) ? $errors['ano'] : '';?></span>
	    </dd>
	    <dt>
	      <label for="description">descrição</label>
	    </dt>	    
	    <dd>
	      <textarea class="text required round" name="description" id="description" style="width:500px; height:60px;"><?=@$projectVO['description'];?></textarea>
	      <span class='error'><?=Arr::get($errors, 'description');?></span>
	    </dd>		 
	    <dd class="clear">
			<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />		      
	    </dd>
	    <?
	     if(!empty($projectVO['id'])){?>
		    <hr style="margin:8px 0;">
	    <?}?>
	    <div style="margin-top:10px;">
			<div class="tabs_holder">
				<ul class="tabs">
					<? foreach($anosList as $key=>$collection_ano){?>
					<li class="round"><a id='tab_<?=$key+1;?>' href="#collection_<?=$collection_ano->ano?>"><?=$collection_ano->ano?></a></li>
					<?}?>
				</ul>
			</div>
			<label>selecione as coleções</label>
			<div class="scrollable_content">
			<? foreach($anosList as $collection_ano){?>
				<div id="collection_<?=$collection_ano->ano?>" class="content_hide" >
					<table class="list">
						<thead>
							<th></th>
							<th>Op</th>
					        <th>Título</th>	
						</thead>
						<tbody>
					        <? foreach($collectionsList as $collection){
					        	if($collection_ano->ano == $collection->ano){
					        ?>
					        <tr>
					        	<td><input type="checkbox" name="selected[]" id="<?=$collection->op?> - <?=$collection->name?>" class="select" value="<?=$collection->id?>" <?=(in_array($collection->id, $collectionsArr)) ? "checked" : ""?>></td>
					            <td><label for="<?=$collection->op?> - <?=$collection->name?>" style="color:#000"><?=$collection->op?></label></td>
								<td><label for="<?=$collection->op?> - <?=$collection->name?>" style="color:#000"><?=$collection->name?></label></td>
							</tr>
					        <?}}?>
						</tbody>
					</table>
				</div>
			<?}?>	
			</div>			
		</div>
	</form>
</div>
