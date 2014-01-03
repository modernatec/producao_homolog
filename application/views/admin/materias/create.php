<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/materias" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateMaterias" id="frmCreateMaterias" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
            <dt> <label for="nome">Matéria</label> </dt>
            <dd>
                <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=@$materiaVO['name'];?>"/>
                <span class='error'><?=Arr::get($errors, 'name');?></span>
            </dd>            
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
