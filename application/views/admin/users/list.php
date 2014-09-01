<div class="content">
    <div id="esquerda">
        <div class="fixed clear">
            <div class="bar">
                <a href="<?=URL::base();?>admin/users/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar usuário</a>
            </div>    
            <div class="clear left">
                <ul class="tabs">
                    <li class="round"><a class="ajax" id="tab_1" href='<?=URL::base();?>admin/users/getUsers/?nome=<?=$filter_nome?>&email=<?=$filter_email?>'>usuários</a></li>
                </ul>  
            </div>
            <div id="tabs_content" class="scrollable_content clear">
                
            </div>
        </div>
        
    </div>
    <div id="direita">
        
    </div>
</div>