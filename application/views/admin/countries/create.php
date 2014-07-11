<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/countries" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateCountry" id="frmCreateTipoObj" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
        <dd>
            <input type="text" class="text required round" placeholder="nome do país" name="name" id="name" style="width:500px;" value="<?=@$paisVO['name'];?>"/>
            <span class='error'><?=Arr::get(@$errors, 'name');?></span>
        </dd>            
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="Salvar" />
	    </dd>
	  </dl>
	</form>
</div>
