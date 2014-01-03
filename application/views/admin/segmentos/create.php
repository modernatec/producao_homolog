<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/segmentos" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateSegmento" id="frmCreateSegmento" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
            <dt> <label for="name">Segmento</label> </dt>
            <dd>
                <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=@$segmentoVO['name'];?>"/>
                <span class='error'><?=Arr::get($errors, 'name');?></span>
            </dd>            
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
