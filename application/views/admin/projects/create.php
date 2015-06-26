<form name="frmCreateProject" id="frmCreateProject" action="<?=URL::base();?>admin/projects/salvar/<?=@$projectVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="project_id" id="project_id" value="<?=@$projectVO["id"]?>">
    <dt>
      <label for="name">projeto</label>
    </dt>
    <dd>
      <input type="text" class="text required round" name="name" id="name" style="width:300px;" value="<?=@$projectVO['name'];?>"/>
      <span class='error'><?=Arr::get($errors, 'name');?></span>
    </dd>
    <div class="left">
	    <dt>
	      <label for="project_ano">ano</label>
	    </dt>
	    <dd>
			<select name="ano" id="project_ano" class="required round">
			<option value="">selecione</option>
			<? 
			for($i = date("Y") - 10; $i <= date("Y") + 5; $i++){?>
			<option value="<?=$i?>" <?=((@$ano == $i)?('selected'):(''))?> ><?=$i;?></option>
			<?}?>
			</select>
			<span class='error'><?=($errors) ? $errors['ano'] : '';?></span>
	    </dd>
   	</div>
    <div class="left">
	    <dt>
	      <label for="project_segmento">segmento</label>
	    </dt>
	    <dd>
	      <select name="segmento_id" id="project_segmento" class="required round" style="width:150px;">
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
    <div class="clear"> 
		<label>selecione as coleções</label>
		<div id="collections" style="height:340px; overflow:hidden">
		<?=$view_collections?>
		</div>			
	</div>
    <dd class="clear">
		<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="salvar" />		      
    </dd>
</form>
