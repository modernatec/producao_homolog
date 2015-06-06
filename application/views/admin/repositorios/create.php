    <form name="frmCreateRepo" id="frmCreateRepo" action="<?=URL::base();?>admin/repositorios/salvar/<?=@$objVO["id"]?>" method="post" class="form">
		  <dl>
        <dd>
            <input type="text" class="text required round" placeHolder="nome do repositório" name="name" id="name" style="width:500px;" value="<?=@$objVO['name'];?>"/>
            <span class='error'><?=Arr::get($errors, 'name');?></span>
        </dd>            
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="salvar" />
	    </dd>
	  </dl>
	</form>