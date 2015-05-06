<div class="clear">
    <div class="scrollable_content clear">  
        <ul class="list_item"> 
            <?
            foreach ($array_pathFoward as $objeto) {?>
                <li>
                    <a class="load" href="<?=URL::base().'admin/acervo/view/'.$objeto->id?>" rel="load-content" data-panel="#direita" title="+ informações">
                        <div>
                            <p><b><?=$objeto->title?></b></p><p><?=$objeto->taxonomia?></p>
                            <hr style="margin:8px 0;" />
                            
                            <p><?=$objeto->collection->name?></p>
                            <?if($objeto->reaproveitamento == 0){ 
                                $origem = "novo";
                            }elseif($objeto->reaproveitamento == 1){
                                $origem = "reap.";
                            }else{
                                $origem = "reap. integral";
                            }?>
                            <p>
                                <span class="blue round list_faixa left"><?=$objeto->collection->materia->name?></span>
                                <span class="blue round list_faixa left"><?=$objeto->collection->ano?></span>
                                <span class="blue round list_faixa "><?=$origem?></span>
                            </p>
                        </div>
                    </a>
                </li>
            <?};?>
        </ul>
        <div class="boxwired round" >
            <a class="collapse right" data-show="replies" title="abrir/fechar infos"><span class="collapse_ico">contrair</span></a>
            <b><span class="wordwrap"><?=@$obj->title;?></span></b><br/>
            <span class="wordwrap"><?=@$obj->taxonomia;?></span>
            <hr style="margin:8px 0;" />
            <span class="list_faixa light_blue round left"><?=@$obj->collection->name?></span>
            <?if($obj->reaproveitamento == 0){ 
                $origem = "novo";
            }elseif($obj->reaproveitamento == 1){
                $origem = "reap.";
            }else{
                $origem = "reap. integral";
            }?>
            <span class="list_faixa light_blue round left"><?=$origem?></span>
            <span class="list_faixa light_blue round left"><?=@$obj->typeobject->name;?></span>
            <span class="list_faixa cyan round"><?=@$obj->supplier->empresa?></span>
            <div class="clear">
                <p>
                    <span class='text_blue'>interatividade:</span> <?=(@$obj->interatividade == 0) ? 'Não' : 'Sim'; ?>
                    <span class='text_blue'>arquivos abertos:</span> <?=(@$obj->arq_aberto == 0) ? 'Não' : 'Sim'; ?>
                    <span class='text_blue'>cessão: </span> <?=(@$obj->cessao == 0) ? 'Não' : 'Sim'; ?>
                </p>
                <p>
                    <span class='text_blue'>unidade: </span> <?=(@$obj->uni != '') ? @$obj->uni : '-'; ?>
                    <span class='text_blue'>capítulo: </span> <?=(@$obj->cap != '') ? @$obj->cap : '-'; ?>  
                    <span class='text_blue'>página: </span> <?=(@$obj->pagina != '') ? @$obj->pagina : '-'; ?> 
                </p>
                <p>
                    <span class='text_blue'>tamanho: </span> <?=(@$obj->tamanho != '') ? @$obj->tamanho : '-'; ?> 
                    <span class='text_blue'>duração: </span> <?=(@$obj->duracao != '') ? @$obj->duracao : '-'; ?> 
                </p>
            </div>
        </div>
        <ul class="list_item">           
        <?
            foreach ($array_path as $objeto) {?>
                <li>
                    <a class="load" href="<?=URL::base().'admin/acervo/view/'.$objeto->id?>" rel="load-content" data-panel="#direita" title="+ informações">
                        <div>
                            <p><b><?=$objeto->title?></b></p><p><?=$objeto->taxonomia?></p>
                            <hr style="margin:8px 0;" />
                            
                            <p><?=$objeto->collection->name?></p>
                            <?if($objeto->reaproveitamento == 0){ 
                                $origem = "novo";
                            }elseif($objeto->reaproveitamento == 1){
                                $origem = "reap.";
                            }else{
                                $origem = "reap. integral";
                            }?>
                            <p>
                                <span class="blue round list_faixa left"><?=$objeto->collection->materia->name?></span>
                                <span class="blue round list_faixa left"><?=$objeto->collection->ano?></span>
                                <span class="blue round list_faixa "><?=$origem?></span>
                            </p>
                        </div>
                    </a>
                </li>
        <?};?>

        


        
        </ul>
    </div> 
</div>
