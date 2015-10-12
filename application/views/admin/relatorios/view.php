<div class="topo" >
    <div style="padding:7px; 0 0 5px;">
        <select class="required round" name="project_id" id="relatorios_project_id" data-url='<?=URL::base();?>admin/relatorios/geraGraficos' data-panel='#charts'>
            <option value=''>visão geral</option>
            <? foreach($projectList as $project){?>
                <option value="<?=$project->id?>" ><?=$project->name?></option>
            <?}?>
        </select>
        <?if($current_auth != "assistente"){?>
            <a href="#" id='generateStatus' class="bar_button round">gerar relatório</a>
        <?}?>
    </div>
</div>
<div id="page" >    
    <div class="scrollable_content">
        <form action="<?=URL::base();?>admin/relatorios/generateStatus" method="post" id='form_relatorio'>
            <input type="hidden" name='project_id' id='relatorio_project_id' />
        </form>
        <div id='charts' class="left">
            <?=$graficos?>
        </div> 
    </div>
</div>