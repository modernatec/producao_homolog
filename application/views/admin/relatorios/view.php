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
        <div class="left">
            <dt> <label for="origem">origem</label> </dt>
            <dd>
                <select class="required round" name="origem" id="origem">
                    <option value=''>Selecione</option>
                    <option value="0" >novo</option>
                    <option value="1" >reap.</option>
                </select>
                <span class='error'><?=Arr::get(@$errors, 'origem');?></span>
            </dd>
        </div>
        <div class="left">
            <dt> <label for="organizar">organizar por</label> </dt>
            <dd>
                <select class="required round" name="organizar" id="organizar">
                    <option value=''>Selecione</option>
                    <option value="collection_id" >coleção</option>
                    <option value="status_id" >status</option>
                    <option value="supplier_id" >produtora</option> 
                    <option value="typeobject_id" >tipo de objeto</option>                   
                </select>
                <span class='error'><?=Arr::get(@$errors, 'organizar');?></span>
            </dd>
        </div>
        <div class="clear">
            <input type="submit" class="round bar_button" value="gerar"> 
        </div>
    </form>
</div>