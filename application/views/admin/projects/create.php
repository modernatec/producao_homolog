<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/projects" class="bar_button round">Voltar</a>
	</div>
        <?
        if($message!=''){
        ?>
        <div class="<? if(count($errors)>0){ ?>error<? }else{ ?>ok<? }?>">
        	<p><?=$message?></p>
        </div>
        <?
        }
        
        $name = ($projeto->name) ? ($projeto->name) : (Arr::get($values, 'name'));
        $target = ($projeto->target) ? ($projeto->target) : (Arr::get($values, 'target'));
        $description = ($projeto->description) ? ($projeto->description) : (Arr::get($values, 'description'));
        
        ?>
    <form name="frmCreateProject" id="frmCreateProject" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	    <dt>
	      <label for="name">Projeto</label>
	    </dt>
	    <dd>
	      <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=$name;?>"/>
	      <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>
	    <dt>
	      <label for="target">Seguimento</label>
	    </dt>
	    <dd>
	      <input type="text" class="text required round" name="target" id="target" style="width:500px;" value="<?=$target;?>"/>
	      <span class='error'><?=Arr::get($errors, 'target');?></span>
	    </dd>
	    <dt>
	      <label for="description">Descrição</label>
	    </dt>	    
	    <dd>
	      <textarea class="text required round" name="description" id="description" style="width:500px; height:200px;"><?=$description;?></textarea>
	      <span class='error'><?=Arr::get($errors, 'description');?></span>
	    </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
