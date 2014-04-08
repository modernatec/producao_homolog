<div class="content">
    <div class="bar">
        <a href="<?=URL::base();?>admin/users/create" class="bar_button round">Criar usuário</a>
    </div>    
    <div id="tabs" class="clear">
        <ul>
            <li id="tab_1"><a href='<?=URL::base();?>admin/users/getUsers/?nome=<?=$filter_nome?>&email=<?=$filter_email?>'>usuários</a></li>
        </ul>
        
        <div id="tabs_content">
            
        </div>
    </div>
</div>