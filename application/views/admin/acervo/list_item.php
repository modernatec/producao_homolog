<div>
    <p><b><?=$objeto->title?></b></p><p><?=$objeto->taxonomia?></p>
    <div class="replies" style="display:none;">

        <hr style="margin:8px 0;" />
    <a href='<?=URL::base();?>/admin/acervo/preview/<?=$objeto->id?>' class="bar_button gray round right view_oed">visualizar</a>
        
        <p><?=$objeto->collection->name?></p>
        <?if($objeto->reaproveitamento == 0){ 
            $origem = "novo";
        }elseif($objeto->reaproveitamento == 1){
            $origem = "reap.";
        }else{
            $origem = "reap. integral";
        }?>
        <div class="clear">
            <span class="list_faixa gray round left"><?=$objeto->collection->segmento->name?></span>
            <span class="list_faixa gray round left"><?=$objeto->collection->materia->name?></span>
            <span class="list_faixa gray round left"><?=$origem?></span>
            <span class="list_faixa gray round left"><?=@$objeto->typeobject->name;?></span>
            <span class="list_faixa gray round left"><?=@$objeto->collection->ano?></span>
            <span class="list_faixa gray round"><?=@$objeto->supplier->empresa?></span>
        </div>

        <table class="clear gray">
            <thead>
                <th>formato</th>
                <th>interatividade</th>
                <th>transcrição locução</th>
                <th>arquivos abertos</th>
                <th>cessão</th>
            </thead>
            <tbody>
                <tr>
                    <td><?=$objeto->format->name;?></td>
                    <td><?=(@$objeto->interatividade == 0) ? 'não' : 'sim'; ?></td>
                    <td><?=(@$objeto->transcricao == 0) ? 'não' : 'sim'; ?></td>
                    <td><?=(@$objeto->arq_aberto == 0) ? 'não' : 'sim'; ?></td>
                    <td><?=(@$objeto->cessao == 0) ? 'não' : 'sim'; ?></td>
                </tr>
            </tbody>
        </table>
        <table class=" gray">
            <thead>
                <th>unidade</th>
                <th>capítulo</th>
                <th>página</th>
                <th>tamanho</th>
                <th>duração</th>
                <th>resultado PNLD</th>
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
                <p class="clear">compartilhado com</p>
                <?
                foreach ($repos as $repo) {?>
                    <span class="list_faixa gray round left"><?=$repo->name?></span>
            <?  }
                }?>
        </div>  
    </div>  

</div>