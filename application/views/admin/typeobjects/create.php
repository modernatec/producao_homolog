<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/typeobjects" class="bar_button round">Voltar</a>
	</div>
        <?
        //print_r($errors);
        ?>
    <form name="frmCreateTipoObj" id="frmCreateTipoObj" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
            <dt> <label for="name">Nome</label> </dt>
            <dd>
                <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=@$typeObjectVO['name'];?>"/>
                <span class='error'><?=Arr::get($errors, 'name');?></span>
            </dd>            
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
