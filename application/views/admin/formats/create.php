<form name="frmCreateSfwprod" id="frmCreateSfwprod" action="<?=URL::base();?>admin/format/edit/<?=@$sfwprodVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
  <dl>
    <dd>
        <input type="text" class="text required round" placeholder="nome do formato" name="name" id="name" style="width:500px;" value="<?=@$sfwprodVO['name'];?>"/>
        <span class='error'><?=Arr::get($errors, 'name');?></span>
    </dd>            
    <dd>
      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
    </dd>
  </dl>
</form>
