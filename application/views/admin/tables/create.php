<form name="frmCreateTable" id="frmCreateTable" action="<?=URL::base();?>admin/tables/salvar/" method="post" class="form">
    <input type="hidden" name="object_id" value="<?=$object_id?>">
    <input type="text" class="text required round" placeHolder="nova mesa de luz" name="name" id="name" />
    <input type="submit" class="right round" name="btnSubmit" id="btnSubmit" value="salvar" />                              
</form>