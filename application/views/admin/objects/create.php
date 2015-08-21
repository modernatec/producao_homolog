<div class="clear">
<div class="bar">
	<a href="<?=URL::base();?>admin/objects/view/<?=@$objVO["id"]?>" rel="load-content" data-panel="#direita" class="bar_button round">Voltar</a>
</div>
<div class="scrollable_content">
    <form name="frmCreateObject" action="<?=URL::base();?>admin/objects/salvar/<?=@$objVO["id"]?>" id="frmCreateObject" method="post" data-panel="#direita" class="form" enctype="multipart/form-data">
      <dl>
            <dt> <label for="title">título</label></dt>
            <dd>
                <input type="text" class="text required round" name="title" id="title" style="width:500px;" value='<?=$objVO['title'];?>'/>
                <span class='error'><?=Arr::get($errors, 'title');?></span>
            </dd>
            <dt><label for="taxonomia">taxonomia</label></dt>
            <dd>
                <input type="text" class="text required round" name="taxonomia" id="taxonomia" style="width:300px;" value='<?=$objVO['taxonomia'];?>'/>
                <span class='error'><?=Arr::get($errors, 'taxonomia');?></span>
            </dd>
            <div class="left">
                <dt> <label for="project_id">projeto</label> </dt>
                <dd>
                    <select name="project_id" id="project_id" data-target="collection_id" data-url="admin/objects/getCollections" class="populate required round">
                        <option value=''>Selecione</option>
                        <? foreach($projectList as $projeto){?>
                            <option value='<?=$projeto->id?>' <?=((@$objVO["project_id"] == $projeto->id)?('selected'):(''))?> ><?=$projeto->name?></option>
                        <? }?>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'project_id');?></span>
                </dd>
            </div>
            <div class="left">
                <dt> <label for="collection_id">coleção</label> </dt>
                <dd>
                    <select class="required round" name="collection_id" id="collection_id" style="width:300px;">
                        <option value=''>Selecione</option>
                        <? foreach($collections as $collection){?>
                            <option value='<?=$collection->id?>' <?=((@$objVO["collection_id"] == $collection->id)?('selected'):(''))?> ><?=$collection->name?></option>
                        <? }?>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'collection_id');?></span>
                </dd>
            </div>
            
            <div class="clear left">
                <dt> <label for="fase">status</label> </dt>
                <dd>
                    <select class="required round" name="fase" id="fase">
                        <option value='1' <?=(($objVO['fase']== '1')?('selected="selected"'):(''))?>>em produção</option>
                        <option value='2' <?=(($objVO['fase']== '2')?('selected="selected"'):(''))?>>caiu</option>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'fase');?></span>
                </dd>  
            </div>
            <div class=" left">
                <dt> <label for="typeobject_id">tipo do objeto</label> </dt>
                <dd>
                    <select class="required round" name="typeobject_id" id="typeobject_id" style="width:200px;">
                        <option value=''>Selecione</option>
                        <? foreach($typeObjects as $type){?>
                            <option value='<?=$type->id?>' <?=((@$objVO["typeobject_id"] == $type->id)?('selected'):(''))?> ><?=$type->name?></option>
                        <? }?>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'tipo_obj');?></span>
                </dd>
            </div>
            <div class="left">
                <dt> <label for="workflow_id">workflow</label> </dt>
                <dd>
                    <select class="required round" name="workflow_id" id="workflow_id">
                        <option value=''>Selecione</option>
                        <? foreach($workflowList as $workflow){?>
                            <option value='<?=$workflow->id?>' <?=((@$objVO["workflow_id"] == $workflow->id)?('selected'):(''))?> ><?=$workflow->name?></option>
                        <? }?>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'workflow_id');?></span>
                </dd>
            </div>  
            <div class="clear left"> 
                <dt><label for="reaproveitamento">origem</label></dt>
                <dd>
                    <select class="required round" name="reaproveitamento" id="reaproveitamento" style="width:100px;">
                        <option value=''>Selecione</option>
                        <option value='0' <?=(($objVO['reaproveitamento'] == '0')?('selected="selected"'):(''))?>>novo</option>
                        <option value='1' <?=(($objVO['reaproveitamento'] == '1')?('selected="selected"'):(''))?>>reap.</option>
                        <option value='2' <?=(($objVO['reaproveitamento'] == '2')?('selected="selected"'):(''))?>>reap. integral</option>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'reaproveitamento');?></span>
                </dd> 
            </div>
            <div class="left">
                <dt><label for="taxonomia_reap">Taxonomia do reap.</label></dt>
                <dd>
                    <input type="text" class="text round" name="taxonomia_reap" id="taxonomia_reap" style="width:250px;" value='<?=$objVO['taxonomia_reap'];?>'/>
                    <span class='error'><?=Arr::get($errors, 'taxonomia_reap');?></span>
                </dd>  
            </div>
            <div class="clear">
                <dt><a href="<?=URL::base();?>admin/suppliers/getListSuppliers/true" class="popup"><span class='add'>produtoras (produção &bullet; áudio &bullet; arte)</span></a></dt>
                <input type="hidden" name="produtoras" id="sortable_produtoras" />
                <ul class="list_item connect_suppliers round sortable_produtoras drop" data-fill="sortable_produtoras" >
                    <?foreach ($suppliersList as $supplier_obj) {?>
                        <li class="dd-item" id="supplier-<?=$supplier_obj->supplier->id?>">
                            <div><p><b><?=$supplier_obj->supplier->empresa?></b></p></div>
                            <div class="clear left">
                                <div><label>serviço</label></div>
                                <select class="required round" name="services[]" style="width:100px;">
                                    <option value=''>serviço</option>
                                    <? foreach($services as $service){?>
                                        <option value='<?=$service->id?>' <?=($service->id == $supplier_obj->service_id) ? 'selected' : ''?> ><?=$service->name?></option>
                                    <?}?>
                                </select>
                            </div>
                            <?
                            if($current_auth != "assistente" && $current_auth != "assistente 2"){?>
                            <div class="left">
                                <div><label>valor</label></div>
                                <input type="text" name="valores[]" placeholder="valor" class="required money round" data-a-sep="." data-a-dec="," value="<?=$supplier_obj->amount?>" />
                            </div>
                            <div class="left">
                                <div><label>obs:</label></div>
                                <input type="text" name="produtora_obs[]" placeholder="obs" class="round" value="<?=$supplier_obj->obs?>" />
                            </div>
                            <?}?>
                        </li>
                    <?}?>
                </ul>                    
            </div>
            <div class="clear">
                <dt><a href="<?=URL::base();?>admin/contatos/getListContatos/true" class="popup"><span class='add'>créditos (roteiristas &bullet; locutores &bullet; ilustradores)</span></a></dt>
                <input type="hidden" name="creditos" id="sortable_creditos" />
                <ul class="list_item connect_contacts round sortable_creditos" data-fill="sortable_creditos" >
                    <?foreach ($contatosList as $contato) {?>
                        <li class="dd-item" id="contato-<?=$contato->id?>">
                            <div class="left" style="width:90px;">
                                <span class="list_faixa round blue"><?=$contato->service->name?></span>
                            </div>
                            <div>
                                 <b><?=$contato->nome?></b><br/>
                                <?=$contato->email?>
                            </div>
                        </li>
                    <?}?>
                </ul>                    
            </div>
            <div class="clear">
                <dt> <label for="obs">obsevações</label> </dt>
                <dd>
                    <textarea class="text round" name="obs" id="obs" style="width:500px; height:100px;"><?=$objVO['obs'];?></textarea>
                    <span class='error'><?=Arr::get($errors, 'obs');?></span>
                </dd>
            </div>
            <input type="hidden" name="country_id" value="1" />
            <!-- Brasil-->                   
            <div class="clear left"> 
                <dt><label for="arq_aberto">arquivo aberto</label></dt>
                <dd>
                    <select class="required round" name="arq_aberto" id="arq_aberto" style="width:100px;">
                        <option value=''>Selecione</option>
                        <option value='0' <?=(($objVO['arq_aberto'] == '0')?('selected="selected"'):(''))?>>Não</option>
                        <option value='1' <?=(($objVO['arq_aberto'] == '1')?('selected="selected"'):(''))?>>Sim</option>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'arq_aberto');?></span>
                </dd> 
            </div>
            <div class="left">
                <dt> <label for="interatividade">interatividade</label> </dt>
                <dd>
                    <select class="required round" name="interatividade" id="interatividade" style="width:100px;">
                        <option value=''>Selecione</option>
                        <option value='0' <?=(($objVO['interatividade']== '0')?('selected="selected"'):(''))?>>Não</option>
                        <option value='1' <?=(($objVO['interatividade']== '1')?('selected="selected"'):(''))?>>Sim</option>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'interatividade');?></span>
                </dd>
            </div>
            
            <div class="left">
                <dt> <label for="format_id">formato final</label> </dt>
                <dd>
                    <select class="required round" name="format_id" id="format_id">
                        <option value=''>Selecione</option>
                        <? foreach($formats as $format){?>
                            <option value='<?=$format->id?>' <?=((@$objVO["format_id"] == $format->id)?('selected'):(''))?> ><?=$format->name?></option>
                        <? }?>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'format_id');?></span>
                </dd>
            </div>  
            <div class="left">
                <dt> <label for="transcricao">transcrição de locução</label> </dt>
                <dd>
                    <select class="required round" name="transcricao" id="transcricao" style="width:100px;">
                        <option value='0' <?=(($objVO['transcricao']== '0')?('selected="selected"'):(''))?>>não</option>
                        <option value='1' <?=(($objVO['transcricao']== '1')?('selected="selected"'):(''))?>>sim</option>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'transcricao');?></span>
                </dd>  
            </div>
            
            <div class="clear left">
                <dt><label for="cap">capítulo</label></dt>
                <dd>
                    <input type="text" class="text round" name="cap" id="cap" style="width:50px;" value='<?=$objVO['cap'];?>'/>
                    <span class='error'><?=Arr::get($errors, 'cap');?></span>
                </dd>                
            </div>
            <div class="left">
                <dt><label for="uni">unidade</label></dt>
                <dd>
                    <input type="text" class="text round" name="uni" id="uni" style="width:50px;" value='<?=$objVO['uni'];?>'/>
                    <span class='error'><?=Arr::get($errors, 'uni');?></span>
                </dd>
            </div>
            <div class="left">
                <dt><label for="pagina">página</label></dt>
                <dd>
                    <input type="text" class="text round" name="pagina" id="pagina" style="width:50px;" value='<?=$objVO['pagina'];?>'/>
                    <span class='error'><?=Arr::get($errors, 'pagina');?></span>
                </dd>  
            </div>
            <div class="left">
                <dt><label for="tamanho">tam. (kb)</label></dt>
                <dd>
                    <input type="text" class="text round" name="tamanho" id="tamanho" style="width:50px;" value='<?=$objVO['tamanho'];?>'/>
                    <span class='error'><?=Arr::get($errors, 'tamanho');?></span>
                </dd>  
            </div>
            <div class="left">
                <dt><label for="duracao">duração</label></dt>
                <dd>
                    <input type="text" class="text round" name="duracao" id="duracao" style="width:50px;" value='<?=$objVO['duracao'];?>'/>
                    <span class='error'><?=Arr::get($errors, 'duracao');?></span>
                </dd>  
            </div>
            <div class="left"> 
                <dt><label for="cessao">cessão txt/img</label></dt>
                <dd>
                    <select class="round" name="cessao" id="cessao" style="width:100px;">
                        <option value='0' <?=(($objVO['cessao'] == '0')?('selected="selected"'):(''))?>>Não</option>
                        <option value='1' <?=(($objVO['cessao'] == '1')?('selected="selected"'):(''))?>>Sim</option>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'cessao');?></span>
                </dd> 
            </div>
            <div class="left">
                <dt> <label for="pnld">resultado PNLD</label> </dt>
                <dd>
                    <select class="required round" name="pnld" id="pnld">
                        <option value='1' <?=(($objVO['pnld']== '1')?('selected="selected"'):(''))?>>não se aplica</option>
                        <option value='2' <?=(($objVO['pnld']== '2')?('selected="selected"'):(''))?>>aprovado</option>
                        <option value='3' <?=(($objVO['pnld']== '3')?('selected="selected"'):(''))?>>reprovado</option>
                        <option value='4' <?=(($objVO['pnld']== '4')?('selected="selected"'):(''))?>>não avaliado</option>
                    </select>
                    <span class='error'><?=Arr::get($errors, 'pnld');?></span>
                </dd>  
            </div>
            <div class="clear">
                <dt>
                    <label >compartilhado com:</label>
                </dt>
                <dd>
                    <? foreach ($repoList as $repo) {?>
                        <input type="checkbox" name="repositorio[]" id="repo_<?=$repo->id?>" value="<?=$repo->id?>" <?=(in_array($repo->id, $repo_arr))? 'checked' : ''?> /><label for="repo_<?=$repo->id?>"><?=$repo->name?></label> 
                    <?}?>   

                  <span class='error'><?=Arr::get($errors, 'repositorio');?></span>
                </dd>

            </div>  
            <div class="clear">
                <dt> <label for="keywords">palavras chave</label> </dt>
                <dd>
                    <textarea class="text round" name="keywords" id="keywords" maxlength='250' style="width:500px; height:100px;"><?=$objVO['keywords'];?></textarea>
                    <span class='error'><?=Arr::get($errors, 'keywords');?></span>
                </dd>
            </div>
            
            <div class="clear">
                <dt> <label for="sinopse">sinopse</label> </dt>
                <dd>
                    <textarea class="text round" name="sinopse" id="sinopse" style="width:500px; height:100px;"><?=$objVO['sinopse'];?></textarea>
                    <span class='error'><?=Arr::get($errors, 'sinopse');?></span>
                </dd>
            </div>
        <dd>
          <input type="submit" class="round" name="btnCriar" id="btnCriar" value='salvar' />
        </dd>
      </dl>
    </form>
</div>
</div>