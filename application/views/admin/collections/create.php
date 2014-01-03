<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/collections" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateCollection" id="frmCreateCollection" method="post" class="form" enctype="multipart/form-data">
	  <dl>
	    <dt>
	      <label for="name">coleção</label>
	    </dt>
	    <dd>
	      <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=@$collectionVO['name'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>
        <dt>
	      <label for="op">OP</label>
	    </dt>	    
	    <dd>
	      <input type="text" class="text required round" name="op" id="op" style="width:300px;" value="<?=@$collectionVO['op'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'op');?></span>
	    </dd>
	    <dt>
	      <label for="project_id">projeto</label>
	    </dt>
	    <dd>
	      <select name="project_id" id="project_id" style="width:150px;">
                <option value="">selecione</option>
                <? foreach($projectList as $project){?>
                <option value="<?=$project->id?>" <?=((@$collectionVO["project_id"] == $project->id)?('selected'):(''))?> ><?=$project->name?></option>
                <? }?>
            </select>
            <span class='error'><?=($errors) ? $errors['project_id'] : '';?></span>
	    </dd>
	    
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
