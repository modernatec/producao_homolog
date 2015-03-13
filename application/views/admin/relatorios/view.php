<div class="topo" >
    <span class="header">relatórios</span>
</div>
<div id="page">
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
        <div id="results"  class="scrollable clear" style="height:260px; overflow:auto; background:#ff0000">
            
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