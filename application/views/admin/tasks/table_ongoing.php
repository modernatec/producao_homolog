<span class="table_info round">
    <?=count($objectsList)?> objetos encontrados 
    <!--a class="bar_button round green" href='<?=URL::base();?>admin/tasks/'>limpar filtros</a-->
</span>
<table class="list">
        <thead>
            <th width="250">
                taxonomia
            </th>
            <th width="50">
                tipo
            </th>
            <th width="20">
                origem
            </th>
            <th width="100">
                produtora
            </th>
            <th width="50">
                matéria
            </th>
            <th width="300">
                coleção
            </th>
            <th width="50">
                status
            </th>
            <th width="50">retorno</th>
            <th width="50">fechamento</th>
            </form>
        </thead>
        <tbody>
            <? 
            if(count($objectsList) <= 0){
                echo '<tr><td colspan="10">nenhum registro encontrado</td></tr>';   
            }else{
            foreach($objectsList as $objeto){?>
            <tr>
                <? 
                    switch($objeto['status_id']){
                        case 1:
                            if(strtotime($objeto['retorno']) < strtotime(date("Y-m-d H:i:s"))){
                                $class_obj = "object_late";
                            }else{
                                $class_obj  = $objeto['statu_class'];
                            }
                            break;
                        case 2:
                            $mod = "";
                            if($objeto['supplier_id'] != 10){//producao externa
                                $mod = "_out";  
                            }else{
                                $mod = "_in"; 
                            }

                            if(strtotime($objeto['retorno']) < strtotime(date("Y-m-d H:i:s"))){
                                $class_obj = "object_late";
                            }else{
                                $class_obj  = $objeto['statu_class'].$mod;
                            }
                        
                            break;
                        case 8://finalizado
                            $class_obj  = $objeto['statu_class'];
                            $class      = $objeto['statu_class'];
                            break;  
                        default:
                            if(strtotime($objeto['retorno']) < strtotime(date("Y-m-d H:i:s"))){
                                $class_obj = "object_late";
                            }else{
                                $class_obj  = $objeto['statu_class'];
                            }
                    }
                ?>
                <td class="<?=$class_obj?>">
                    <a href="<?=URL::base().'admin/objects/view/'.$objeto['id'];?>" title="Editar"><?=$objeto['taxonomia']?> <br/><?=$objeto['title']?></a>
                </td>
                <td class="<?=$class_obj?>"><?=$objeto['typeobject_name']?></td>
                <td class="<?=$class_obj?>"><?=($objeto['reaproveitamento'] == '1') ? "reap." : "novo"?></td>
                <td class="<?=$class_obj?>"><?=$objeto['supplier_empresa']?></td>
                <td class="<?=$class_obj?>"><?=$objeto['materia_name']?></td>
                <td class="<?=$class_obj?>"><?=$objeto['collection_name']?></td>
                <td class="<?=$class_obj?>"><?=$objeto['statu_status']?></td>                
                <td class="<?=$class_obj?>"><?=Utils_Helper::data($objeto['retorno'],'d/m/Y')?></td>
                
                <td class="<?=$class_obj?>"><?=Utils_Helper::data($objeto['crono_date'],'d/m/Y')?></td>
            </tr>
            <?}
            }?>
        </tbody>
    </table>