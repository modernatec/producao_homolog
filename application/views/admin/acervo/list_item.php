<div class="acervo_infos round">
    <div class="acervo_infos_header <?=$header_class;?> roundTop">
        <div class="collapse_holder left">
            <?if($header_class == ''){?>
            <a class="collapse icon icon_expand" data-show="infos<?=$objeto->id?>" title="abrir/fechar infos">collapse</a>
            <?}?>
        </div>
        <div class="left">
            <b><span class="wordwrap"><?=@$objeto->title;?></span></b><br/>
            <span class="wordwrap"><?=@$objeto->taxonomia;?></span>
        </div>
    </div>
    <div class="acervo_infos_opt infos<?=$objeto->id?> <?=$display?>">
        <?if($objeto->uploaded == 1){?>

        <a href='<?=URL::base();?>/admin/acervo/preview/<?=$objeto->id?>' data-rel="load-content" data-panel="#preview" class="icon icon_visualizar right load acervo_view">visualizar</a>
            
        <a href='<?=URL::base();?>/admin/acervo/acervoPreview/<?=$objeto->id?>' data-rel="load-content" class="icon icon_mesa right">mesa de luz</a>
            <?if($current_auth != "assistente" || $current_auth != "assistente 2" || $current_auth != "editor 1"){?>
            <a href='<?=URL::base();?>/admin/acervo/download/<?=$objeto->id?>' class="icon icon_baixar right">baixar</a>
            <?}?>
        <?
            }
        ?>
    </div>
    <div class="acervo_infos_content clear roundBottom ">
        <div class=" infos<?=$objeto->id?> <?=$display?>">
            
            <p><?=@$objeto->collection->name?></p>
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