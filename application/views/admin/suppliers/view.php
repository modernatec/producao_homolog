<div class="bar">
    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/suppliers/edit/<?=$supplierVO['id']?>" rel="load-content" data-panel="#direita" class="bar_button round">editar</a>       
    <?}?>
</div>  
<div class="boxwired round" >
    <b><span class="wordwrap"><?=$supplierVO['empresa']?></span></b> | <a class="text_blue" target="_blank" href="http://<?=$supplierVO['site']?>"><?=$supplierVO['site']?></a>
    <hr style="margin:8px 0;" />
    <?
        foreach ($contatos as $contato) {
            echo "<div class='box round'><p><span class='text_blue'>".$contato->nome."</span></p>";
            echo ($contato->email != '') ? "<p>".$contato->email."</p>" : '';
            echo ($contato->telefone != '') ?  "<p>".$contato->telefone."</p>" : '';
            echo '</div>';
        }
    ?>
    <? if($supplierVO['observacoes'] != ""){?>
        
        <hr style="margin:8px 0;" />
        <p><span class='text_blue'><b>observações</b></span></p>
        <?=$supplierVO['observacoes']?>
        
    <?}?>
</div>