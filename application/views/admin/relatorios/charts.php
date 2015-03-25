<div class="left">     
    <div class="list_body boxwired round" style="overflow:hidden; width:300px; height:500px;" >
        <span class='list_alert round'>fechamento por coleção <?=$project_title?></span>
        <div class="scrollable_content" data-bottom="false" style="height:460px;">
            <ul class="list_item">
            <?foreach ($collections as $col) {?>
                <li class="dd-item">
                    <p><?=$col->name?></p>
                    <p><span class="list_faixa red round"><?=Utils_Helper::data(@$col->fechamento,'d/m/Y')?></span> <span class="list_faixa red round"><?=$col->qtd?> objetos em aberto</span></p>
                </li>
            <?}?>
            </ul>
        </div>
    </div>
</div>
<div class="left" style="width:370px; overflow:hidden">  
	<div class="round grafico" style="overflow:hidden" id="tagQtd" data-chart='<?=$tagQtd?>' data-title='distribuição de tarefas <?=$project_title?>'></div>
	<div class="round grafico" style="overflow:hidden" id="statusQtd" data-chart='<?=$statusQtd?>' data-title='distribuição de objetos <?=$project_title?>'></div>
</div>