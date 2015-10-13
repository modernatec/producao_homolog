<div class="topo" >
	<div class="tabs_panel">
        <ul class="tabs">
            <li><a class="aba ajax" id="infos" href='<?=URL::base();?>admin/users/getinfo/<?=$user->id?>'>informações pessoais</a></li>
            <li><a class="aba ajax" id="conta" href='<?=URL::base();?>admin/users/editPass/<?=$user->user_id?>'>login e senha</a></li>
        </ul>  
    </div>
    <div class="clear" id="filtros"></div>
</div>
<div id="page">    
    <div id="tabs_content">
        
    </div>
</div>