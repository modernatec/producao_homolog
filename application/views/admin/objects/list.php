<div class="topo">
	<div class="tabs_panel">
        <ul class="tabs">
            <li><a class="aba ajax" id="objects" href='<?=URL::base();?>admin/objects/getObjects'>OED</a></li>
            <?
            if (strpos($current_auth,'assistente') === false) {?>
            <li><a class="aba ajax" id="status" href='<?=URL::base();?>admin/status_objects/getListStatus'>status</a></li>
            <li><a class="aba ajax" id="tipos" href='<?=URL::base();?>admin/typeobjects'>tipos</a></li>
            <li><a class="aba ajax" id="formatos" href='<?=URL::base();?>admin/formats'>formatos</a></li>
            <li><a class="aba ajax" id="compartilhamentos" href='<?=URL::base();?>admin/repositorios'>repositórios</a></li>
            <?}?>
        </ul>  
    </div>
    <div id='filtros'></div>
</div>
<div id="esquerda">
    <div id="tabs_content" >
        
    </div>
</div>
<div id="direita"></div>