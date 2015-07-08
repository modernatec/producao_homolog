<div class="bar">
    <?if($current_auth != "assistente" && $current_auth != "assistente 2"){?>
        <a href="<?=URL::base();?>admin/suppliers/edit/<?=$VO['id']?>" rel="load-content" data-panel="#direita" class="bar_button round">editar</a>       
    <?}?>
</div>  
<div class="boxwired round" >
    <b><span class="wordwrap"><?=$VO['empresa']?></span></b> | <a class="text_blue" target="_blank" href="http://<?=$VO['site']?>"><?=$VO['site']?></a>
    <hr style="margin:8px 0;" />
    <?
        foreach ($contatos_suppliers as $cs) {
            echo "<div class='box left round' style='min-height:65px;'><p><span class='text_blue'>".$cs->contato->nome."</span></p>";
            echo ($cs->contato->email != '') ? "<p>".$cs->contato->email."</p>" : '';
            echo ($cs->contato->telefone != '') ?  "<p>".$cs->contato->telefone."</p>" : '';
            echo '</div>';
        }
    ?>
    <div class="clear" style="padding:4px 0;">
    
        
        <hr style="margin:8px 0;" />
        <p>
            <? foreach ($formats as $format) {?>
                <span class="list_faixa blue round left"><?=$format->format->name?></span> 
            <?}?>  
        </p>
        
    <? if($VO['observacoes'] != ""){?> 
        <p class="clear"><span class='text_blue'><b>observações</b></span></p>  
        <?=$VO['observacoes']?>
        
    <?}?>
    </div>
</div>