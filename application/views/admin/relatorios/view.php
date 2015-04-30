<div class="topo form" >
    <div style="padding:7px; 0 0 5px;">
        <select class="required round" name="project_id" id="relatorios_project_id" data-url='<?=URL::base();?>admin/relatorios/geraGraficos' data-panel='#charts'>
            <option value=''>visão geral</option>
            <? foreach($projectList as $project){?>
                <option value="<?=$project->id?>" ><?=$project->name?></option>
            <?}?>
        </select>
        <?if($current_auth != "assistente"){?>
            <a href="#" id='generateStatus' class="bar_button round">gerar relatório</a>
            <a href="#" id='updateGdocs' data-panel="#results" class="bar_button round">sync gdocs</a>
        <?}?>
    </div>
</div>
<div id="page" >
    <div class="scrollable_content">
        <form action="<?=URL::base();?>admin/relatorios/generateStatus" method="post" id='form_relatorio'>
            <input type="hidden" name='project_id' id='relatorio_project_id' />
        </form>
        
        <div class="left">     
            <div class="boxwired round" style="overflow:auto; width:300px; height:500px;" >
                <form name="sync_gdocs" id="sync_gdocs" data-panel="#results" action="<?=URL::base();?>admin/relatorios/updateGdocs" method="post">
                    <input type="hidden" name='project_id' id='gdocs_project_id' />
                </form>   
                <div id="results">
                    <span class='list_alert light_blue round'>resultados da sincronia com o google docs</span>
                </div>     
            </div>
        </div>
        <div id='charts' class="left">
            <?=$graficos?>
        </div> 
        

    </div>
</div>
<!--div id="esquerda">
    <span class="header">gerar relatórios</span>
    <form action="<?=URL::base();?>admin/relatorios/generateStatus" method="post" class="form">
        <div >
            <dd>
                <select class="required round" name="project_id" id="project_id">
                    <option value=''>selecione o projeto</option>
                    <? foreach($projectList as $project){?>
                        <option value="<?=$project->id?>" ><?=$project->name?></option>
                    <?}?>
                </select>
                <span class='error'><?=Arr::get(@$errors, 'project_id');?></span>
            </dd>
        </div>
        <div >
            <input type="submit" class="round bar_button" value="gerar relatório"> 
        </div>
    </form>
    <span class="header">sincronizar infos com gdocs</span>
    <form name="sync_gdocs" id="sync_gdocs" data-panel="#direita" action="<?=URL::base();?>admin/relatorios/updateGdocs" method="post" class="form">
        <div >
            <dd>
                <select class="required round" name="project_id" id="project_id">
                    <option value=''>selecione o projeto</option>
                    <? foreach($projectList as $project){?>
                        <option value="<?=$project->id?>" ><?=$project->name?></option>
                    <?}?>
                </select>
                <span class='error'><?=Arr::get(@$errors, 'project_id');?></span>
            </dd>
        </div>
        <div >
            <input type="submit" class="round bar_button" value="sync gdocs"> 
        </div>
    </form>
</div>
<div id="direita"></div-->