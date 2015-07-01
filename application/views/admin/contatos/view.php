<div class="bar">
    <?if($current_auth != "assistente"){?>
        <a href="<?=URL::base();?>admin/contatos/edit/<?=$VO['id']?>" rel="load-content" data-panel="#direita" class="bar_button round">editar</a>       
    <?}?>
</div>  
<div class="boxwired round" >
    <b><span class="wordwrap"><?=$VO['nome']?></span></b></a>
    <hr style="margin:8px 0;" />
</div>