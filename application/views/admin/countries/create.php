    <form name="frmCreatePais" id="frmCreatePais" action="<?=URL::base();?>admin/countries/edit/<?=@$paisVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
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
