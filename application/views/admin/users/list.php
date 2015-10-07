<div class="topo" >
    <!--div class="tabs_panel">
        <ul class="tabs">
            <li><a class="aba ajax" id="users_1" href='<?=URL::base();?>admin/users/getUsers/1'>ativos</a></li>
            <?
            if($current_auth != "assistente" && $current_auth != "assistente 2" ){?>
            <li><a class="aba ajax" id="users_2" href='<?=URL::base();?>admin/users/getUsers/0'>inativos</a></li>
            <?}?>
        </ul>  
     </div-->
     <div class="clear" id="filtros"></div>
</div>
<div id="esquerda">
    <?if($current_auth != "assistente" && $current_auth != "assistente 2" ){?>
    <div class="list_bar">
        <a href="<?=URL::base();?>admin/users/create" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar usuário</a>  
    </div>
    <?}?> 
    <div id="tabs_content">
        
    </div>
</div>
<div id="direita"></div>