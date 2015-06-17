    <form name="frmCreateFeriados" id="frmCreateFeriados" action="<?=URL::base();?>admin/feriados/salvar/<?=@$objVO["id"]?>" method="post" class="form">
	  <dl>
        <dd>
            <input type="text" class="text required round" placeHolder="nome do feriado" name="feriado" id="feriado" style="width:200px;" value="<?=@$objVO['feriado'];?>"/>
            <span class='error'><?=Arr::get($errors, 'name');?></span>
        </dd>  
        <dd>
            <input type="text" name="data" id="data" placeHolder="dd/mm/aaaa" class="required round date" style="width:100px;" value="<?=@$objVO['data']?>" />
            <span class='error'><?=Arr::get($errors, 'data');?></span>
        </dd>            
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" value="salvar" />
	    </dd>
	  </dl>
	</form>