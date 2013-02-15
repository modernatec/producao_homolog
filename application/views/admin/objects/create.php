<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/objects" class="bar_button round">Voltar</a>
	</div>
        <?
        //print_r($errors);
        ?>
    <form name="frmCreateObject" id="frmCreateObject" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
            <dt> <label for="nome_obj">Nome do Objeto</label> </dt>
            <dd>
                <input type="text" class="text required round" name="nome_obj" id="nome_obj" style="width:500px;" value="<?=$objVet['nome_obj'];?>"/>
                <span class='error'><?=Arr::get($errors, 'nome_obj');?></span>
            </dd>
            <dt> <label for="nome_arq">Nome do arquivo</label> </dt>
            <dd>
                <input type="text" class="text required round" name="nome_arq" id="nome_arq" style="width:500px;" value="<?=$objVet['nome_arq'];?>"/>
                <span class='error'><?=Arr::get($errors, 'nome_arq');?></span>
            </dd>
            <dt> <label for="typeobject_id">Tipo do objeto</label> </dt>
            <dd>
                <select class="required round" name="typeobject_id" id="typeobject_id" style="width:500px;">
                    <option value=''>Selecione</option>
                    <?=$objVet['tipo_obj'];?>
                </select>
                <span class='error'><?=Arr::get($errors, 'tipo_obj');?></span>
            </dd>
            <dt> <label for="colecao">Coleção</label> </dt>
            <dd>
                <input type="text" class="text required round" name="colecao" id="colecao" style="width:500px;" value="<?=$objVet['colecao'];?>"/>
                <span class='error'><?=Arr::get($errors, 'colecao');?></span>
            </dd>            
            <dt> <label for="countries">País</label> </dt>
            <dd>
                <select class="required round" name="country_id" id="country_id" style="width:500px;">
                    <option value=''>Selecione</option>
                    <?=$objVet['countries'];?>
                </select>
                <span class='error'><?=Arr::get($errors, 'country_id');?></span>
            </dd>
            
            <dt> <label for="empresa">Empresa</label> </dt>
            <dd>
                <input type="text" class="text required round" name="empresa" id="empresa" style="width:500px;" value="<?=$objVet['empresa'];?>"/>
                <span class='error'><?=Arr::get($errors, 'empresa');?></span>
            </dd>
            <dt> <label for="segmento_id">Segmento</label> </dt>
            <dd>
                <select class="required round" name="segmento_id" id="segmento_id" style="width:500px;">
                    <option value=''>Selecione</option>
                    <?=$objVet['segmento'];?>
                </select>
                <span class='error'><?=Arr::get($errors, 'segmento');?></span>
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
            <dt> <label for="sfwprodsList">Software de produção</label> </dt>
            <dd>
                <?=$objVet['sfwprodsList'];?>
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
            <dt> <label for="suppliersList">Produtora</label> </dt>
            <dd>
                <?=$objVet['suppliersList'];?>
                <span class='error'><?=Arr::get($errors, 'produtora');?></span>
            </dd>            
            <dt> <label for="materiasList">Matéria</label> </dt>
            <dd>
                <?=$objVet['materiasList'];?>
                <span class='error'><?=Arr::get($errors, 'materia');?></span>
            </dd>
            <dt> <label for="arq_aberto">Arquivo aberto</label></dt>
            <dd>
                <select class="required round" name="arq_aberto" id="arq_aberto" style="width:100px;">
                    <option value=''>Selecione</option>
                    <option value='0' <?=(($objVet['arq_aberto']==0)?('selected="selected"'):(''))?>>Não</option>
                    <option value='1' <?=(($objVet['arq_aberto']==1)?('selected="selected"'):(''))?>>Sim</option>
                </select>
                <span class='error'><?=Arr::get($errors, 'arq_aberto');?></span>
            </dd>
            <dt> <label for="extensao_arq">Extensão do arquivo</label> </dt>
            <dd>
                <input type="text" class="text required round" name="extensao_arq" id="extensao_arq" style="width:250px;" value="<?=$objVet['extensao_arq'];?>"/>
                <span class='error'><?=Arr::get($errors, 'extensao_arq');?></span>
            </dd>
            <dt> <label for="interatividade">Interatividade</label> </dt>
            <dd>
                <select class="required round" name="interatividade" id="interatividade" style="width:100px;">
                    <option value=''>Selecione</option>
                    <option value='0' <?=(($objVet['interatividade']==0)?('selected="selected"'):(''))?>>Não</option>
                    <option value='1' <?=(($objVet['interatividade']==1)?('selected="selected"'):(''))?>>Sim</option>
                </select>
                <span class='error'><?=Arr::get($errors, 'interatividade');?></span>
            </dd>
            <dt> <label for="data_lancamento">Data do lançamento</label> </dt>
            <dd>
                <input type="text" class="text round" name="data_lancamento" id="data_lancamento" style="width:100px;" value="<?=Utils_Helper::data($objVet['data_lancamento'])?>"/>
                <span class='error'><?=Arr::get($errors, 'data_lancamento');?></span>
            </dd>
            <dt> <label for="sinopse">Sinopse</label> </dt>
            <dd>
                <input type="text" class="text round" name="sinopse" id="sinopse" style="width:500px;" value="<?=$objVet['sinopse'];?>" maxlength="255"/>
                <span class='error'><?=Arr::get($errors, 'sinopse');?></span>
            </dd>
            <dt> <label for="obs">Observações</label> </dt>
            <dd>
                <textarea class="text round" name="obs" id="obs" style="width:500px; height:200px;"><?=$objVet['obs'];?></textarea>
                <span class='error'><?=Arr::get($errors, 'obs');?></span>
            </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>