<div class="topo" >
    <span class="header">
    <?if($current_auth != "assistente" && $current_auth != "assistente 2" ){?>
        <a href="<?=URL::base();?>admin/users/create" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar usuário</a>
    <?}?> 
    </span>
</div>
<div id="esquerda">
    <ul class="tabs">
        <li class="round"><a class="ajax" id="tab_1" href='<?=URL::base();?>admin/users/getUsers/1'>ativos</a></li>
        <?
        if($current_auth != "assistente" && $current_auth != "assistente 2" ){?>
        <li class="round"><a class="ajax" id="tab_2" href='<?=URL::base();?>admin/users/getUsers/0'>inativos</a></li>
        <?}?>
    </ul>  
    <div id="tabs_content">
        
    </div>
</div>
<div id="direita"></div>