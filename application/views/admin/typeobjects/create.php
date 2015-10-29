<form name="frmCreateTipoObj" id="frmCreateTipoObj" action="<?=URL::base();?>admin/typeobjects/salvar/<?=@$typeObjectVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
  <dl>
  	<label for="name">tipologia</label>
    <dd>
        <input type="text" class="text required round" placeholder="nova tipologia" name="name" id="name" style="width:500px;" value="<?=@$typeObjectVO['name'];?>"/>
        <span class='error'><?=Arr::get($errors, 'name');?></span>
    </dd>            
    <dd>
      <input type="submit" class="round bar_button" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
    </dd>
  </dl>
</form>
