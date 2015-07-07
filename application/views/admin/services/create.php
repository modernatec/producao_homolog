    <form name="frmCreateService" id="frmCreateService" action="<?=URL::base();?>admin/services/salvar/<?=@$VO["id"]?>" method="post" class="form">
	  <dl>
        <dd>
            <input type="text" class="text required round" placeHolder="serviço" name="name" id="name" style="width:300px;" value="<?=@$VO['name'];?>"/>
            <span class='error'><?=Arr::get($errors, 'name');?></span>
        </dd>            
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="salvar" />
	    </dd>
	  </dl>
	</form>