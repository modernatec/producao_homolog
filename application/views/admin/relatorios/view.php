<div class="topo" >
    <span class="header">relatórios</span>
</div>
<div id="page">
    <div class="left">
        <div class="boxwired round" style="width:300px;overflow:auto" >
            <form action="<?=URL::base();?>admin/relatorios/generateStatus" method="post" class="form">
                <div class="left">
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
                <div class="left">
                    <input type="submit" class="round bar_button" value="gerar relatório"> 
                </div>
            </form>
        </div>
        <div class="boxwired round" style="width:300px; height:400px;" >
            <div style="overflow:auto">
                <form name="sync_gdocs" id="sync_gdocs" data-panel="#results" action="<?=URL::base();?>admin/relatorios/updateGdocs" method="post" class="form">
                    <div class="left">
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
                    <div class="left" >
                        <input type="submit" class="round bar_button" value="sync gdocs"> 
                    </div>
                </form>   
            </div>
            <div id="results" data-bottom="false">
                
            </div>     
        </div>
    </div>
    <div class="left">
        <div class="left boxwired round grafico" style="overflow:auto" id="tagQtd" data-chart='<?=$tagQtd?>' data-title='<?=$tagQtdTitle?>'></div>
        <div class="left boxwired round grafico" style="overflow:auto" id="statusQtd" data-chart='<?=$statusQtd?>' data-title='<?=$statusQtdTitle?>'></div>

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