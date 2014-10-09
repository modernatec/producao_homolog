<div class="bar">
    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/suppliers/edit/<?=$supplierVO['id']?>" rel="load-content" data-panel="#direita" class="bar_button round">editar</a>       
    <?}?>
</div>  
<div class="boxwired round" >
    <b><span class="wordwrap"><?=$supplierVO['empresa']?></span></b> | <a class="text_blue" target="_blank" href="http://<?=$supplierVO['site']?>"><?=$supplierVO['site']?></a>
    <hr style="margin:8px 0;" />
    <?
        foreach ($contactVO as $contato) {
            echo "<span class='text_blue'>&bullet; ".$contato['nome']."</span><br/>";
            echo " ".$contato['email']."<br/>";
            echo " ".$contato['telefone']."<br/><br/>";
        }
    ?>
    <? if($supplierVO['observacoes'] != ""){?>
        <b>observações</b>
        <hr style="margin:8px 0;" />
        <pre>
        <?=$supplierVO['observacoes']?>
        </pre>
    <?}?>
</div>