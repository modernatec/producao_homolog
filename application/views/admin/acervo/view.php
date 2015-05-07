<div class="clear">
    <div class="scrollable_content clear">  
        <ul class="list_item"> 
            <?
            foreach ($array_pathFoward as $objeto) {?>
                <li>
                    <div>
                        <p><b><?=$objeto->title?></b></p><p><?=$objeto->taxonomia?></p>
                        <div class="replies" style="display:none;">
                            <hr style="margin:8px 0;" />
                            
                            <p><?=$objeto->collection->name?></p>
                            <?if($objeto->reaproveitamento == 0){ 
                                $origem = "novo";
                            }elseif($objeto->reaproveitamento == 1){
                                $origem = "reap.";
                            }else{
                                $origem = "reap. integral";
                            }?>
                            <div class="clear">
                                <span class="list_faixa gray round left"><?=$objeto->collection->materia->name?></span>
                                <span class="list_faixa gray round left"><?=$origem?></span>
                                <span class="list_faixa gray round left"><?=@$objeto->typeobject->name;?></span>
                                <span class="list_faixa gray round left"><?=@$objeto->collection->ano?></span>
                                <span class="list_faixa gray round"><?=@$objeto->supplier->empresa?></span>
                            </div>
                            <table class="left gray">
                                <thead>
                                    <th>interatividade</th>
                                    <th>arquivos abertos</th>
                                    <th>cessão</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=(@$objeto->interatividade == 0) ? 'não' : 'sim'; ?></td>
                                        <td><?=(@$objeto->arq_aberto == 0) ? 'não' : 'sim'; ?></td>
                                        <td><?=(@$objeto->cessao == 0) ? 'não' : 'sim'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="left gray">
                                <thead>
                                    <th>unidade</th>
                                    <th>capítulo</th>
                                    <th>página</th>
                                    <th>tamanho</th>
                                    <th>duração</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=(@$objeto->uni != '') ? @$objeto->uni : '-'; ?></td>
                                        <td><?=(@$objeto->cap != '') ? @$objeto->cap : '-'; ?></td>
                                        <td><?=(@$objeto->pagina != '') ? @$objeto->pagina : '-'; ?></td>
                                        <td><?=(@$objeto->tamanho != '') ? @$objeto->tamanho : '-'; ?></td>
                                        <td><?=(@$objeto->duracao != '') ? @$objeto->duracao : '-'; ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>  

                    </div>
                </li>
            <?};?>
        </ul>
        <div class="boxwired_selected round">
            <a class="collapse right" data-show="replies" title="abrir/fechar infos"><span class="expand_ico">contrair</span></a>
            <b><span class="wordwrap"><?=@$obj->title;?></span></b><br/>
            <span class="wordwrap"><?=@$obj->taxonomia;?></span>
            <hr style="margin:8px 0;" />
            <?=@$obj->collection->name?>
            <?if($obj->reaproveitamento == 0){ 
                $origem = "novo";
            }elseif($obj->reaproveitamento == 1){
                $origem = "reap.";
            }else{
                $origem = "reap. integral";
            }?>
            <div class="clear">
                <span class="list_faixa cyan round left"><?=$obj->collection->materia->name?></span>
                <span class="list_faixa light_blue round left"><?=$origem?></span>
                <span class="list_faixa light_blue round left"><?=@$obj->typeobject->name;?></span>
                <span class="list_faixa light_blue round left"><?=@$obj->collection->ano?></span>
                <span class="list_faixa light_blue round"><?=@$obj->supplier->empresa?></span>
            </div>
            <table class="clear left">
                <thead>
                    <th>interatividade</th>
                    <th>arquivos abertos</th>
                    <th>cessão</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?=(@$obj->interatividade == 0) ? 'não' : 'sim'; ?></td>
                        <td><?=(@$obj->arq_aberto == 0) ? 'não' : 'sim'; ?></td>
                        <td><?=(@$obj->cessao == 0) ? 'não' : 'sim'; ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="left">
                <thead>
                    <th>unidade</th>
                    <th>capítulo</th>
                    <th>página</th>
                    <th>tamanho</th>
                    <th>duração</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?=(@$obj->uni != '') ? @$obj->uni : '-'; ?></td>
                        <td><?=(@$obj->cap != '') ? @$obj->cap : '-'; ?></td>
                        <td><?=(@$obj->pagina != '') ? @$obj->pagina : '-'; ?></td>
                        <td><?=(@$obj->tamanho != '') ? @$obj->tamanho : '-'; ?></td>
                        <td><?=(@$obj->duracao != '') ? @$obj->duracao : '-'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <ul class="list_item">           
        <?
            foreach ($array_path as $objeto) {?>
                <li>
                    <div>
                        <p><b><?=$objeto->title?></b></p><p><?=$objeto->taxonomia?></p>
                        <div class="replies" style="display:none;">
                            <hr style="margin:8px 0;" />
                            
                            <p><?=$objeto->collection->name?></p>
                            <?if($objeto->reaproveitamento == 0){ 
                                $origem = "novo";
                            }elseif($objeto->reaproveitamento == 1){
                                $origem = "reap.";
                            }else{
                                $origem = "reap. integral";
                            }?>
                            <div class="clear">
                                <span class="list_faixa gray round left"><?=$objeto->collection->materia->name?></span>
                                <span class="list_faixa gray round left"><?=$origem?></span>
                                <span class="list_faixa gray round left"><?=@$objeto->typeobject->name;?></span>
                                <span class="list_faixa gray round left"><?=@$objeto->collection->ano?></span>
                                <span class="list_faixa gray round"><?=@$objeto->supplier->empresa?></span>
                            </div>
                            <table class="left gray">
                                <thead>
                                    <th>interatividade</th>
                                    <th>arquivos abertos</th>
                                    <th>cessão</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=(@$objeto->interatividade == 0) ? 'não' : 'sim'; ?></td>
                                        <td><?=(@$objeto->arq_aberto == 0) ? 'não' : 'sim'; ?></td>
                                        <td><?=(@$objeto->cessao == 0) ? 'não' : 'sim'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="left gray">
                                <thead>
                                    <th>unidade</th>
                                    <th>capítulo</th>
                                    <th>página</th>
                                    <th>tamanho</th>
                                    <th>duração</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=(@$objeto->uni != '') ? @$objeto->uni : '-'; ?></td>
                                        <td><?=(@$objeto->cap != '') ? @$objeto->cap : '-'; ?></td>
                                        <td><?=(@$objeto->pagina != '') ? @$objeto->pagina : '-'; ?></td>
                                        <td><?=(@$objeto->tamanho != '') ? @$objeto->tamanho : '-'; ?></td>
                                        <td><?=(@$objeto->duracao != '') ? @$objeto->duracao : '-'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </li>
        <?};?>

        


        
        </ul>
    </div> 
</div>
