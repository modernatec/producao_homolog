<div class="header">
    <a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white">fechar</div>
    </a>
    <span> Informações do OED</span>
</div>
<? if(count($array_pathFoward) > 0 || count($array_path) > 0 ){?>
<a class="collapse left round" data-show="replies" title="abrir/fechar infos"><span class="expand_ico">contrair</span></a>
<?}?>
<div class="panel_content clear left" style="width:400px;">
    <div class="clear">  
        <ul class="list_item"> 
            <?
            foreach ($array_pathFoward as $objeto) {?>
                <li>
                    <?
                        $view = View::factory('admin/acervo/list_item');
                        $view->objeto = $objeto;
                        $view->current_auth = $current_auth;
                        echo $view;
                    ?>
                </li>
            <?};?>
        </ul>
        <div class="acervo_infos round">
            <div class="acervo_infos_header acervo_infos_selected roundTop">
                <?if($obj->uploaded == 1){?>
                <!--a href='<?=URL::base();?>/admin/acervo/acervoPreview/<?=$obj->id?>' data-rel="load-content" data-panel="#preview" class="bar_button round right load acervo_view">visualizar</a-->
                <?if($current_auth != "assistente" || $current_auth != "assistente 2"){?>
                <!--a href='<?=URL::base();?>/admin/acervo/download/<?=$obj->id?>' class="bar_button round right">baixar</a-->
                <?
                        }
                    }
                ?>
                
                <b><span class="wordwrap"><?=@$obj->title;?></span></b><br/>
                <span class="wordwrap"><?=@$obj->taxonomia;?></span>
            </div>
            <div class="acervo_infos_content roundBottom">
                
                <p><?=@$obj->collection->name?></p>
                <?if($obj->reaproveitamento == 0){ 
                    $origem = "novo";
                }elseif($obj->reaproveitamento == 1){
                    $origem = "reap.";
                }else{
                    $origem = "reap. integral";
                }
                $tipo = explode('-', @$obj->typeobject->name);

                ?>
                <table width="100%">
                    <thead>
                        <th><span>segmento</span></th>
                        <th><span>matéria</span></th>
                        <th><span>origem</span></th>
                        <th><span>tipo</span></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$obj->collection->segmento->name?></td>
                            <td><?=$obj->collection->materia->name?></td>
                            <td><?=$origem?></td>
                            <td><?=$tipo['1']?></td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%">
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
                            <td><?=@$obj->collection->ano?></td>
                            <td><?=$obj->format->name;?></td>
                            <td><?=(@$obj->interatividade == 0) ? 'não' : 'sim'; ?></td>
                            <td><?=(@$obj->transcricao == 0) ? 'não' : 'sim'; ?></td>
                            <td><?=(@$obj->arq_aberto == 0) ? 'não' : 'sim'; ?></td>
                            <td><?=(@$obj->cessao == 0) ? 'não' : 'sim'; ?></td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%">
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
                            <td><?=(@$obj->uni != '') ? @$obj->uni : '-'; ?></td>
                            <td><?=(@$obj->cap != '') ? @$obj->cap : '-'; ?></td>
                            <td><?=(@$obj->pagina != '') ? @$obj->pagina : '-'; ?></td>
                            <td><?=(@$obj->tamanho != '') ? @$obj->tamanho : '-'; ?></td>
                            <td><?=(@$obj->duracao != '') ? @$obj->duracao : '-'; ?></td>
                            <td>
                                <?
                                    /*melhorar*/
                                    switch($obj->pnld){
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
                        $repos = $obj->repositorios->find_all();
                        if(count($repos) > 0){
                    ?>
                        <p class="text_cyan">compartilhado com</p>
                        <div class="acervo_repositorios">
                        <?
                        foreach ($repos as $repo) {?>
                            <span><?=$repo->name?></span>
                        <?}?>
                        </div>
                    <?}?>
                </div>
                <?if($obj->obs != ''){?>
                <div class="acervo_infos_item">
                    <p class="text_cyan">observações</p>
                    <?=@$obj->obs;?>
                </div>
                <?}
                if($obj->sinopse != ''){?>
                <div class="acervo_infos_item">
                    <p class="text_cyan">sinopse</p>
                    <?=@$obj->sinopse;?>
                </div>
                <?}
                if($obj->keywords != ''){?>
                <div class="acervo_infos_item">
                    <p class="text_cyan">palavras chave</p>
                    <?=@$obj->keywords;?>
                </div>
                <?}?>
                
            </div>
            <ul class="list_item">           
            <?
                foreach ($array_path as $objeto) {?>
                    <li>
                        <?
                            $view = View::factory('admin/acervo/list_item');
                            $view->objeto = $objeto;
                            $view->current_auth = $current_auth;
                            echo $view;
                        ?>
                    </li>
            <?};?>
            </ul>
        </div>
    </div> 
</div>
<div class="left hide" id="acervo_preview">
    <iframe class="iframe_body" frameBorder="0" scrolling="no" src="" allowtransparency="true" ></iframe>
</div>
