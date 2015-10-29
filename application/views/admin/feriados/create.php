    <form name="frmCreateFeriados" id="frmCreateFeriados" action="<?=URL::base();?>admin/feriados/salvar/<?=@$objVO["id"]?>" method="post" class="form">
        <div class="left">
            <label>feriado</label>
            <dd>
                <input type="text" class="text required round" placeHolder="nome do feriado" name="feriado" id="feriado" style="width:200px;" value="<?=@$objVO['feriado'];?>"/>
                <span class='error'><?=Arr::get($errors, 'name');?></span>
            </dd>  
        </div>
        <div class="left">
            <label>data</label>
            <dd>
                <input type="text" name="data" id="data" placeHolder="dd/mm/aaaa" class="required round date" style="width:100px;" value="<?=@$objVO['data']?>" />
                <span class='error'><?=Arr::get($errors, 'data');?></span>
            </dd>            
        </div>
	    <dd class="clear">
	      <input type="submit" class="round bar_button" name="btnSubmit" value="salvar" />
	    </dd>
	
	</form>