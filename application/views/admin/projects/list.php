<div class="topo">
	<div class="tabs_panel">
        <ul class="tabs">
            <li><a class="aba ajax" id="projects" href='<?=URL::base();?>admin/projects/getList'>projetos</a></li>
            <?
            if (strpos($current_auth,'assistente') === false) {?>
            <li><a class="aba ajax" id="collections" href='<?=URL::base();?>admin/collections/getList'>coleções</a></li>
            <li><a class="aba ajax" id="segmentos" href='<?=URL::base();?>admin/segmentos'>segmentos</a></li>
            <li><a class="aba ajax" id="segmentos" href='<?=URL::base();?>admin/materias'>materias</a></li>
            <?}?>
        </ul>  
    </div>
    <div id='filtros'></div>
</div>
<div id="esquerda">
     
    <div id="tabs_content">
        
    </div>
</div>
<div id="direita"></div>