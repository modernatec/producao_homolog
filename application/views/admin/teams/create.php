<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/teams" class="bar_button round">Voltar</a>
	</div>
        <?
        //print_r($errors);
        $nome = ($team->name) ? ($team->name) : (Arr::get($values, 'name'));
        ?>
    <form name="frmTeam" id="frmTeam" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	    <dt>
	      <label for="name">Equipe</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="name" id="name" style="width:500px;" value="<?=$nome;?>"/>
	      <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>	    
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
