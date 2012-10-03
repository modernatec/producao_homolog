<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/curriculums" class="bar_button round">Voltar</a>
	</div>
        <?
        //print_r($errors);
        $name = ($curriculum->name) ? ($curriculum->name) : (Arr::get($values, 'name'));
        $objective = ($curriculum->objective) ? ($curriculum->objective) : (Arr::get($values, 'objective'));
        $description = ($curriculum->description) ? ($curriculum->description) : (Arr::get($values, 'description'));
        $file = ($curriculum->file) ? ($curriculum->file) : (Arr::get($values, 'file'));
        ?>
    <form name="frmCurriculum" id="frmCurriculum" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	    <dt>
	      <label for="name">Nome</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="name" id="name" style="width:500px;" value="<?=$name;?>"/>
	      <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>
            <dt>
	      <label for="objective">Objetivo</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="objective" id="objective" style="width:500px;" value="<?=$objective;?>"/>
	      <span class='error'><?=Arr::get($errors, 'objective');?></span>
	    </dd>
            <dt>
	      <label for="description">Descrição</label>
	    </dt>	    
	    <dd>
	      <textarea class="text required round" name="description" id="description" style="width:500px; height:200px;"><?=$description;?></textarea>
	      <span class='error'><?=Arr::get($errors, 'description');?></span>
	    </dd>
            <dt>
	      <label for="file">Arquivo</label>
	    </dt>
	    <dd>
	      <input type="file" name="file" id="file" />
	      <span class='error'><?=Arr::get($errors, 'file');?></span>
              <a href="<?=URL::base();?>admin/curriculums/download/<?=$curriculum->id?>"><?=basename($file);?></a>
	    </dd>	    
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
