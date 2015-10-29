<form name="frmCreateStatusObj" id="frmCreateStatusObj" action="<?=URL::base();?>admin/status_objects/salvar/<?=@$statusVO["id"]?>" method="post" class="form" >
  <dl>
    <div>
        <label for="status">status</label>
        <dd>
            <input type="text" class="text required round" placeholder="novo status" name="status" id="status" style="width:300px;" value="<?=@$statusVO['status'];?>"/>
            <span class='error'><?=Arr::get($errors, 'status');?></span>
        </dd>  
    </div>
    <dd>
      <input type="submit" class="round bar_button" name="btnSubmit" id="btnSubmit" value="salvar" />
    </dd>
  </dl>
</form>
