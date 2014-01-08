<div class="content">
	<div class="bar">
		<a href="<?=$_SERVER['HTTP_REFERER']?>" class="bar_button round">Voltar</a>
	</div>
	
	<form name="frmTask" id="frmTask" method="post" class="form" enctype="multipart/form-data">
	  <dl>
	  	<dt>
	      	<label for="title">título</label>
	    </dt>
	    <dd>
            <input type="text" class="text round" name="title" id="title" style="width:500px;" value="<?=@$taskVO['title']?>"/>
            <span class='error'><?=Arr::get($errors, 'title');?></span>
	    </dd>
	    
	    <dt>
	      	<label for="taxonomia">taxonomia</label>	
	    </dt>
	    <dd>
            <input type="text" class="text round" name="taxonomia" id="taxonomia" style="width:250px;"  value="<?=@$taskVO['taxonomia']?>"/>
	      	<span class='error'><?=Arr::get($errors, 'taxonomia');?></span>
	    </dd>
	    <dt>
	      	<label for="crono_date">data de entrega</label>
	    </dt>
	    <dd>
           	<input type="text" class="text round" name="crono_date" id="crono_date" style="width:100px;"  value="<?=@$taskVO['crono_date']?>"/>
	      	<span class='error'><?=Arr::get($errors, 'crono_date');?></span>
	    </dd>
	    <dt>
	      	<label for="project_id">projeto</label>
	    </dt>
	    <dd>
            <select name="project_id" id="project_id" style="width:150px;" onchange="getCollectionByProject(this.value)">
                <option value="">selecione</option>
                <? foreach($projectList as $project){?>
                <option value="<?=$project->id?>" <?=((@$taskVO["project_id"] == $project->id)?('selected'):(''))?>><?=$project->name?></option>
                <? }?>
            </select>
            <span class='error'><?=($errors) ? $errors['project_id'] : '';?></span>
	    </dd>
	    <dt>
	      	<label for="collection_id">coleção</label>
	    </dt>
	    <dd>
            <select name="collection_id" id="collection_id" style="width:150px;">
                <option value="">selecione</option>
                <?
                if(isset($taskVO["collection_id"])){
                 foreach($collectionList as $collection){?>
                	<option value="<?=$collection->id?>" <?=((@$taskVO["collection_id"] == $collection->id)?('selected'):(''))?>><?=$collection->name?></option>
                <? }}?>
            </select>
            <span class='error'><?=($errors) ? $errors['collection_id'] : '';?></span>
	    </dd>
	    
	    <dt>
	      	<label for="supplier_id">estúdio</label>
	    </dt>
	    <dd>
             <select name="supplier_id" id="supplier_id" style="width:150px;">
                <option value="">selecione</option>
                <?
                 foreach($supplierList as $supplier){?>
                	<option value="<?=$supplier->id?>" <?=((@$taskVO["supplier_id"] == $supplier->id)?('selected'):(''))?>><?=$supplier->empresa?></option>
                <? }?>
            </select>
            <span class='error'><?=($errors) ? $errors['supplier_id'] : '';?></span>
	    </dd>
	    <dt>
	      	<label for="typeobject_id">tipo</label>
	    </dt>
	    <dd>
            <select name="typeobject_id" id="typeobject_id" style="width:150px;">
                <option value="">selecione</option>
                <?
                 foreach($typeObjList as $typeobj){?>
                	<option value="<?=$typeobj->id?>" <?=((@$taskVO["typeobject_id"] == $typeobj->id)?('selected'):(''))?>><?=$typeobj->name?></option>
                <? }?>
            </select>
            <span class='error'><?=($errors) ? $errors['typeobject_id'] : '';?></span>
	    </dd>
		<dt>
	      	<label for="source">origem</label>
	    </dt>
	    <dd>
            <input type="text" class="text round" name="source" id="source" style="width:250px;"  value="<?=@$taskVO['source']?>"/>
	      	<span class='error'><?=Arr::get($errors, 'source');?></span>
	    </dd>
	    <dt>
	      	<label for="vol_ano">volume/ano</label>
	    </dt>
	    <dd>
            <input type="text" class="text round" name="vol_ano" id="vol_ano" style="width:20px;"  value="<?=@$taskVO['vol_ano']?>"/>
	      	<span class='error'><?=Arr::get($errors, 'vol_ano');?></span>
	    </dd>
	    <dt>
	      	<label for="uni">unidade</label>
	    </dt>
	    <dd>
            <input type="text" class="text round" name="uni" id="uni" style="width:40px;"  value="<?=@$taskVO['uni']?>"/>
	      	<span class='error'><?=Arr::get($errors, 'uni');?></span>
	    </dd>
	    <dt>
	      	<label for="cap">capitulo</label>
	    </dt>
	    <dd>
            <input type="text" class="text round" name="cap" id="cap" style="width:40px;"  value="<?=@$taskVO['cap']?>"/>
	      	<span class='error'><?=Arr::get($errors, 'cap');?></span>
	    </dd>
	    <dt>
            <label for="obs">observações</label>
        </dt>
        <dd>
          <textarea class="text round" name="obs" id="obs" style="width:500px; height:200px;"></textarea>
          <span class='error'><?=Arr::get($errors, 'description');?></span>
        </dd>
        
        <dd>
          <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<?=(@$isUpdate) ? 'Salvar' : 'Criar'?>" />
        </dd>
	    
	  </dl>
	</form>
</div>