<div class="bar">
    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/suppliers/edit/<?=$fornecedorVO->id?>" rel="load-content" data-panel="#direita" class="bar_button round">editar</a>       
    <?}?>
</div>  
<div class="boxwired round" >
    <b><span class="wordwrap"><?=$fornecedorVO->empresa?></span></b><br/>
    <hr style="margin:8px 0;" />
        dd
    &bullet; ddd
    &bullet; dd
    <br/>
    <b>fechamento:</b> dd
</div>