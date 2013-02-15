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
                <input type="text" class="text required round" name="nome_obj" id="nome_obj" style="width:500px;" value="<?=$objVet['nome_obj'];?>" disabled="disabled" />
            </dd>
            <dt> <label for="nome_arq">Nome do arquivo</label> </dt>
            <dd>
                <input type="text" class="text required round" name="nome_arq" id="nome_arq" style="width:500px;" value="<?=$objVet['nome_arq'];?>" disabled="disabled" />
            </dd>
            <dt> <label for="typeobject_id">Tipo do objeto</label> </dt>
            <dd>
                <select class="required round" name="typeobject_id" id="typeobject_id" style="width:500px;" disabled="disabled">
                    <option value=''>Selecione</option>
                    <?=$objVet['tipo_obj'];?>
                </select>
            </dd>
            <dt> <label for="colecao">Coleção</label> </dt>
            <dd>
                <input type="text" class="text required round" name="colecao" id="colecao" style="width:500px;" value="<?=$objVet['colecao'];?>" disabled="disabled" />
            </dd>            
            <dt> <label for="countries">País</label> </dt>
            <dd>
                <select class="required round" name="country_id" id="country_id" style="width:500px;" disabled="disabled" >
                    <option value=''>Selecione</option>
                    <?=$objVet['countries'];?>
                </select>
            </dd>
            
            <dt> <label for="empresa">Empresa</label> </dt>
            <dd>
                <input type="text" class="text required round" name="empresa" id="empresa" style="width:500px;" value="<?=$objVet['empresa'];?>" disabled="disabled" />
            </dd>
            <dt> <label for="segmento_id">Segmento</label> </dt>
            <dd>
                <select class="required round" name="segmento_id" id="segmento_id" style="width:500px;" disabled="disabled">
                    <option value=''>Selecione</option>
                    <?=$objVet['segmento'];?>
                </select>
            </dd>
            <dt> 
                <label for="ojectpai_id">Reaproveitamento</label>                 
            </dt>
            <dd>
                <p id="objectpai_txt"><?=$objVet['objectpai_txt'];?></p>
                <input type="hidden" name="objectpai_id" id="objectpai_id" value="<?=$objVet['ojectpai_id'];?>"/>                
            </dd>            
            <dt> <label for="sfwprodsList">Software de produção</label> </dt>
            <dd>
                <?=$objVet['sfwprodsList'];?>
                <span class='error'><?=Arr::get($errors, 'software_producao');?></span>
            </dd>          
            <dt> <label for="suppliersList">Produtora</label> </dt>
            <dd>
                <?=$objVet['suppliersList'];?>
            </dd>            
            <dt> <label for="materiasList">Matéria</label> </dt>
            <dd>
                <?=$objVet['materiasList'];?>
            </dd>
            <dt> <label for="arq_aberto">Arquivo aberto</label></dt>
            <dd>
                <select class="required round" name="arq_aberto" id="arq_aberto" style="width:100px;" disabled="disabled">
                    <option value=''>Selecione</option>
                    <option value='0' <?=(($objVet['arq_aberto']==0)?('selected="selected"'):(''))?>>Não</option>
                    <option value='1' <?=(($objVet['arq_aberto']==1)?('selected="selected"'):(''))?>>Sim</option>
                </select>
            </dd>
            <dt> <label for="extensao_arq">Extensão do arquivo</label> </dt>
            <dd>
                <input type="text" class="text required round" name="extensao_arq" id="extensao_arq" style="width:250px;" value="<?=$objVet['extensao_arq'];?>" disabled="disabled" />
            </dd>
            <dd>
                <select class="required round" name="interatividade" id="interatividade" style="width:100px;" disabled="disabled" >
                    <option value=''>Selecione</option>
                    <option value='0' <?=(($objVet['interatividade']==0)?('selected="selected"'):(''))?>>Não</option>
                    <option value='1' <?=(($objVet['interatividade']==1)?('selected="selected"'):(''))?>>Sim</option>
                </select>
            </dd>
            <dt> <label for="data_lancamento">Data do lançamento</label> </dt>
            <dd>
                <input type="text" class="text round" name="data_lancamento" id="data_lancamento" style="width:100px;" value="<?=Utils_Helper::data($objVet['data_lancamento'])?>" disabled="disabled" />
            </dd>
            <dt> <label for="sinopse">Sinopse</label> </dt>
            <dd>
                <input type="text" class="text round" name="sinopse" id="sinopse" style="width:500px;" value="<?=$objVet['sinopse'];?>" maxlength="255" disabled="disabled" />
            </dd>
            <dt> <label for="obs">Observações</label> </dt>
            <dd>
                <textarea class="text round" name="obs" id="obs" style="width:500px; height:200px;" disabled="disabled"><?=$objVet['obs'];?></textarea>
            </dd>
	  </dl>
	</form>
</div>