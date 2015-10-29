<div class="header">
	<a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white" >fechar</div>
    </a>
    <span><?=$delete_msg?></span>
</div>
<div class="left panel_content" style="min-width:478px;">
	<p class="round panel_gray"><?=$repositorio->name?></p>
	<br/>
	
	<p><b>Atenção!</b></p>
	<p>Este repositório possuí <label><?=$total_objects?> OED</label>, é necessário movê-los para outro repositório:</p>
	<form name="frmDeleteRepositorio" id="frmDeleteRepositorio"  data-panel="#direita" action="<?=URL::base();?>admin/repositorios/delete/<?=$repositorio->id?>" method="post" class="form">
		<div>
            <dd>
	            <select name="repositorio_id" id="repositorio_id" class="required round" style="width:300px;" >
	                <option value="">selecione</option>
	                <? foreach($repositorioList as $repositorio){?>
	                    <option value="<?=$repositorio->id?>" ><?=$repositorio->name?></option>
	                <?}?>
	            </select>
	            <span class='error'><?=Arr::get($errors, 'repositorio_id');?></span>
	        </dd>				        
		</div>
        <dd>
          <input type="submit" class="round bar_button left" name="btnCriar" id="btnCriar" value="confirmar exclusão" />             
        </dd>	    
	</form>
</div>