<div class="acervo_infos roundTop">
    <div class="acervo_infos_header <?=$header_class;?> roundTop">
        <div class="collapse_holder left">
            <?if($header_class == ''){?>
            <a class="collapse icon icon_expand" data-show="infos<?=$objeto->id?>" title="abrir/fechar infos">collapse</a>
            <?}?>
        </div>
        <div class="left title">
            <b><span class="wordwrap"><?=@$objeto->title;?></span></b><br/>
            <span class="wordwrap"><?=@$objeto->taxonomia;?></span>
        </div>
    </div>
    
    <div class="acervo_infos_opt infos<?=$objeto->id?> <?=$display?>">
        <?if($objeto->uploaded == 1){
            if($objeto->format->ext == '.pps'){
        ?>
            <a href='<?=URL::base();?>/admin/acervo/download/<?=$objeto->id?>' title="baixar" class="icon icon_baixar right">baixar</a>
        <?}else{?>
            <a href='<?=URL::base();?>/admin/acervo/preview/<?=$objeto->id?>' title="visualizar" class="icon icon_visualizar right acervo_view">visualizar</a>
        <?}?>

        <div class="filter right" >
            <ul>
                <li class="round" >
                    <span id="mesa<?=$objeto->id?>"><div class="icon icon_mesa" title="adicionar à mesa de luz" >add</div></span>
                    <div class="filter_panel_arrow"></div>
                    <div class="filter_panel round" data-position="right" >
                        <p class="text_cyan">adicionar à mesa de luz</p>
                        <div class="scrollable_content" data-bottom="false">
                            <ul>
                                <? 
                                foreach ($tables as $mesa) {
                                    $data_post = json_encode(array('object_id'=>$objeto->id, 'table_id'=>$mesa->id));
                                ?>                            
                                <li>
                                    <a class="post" href='<?=URL::base();?>/admin/tables/add/<?=$mesa->id?>' data-post='<?=$data_post;?>'><?=$mesa->name;?></a>
                                </li>
                                <?}?>
                            </ul>
                        </div>  
                        <div id="nova_mesa<?=$objeto->id?>" style='padding:5px 0; width:233px;'>
                            <a class="bar_button round load_panel" href='<?=URL::base();?>/admin/tables/edit/<?=$objeto->id?>' data-panel="#nova_mesa<?=$objeto->id?>" >nova mesa de luz</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <?if (strpos($current_auth,'assistente') === false && strpos($current_auth,'editor') === false && $objeto->format->ext !== '.pps') {?>
            <a href='<?=URL::base();?>/admin/acervo/download/<?=$objeto->id?>' title="baixar" class="icon icon_baixar right">baixar</a>
        <?}}?>
    </div>
    
    <div class="acervo_infos_content clear infos<?=$objeto->id?> <?=$display?>">
        <div class=" ">
            <table>
                <thead>
                    <th><span>OP</span></th>
                    <th><span>coleção</span></th>
                </thead>
                <tbody>
                    <tr>
                        <td><?=@$objeto->collection->op?></td>
                        <td><?=@$objeto->collection->name?></td>
                    </tr>
                </tbody>
            </table>
            <?if($objeto->reaproveitamento == 0){ 
                $origem = "novo";
            }elseif($objeto->reaproveitamento == 1){
                $origem = "reap.";
            }else{
                $origem = "reap. integral";
            }
            $tipo = explode('-', @$objeto->typeobject->name);

            ?>
            <table>
                <thead>
                    <th><span>segmento</span></th>
                    <th><span>matéria</span></th>
                    <th><span>origem</span></th>
                    <th><span>tipo</span></th>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$objeto->collection->segmento->name?></td>
                        <td><?=$objeto->collection->materia->name?></td>
                        <td><?=$origem?></td>
                        <td><?=$tipo['1']?></td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <th><span>ano de prod.</span></th>
                    <th><span>formato</span></th>
                    <th><span>interativo</span></th>
                    <th><span>legendado</span></th>
                    <th><span>editável</span></th>
                    <th><span>cessão</span></th>
                </thead>
                <tbody>
                    <tr>
                        <td><?=@$objeto->collection->ano?></td>
                        <td><?=$objeto->format->name;?></td>
                        <td><?=(@$objeto->interatividade == 0) ? 'não' : 'sim'; ?></td>
                        <td><?=(@$objeto->transcricao == 0) ? 'não' : 'sim'; ?></td>
                        <td><?=(@$objeto->arq_aberto == 0) ? 'não' : 'sim'; ?></td>
                        <td><?=(@$objeto->cessao == 0) ? 'não' : 'sim'; ?></td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <th><span>unidade</span></th>
                    <th><span>capítulo</span></th>
                    <th><span>página</span></th>
                    <th><span>tamanho</span></th>
                    <th><span>duração</span></th>
                    <th><span>res. PNLD</span></th>
                </thead>
                <tbody>
                    <tr>
                        <td><?=(@$objeto->uni != '') ? @$objeto->uni : '-'; ?></td>
                        <td><?=(@$objeto->cap != '') ? @$objeto->cap : '-'; ?></td>
                        <td><?=(@$objeto->pagina != '') ? @$objeto->pagina : '-'; ?></td>
                        <td><?=(@$objeto->tamanho != '') ? @$objeto->tamanho : '-'; ?></td>
                        <td><?=(@$objeto->duracao != '') ? @$objeto->duracao : '-'; ?></td>
                        <td>
                            <?
                                /*melhorar*/
                                switch($objeto->pnld){
                                    case '1':
                                        echo 'não se aplica';
                                        break;
                                    case '2':
                                        echo 'aprovado';
                                        break;
                                    case '3':
                                        echo 'reprovado';
                                        break;
                                    case '4':
                                        echo 'não avaliado';
                                        break;
                                }; 
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="clear">
                <?
                    $repos = $objeto->repositorios->find_all();
                    if(count($repos) > 0){
                ?>
                    <p class="text_cyan">compartilhado com</p>
                    <div class="line_itens">
                    <?
                    foreach ($repos as $repo) {?>
                        <span><?=$repo->name?></span>
                    <?}?>
                    </div>
                <?}?>
            </div>
            <?if($objeto->obs != ''){?>
            <div class="acervo_infos_item">
                <p class="text_cyan">observações</p>
                <?=@$objeto->obs;?>
            </div>
            <?}
            if($objeto->sinopse != ''){?>
            <div class="acervo_infos_item">
                <p class="text_cyan">sinopse</p>
                <?=@$objeto->sinopse;?>
            </div>
            <?}
            if($objeto->keywords != ''){?>
            <div class="acervo_infos_item">
                <p class="text_cyan">palavras chave</p>
                <?=@$objeto->keywords;?>
            </div>
            <?}?>
            
        </div>
    </div>
</div>