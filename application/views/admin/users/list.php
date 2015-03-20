<div class="topo" >
    <span class="header">usuários</span>
</div>
<div id="esquerda">
    <div class="fixed clear">
        <?if($current_auth != "assistente" && $current_auth != "assistente 2" ){?>
        <div class="bar">
            <a href="<?=URL::base();?>admin/users/create" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar usuário</a>
        </div>   
        <?}?> 
        <div class="clear left">
            <ul class="tabs">
                <li class="round"><a class="ajax" id="tab_1" href='<?=URL::base();?>admin/users/getUsers/1'>ativos</a></li>
                <?
                if($current_auth != "assistente" && $current_auth != "assistente 2" ){?>
                <li class="round"><a class="ajax" id="tab_1" href='<?=URL::base();?>admin/users/getUsers/0'>inativos</a></li>
                <?}?>
            </ul>  
        </div>
        <div id="tabs_content" class="scrollable_content clear">
            
        </div>
    </div>
</div>
<div id="direita"></div>