<div class="topo" >
    <div class="tabs_panel">
        <ul class="tabs">
            <li><span><a class="aba ajax" id="supplier_1" href='<?=URL::base();?>admin/suppliers/getSuppliers'>fornecedores</a></span></li>
            <?
            if (strpos($current_auth,'assistente') === false) {?>
            <li><span><a class="aba ajax" id="supplier_2" href='<?=URL::base();?>admin/contatos/getContatos'>contatos</a></span></li>
            <li><span><a class="aba ajax" id="supplier_3" href='<?=URL::base();?>admin/services/getListServices'>serviços</a></span></li>
            <?}?>
        </ul>  
    </div>
    <div class="clear" id="filtros"></div>
</div>
<div id="esquerda">
    <div id="tabs_content">
        
    </div>
</div>
<div id="direita"></div>