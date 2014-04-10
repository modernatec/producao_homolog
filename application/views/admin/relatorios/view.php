<div class="content">
    <span class="header">relatórios</span>
    <form action="<?=URL::base();?>admin/relatorios" method="post" class="form">
        <div class="left">
            <dt> <label for="project_id">projeto</label> </dt>
            <dd>
                <select class="required round" name="project_id" id="project_id">
                    <option value=''>Selecione</option>
                    <? foreach($projectList as $project){?>
                        <option value="<?=$project->id?>" ><?=$project->name?></option>
                    <? }?>
                </select>
                <span class='error'><?=Arr::get(@$errors, 'project_id');?></span>
            </dd>
        </div>
        <div class="clear">
            <input type="submit" class="round bar_button" value="gerar"> 
        </div>
    </form>
</div>