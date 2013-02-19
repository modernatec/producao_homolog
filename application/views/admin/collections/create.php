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
	      <label for="ano">ano</label>
	    </dt>	    
	    <dd>
	      <input type="text" class="text required round" name="year" id="year" style="width:100px;" maxlength="4" value="<?=@$collectionVO['year'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'year');?></span>
	    </dd>
	    <dt>
	      <label for="target">Seguimento</label>
	    </dt>
	    <dd>
	      <select name="segmento_id" id="segmento_id" style="width:150px;">
                <option value="">selecione</option>
                <? foreach($segmentosList as $segmento){?>
                <option value="<?=$segmento->id?>" <?=((@$collectionVO["segmento_id"] == $segmento->id)?('selected'):(''))?> ><?=$segmento->nome?></option>
                <? }?>
            </select>
            <span class='error'><?=($errors) ? $errors['segmento_id'] : '';?></span>
	    </dd>
	    
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
