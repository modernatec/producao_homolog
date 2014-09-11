    <form name="frmCreateMaterias" id="frmCreateMaterias" action="<?=URL::base();?>admin/materias/edit/<?=@$materiaVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
        <dd>
            <input type="text" class="text required round" placeHolder="nome da matéria" name="name" id="name" style="width:500px;" value="<?=@$materiaVO['name'];?>"/>
            <span class='error'><?=Arr::get($errors, 'name');?></span>
        </dd>            
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>