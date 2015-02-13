<div class="topo" >
    <span class="header">relatórios</span>
</div>
<div id="esquerda">
    <span class="header">relatórios</span>
    <form action="<?=URL::base();?>admin/relatorios/generate" method="post" class="form">
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
<div id="direita"></div>