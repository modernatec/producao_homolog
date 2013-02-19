<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/objects" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateObject" id="frmCreateObject" method="post" class="form" enctype="multipart/form-data">
	  <dl>
            <dt> <label for="nome_obj">título do objeto</label></dt>
            <dd>
                <input type="text" class="text required round" name="nome_obj" id="nome_obj" style="width:500px;" value="<?=$objVO['nome_obj'];?>"/>
                <span class='error'><?=Arr::get($errors, 'nome_obj');?></span>
            </dd>
            <dt><label for="nome_arq">taxonomia</label></dt>
            <dd>
                <input type="text" class="text required round" name="nome_arq" id="nome_arq" style="width:500px;" value="<?=$objVO['nome_arq'];?>"/>
                <span class='error'><?=Arr::get($errors, 'nome_arq');?></span>
            </dd>
            <dt> <label for="collection_id">coleção</label> </dt>
            <dd>
                <select class="required round" name="collection_id" id="collection_id">
                    <option value=''>Selecione</option>
                    <? foreach($collections as $collection){?>
                        <option value="<?=$collection->id?>" <?=((@$objVO["collection_id"] == $collection->id)?('selected'):(''))?> ><?=$collection->name?></option>
                    <? }?>
                </select>
                <span class='error'><?=Arr::get($errors, 'collection_id');?></span>
            </dd>   
            <dt> <label for="typeobject_id">tipo do objeto</label> </dt>
            <dd>
                <select class="required round" name="typeobject_id" id="typeobject_id">
                    <option value=''>Selecione</option>
                    <? foreach($typeObjects as $type){?>
                        <option value="<?=$type->id?>" <?=((@$objVO["typeobject_id"] == $type->id)?('selected'):(''))?> ><?=$type->nome?></option>
                    <? }?>
                </select>
                <span class='error'><?=Arr::get($errors, 'tipo_obj');?></span>
            </dd>
            <dt> <label for="empresa">produtora</label> </dt>
            <dd>
            	<select class="required round" name="supplier_id" id="supplier_id">
                    <option value=''>Selecione</option>
                    <? foreach($suppliers as $supplier){?>
                        <option value="<?=$supplier->id?>" <?=((@$objVO["supplier_id"] == $supplier->id)?('selected'):(''))?> ><?=$supplier->empresa?></option>
                    <? }?>
                </select>
                <span class='error'><?=Arr::get($errors, 'supplier_id');?></span>
            </dd>       
            <dt> <label for="countries">país</label> </dt>
            <dd>
                <select class="required round" name="country_id" id="country_id">
                    <option value=''>Selecione</option>
                    <? foreach($countries as $country){?>
                        <option value="<?=$country->id?>" <?=((@$objVO["country_id"] == $country->id)?('selected'):(''))?> ><?=$country->nome?></option>
                    <? }?>
                </select>
                <span class='error'><?=Arr::get($errors, 'country_id');?></span>
            </dd>            
            
            <dt> 
                <label for="ojectpai_id">Reaproveitamento</label> 
                <a href="javascript:;" id="btSlctObjtPai" class="bar_button round">Add</a> 
                <a href="javascript:;" id="btRmvObjtPai" class="bar_button round">Del</a>
            </dt>
            <dd>
                <p id="objectpai_txt"><?=$objVet['objectpai_txt'];?></p>
                <input type="hidden" name="objectpai_id" id="objectpai_id" value="<?=$objVet['ojectpai_id'];?>"/>
                <span class='error'><?=Arr::get($errors, 'ojectpai_id');?></span>
                
            </dd>            
            <dt> <label for="sfwprodsList">softwares de produção</label> </dt>
            <dd>
				<? foreach($softwares as $software){?>
                    <p><input type="checkbox" name="software_producao[]" id="softw_<?=$software->id?>" value="<?=$software->id?>" /><label for="softw_<?=$software->id?>" style='color:#000;'><?=$software->nome?></label></p>
                <? }?>
                <span class='error'><?=Arr::get($errors, 'software_producao');?></span>           
            </dd>
            <? /* Fluxo como tags
            <dd>
                <select class="round" name="sfwprodsList" id="sfwprodsList" onchange="addTag(this,'software_producao')" style="width:500px;">
                    <option value=''>Selecione</option>
                    <?=$objVet['sfwprodsList'];?>
                </select>
                <div class='tags' id="sfwprods">
                    <input type='hidden' name='software_producao' id='software_producao' value='' />
                    <div> <b>Flash</b> <a href=''>X</a> </div>
                    
                </div>
                <span class='error'><?=Arr::get($errors, 'software_producao');?></span>
            </dd>
             */?>                      
            <dt> <label for="materiasList">matérias</label> </dt>
            <dd>
                <? foreach($materias as $materia){?>
                    <p><input type="checkbox" name="materias[]" id="mat_<?=$materia->id?>" value="<?=$materia->id?>" /><label for="mat_<?=$materia->id?>" style='color:#000;'><?=$materia->nome?></label></p>
                <? }?>
                <span class='error'><?=Arr::get($errors, 'materia');?></span>
            </dd>
            <dt> <label for="arq_aberto">Arquivo aberto</label></dt>
            <dd>
                <select class="required round" name="arq_aberto" id="arq_aberto" style="width:100px;">
                    <option value=''>Selecione</option>
                    <option value='0' <?=(($objVO['arq_aberto'] == 0)?('selected="selected"'):(''))?>>Não</option>
                    <option value='1' <?=(($objVO['arq_aberto'] == 1)?('selected="selected"'):(''))?>>Sim</option>
                </select>
                <span class='error'><?=Arr::get($errors, 'arq_aberto');?></span>
            </dd>
            <dt> <label for="extensao_arq">Extensão do arquivo</label> </dt>
            <dd>
                <input type="text" class="text required round" name="extensao_arq" id="extensao_arq" style="width:250px;" value="<?=$objVO['extensao_arq'];?>"/>
                <span class='error'><?=Arr::get($errors, 'extensao_arq');?></span>
            </dd>
            <dt> <label for="interatividade">Interatividade</label> </dt>
            <dd>
                <select class="required round" name="interatividade" id="interatividade" style="width:100px;">
                    <option value=''>Selecione</option>
                    <option value='0' <?=(($objVO['interatividade']==0)?('selected="selected"'):(''))?>>Não</option>
                    <option value='1' <?=(($objVO['interatividade']==1)?('selected="selected"'):(''))?>>Sim</option>
                </select>
                <span class='error'><?=Arr::get($errors, 'interatividade');?></span>
            </dd>
            <dt> <label for="data_lancamento">Data do lançamento</label> </dt>
            <dd>
                <input type="text" class="text round" name="data_lancamento" id="data_lancamento" style="width:100px;" value="<?=$objVO['data_lancamento'];?>"/>
                <span class='error'><?=Arr::get($errors, 'data_lancamento');?></span>
            </dd>
            <dt> <label for="sinopse">Sinopse</label> </dt>
            <dd>
                <input type="text" class="text round" name="sinopse" id="sinopse" style="width:500px;" value="<?=$objVO['sinopse'];?>" maxlength="255"/>
                <span class='error'><?=Arr::get($errors, 'sinopse');?></span>
            </dd>
            <dt> <label for="obs">Observações</label> </dt>
            <dd>
                <textarea class="text round" name="obs" id="obs" style="width:500px; height:200px;"><?=$objVO['obs'];?></textarea>
                <span class='error'><?=Arr::get($errors, 'obs');?></span>
            </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>