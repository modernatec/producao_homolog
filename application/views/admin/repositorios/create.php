    <form name="frmCreateRepo" id="frmCreateRepo" action="<?=URL::base();?>admin/repositorios/salvar/<?=@$objVO["id"]?>" method="post" class="form">
		<label for="name">repositório</label>
        <dd>
            <input type="text" class="text required round" placeHolder="novo repositório" name="name" id="name" style="width:500px;" value="<?=@$objVO['name'];?>"/>
            <span class='error'><?=Arr::get($errors, 'name');?></span>
        </dd>            
	    <dd>
	      <input type="submit" class="round bar_button" name="btnSubmit" id="btnSubmit" value="salvar" />
	    </dd>
	  
	</form>