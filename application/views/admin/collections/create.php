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
	      <label for="target">Matéria</label>
	    </dt>
	    <dd>
	      <select name="materia_id" id="materia_id" style="width:150px;">
                <option value="">selecione</option>
                <? foreach($materiaList as $materia){?>
                <option value="<?=$materia->id?>" <?=((@$collectionVO["materia_id"] == $materia->id)?('selected'):(''))?> ><?=$materia->name?></option>
                <? }?>
            </select>
            <span class='error'><?=($errors) ? $errors['materia_id'] : '';?></span>
	    </dd>
        <div class="left">
	        <dt>
		      <label for="op">OP</label>
		    </dt>	    
		    <dd>
		      <input type="text" class="text required round" name="op" id="op" style="width:50px;" value="<?=@$collectionVO['op'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'op');?></span>
		    </dd>
	    </div>
	    <div class="left">
		    <dt>
		      <label for="ano">Ano</label>
		    </dt>	    
		    <dd>
		      <input type="text" class="text required round" name="ano" id="ano" style="width:50px;" value="<?=@$collectionVO['ano'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'ano');?></span>
		    </dd>
	    </div>
	    <div class="left">
		    <dt>
		      <label for="fechamento">Fechamento</label>
		    </dt>	    
		    <dd>
		      <input type="text" class="text date round" name="fechamento" id="fechamento" style="width:80px;" value="<?=@$collectionVO['fechamento'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'fechamento');?></span>
		    </dd>
	    </div>
	    <dd class='clear'>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
