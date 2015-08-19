<form name="frmCreateCollection" id="frmCreateCollection" action="<?=URL::base();?>admin/collections/salvar/<?=@$collectionVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
  <dl>
    <div class="left">
      <dt>
        <label for="op">op</label>
      </dt>     
      <dd>
        <input type="text" class="text required round" name="op" id="op" style="width:50px;" value="<?=@$collectionVO['op'];?>"/>
        <span class='error'><?=Arr::get($errors, 'op');?></span>
      </dd>
    </div>
    <div class="left">
      <dt>
        <label for="name">coleção</label>
      </dt>
      <dd>
        <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=@$collectionVO['name'];?>"/>
        <span class='error'><?=Arr::get($errors, 'name');?></span>
      </dd>
    </div>  
    <div class="clear left">
      <dt>
        <label for="project_id">projeto</label>
      </dt>
      <dd>
        <select name="project_id" id="project_id" class="round">
              <option value="">selecione</option>
              <? foreach($projectList as $project){?>
              <option value="<?=$project->id?>" <?=((@$collectionVO["project_id"] == $project->id)?('selected'):(''))?> ><?=$project->name?></option>
              <? }?>
          </select>
          <span class='error'><?=($errors) ? $errors['segmento_id'] : '';?></span>
      </dd>
    </div>
    <div class="left">
      <dt>
        <label for="target">segmento</label>
      </dt>
      <dd>
        <select name="segmento_id" id="segmento_id" class="round">
              <option value="">selecione</option>
              <? foreach($segmentoList as $segmento){?>
              <option value="<?=$segmento->id?>" <?=((@$collectionVO["segmento_id"] == $segmento->id)?('selected'):(''))?> ><?=$segmento->name?></option>
              <? }?>
          </select>
          <span class='error'><?=($errors) ? $errors['segmento_id'] : '';?></span>
      </dd>
    </div>
    <div class="left">
      <dt>
        <label for="ano">ano</label>
      </dt>     
      <dd>
        <select name="ano" id="ano" class="round">
            <option value="">selecione</option>
            <? 
            for($i = date("Y") - 5; $i <= date("Y") + 5; $i++){?>
              <option value="<?=$i?>" <?=((@$collectionVO["ano"] == $i)?('selected'):(''))?> ><?=$i;?></option>
            <?}?>
        </select>
        <span class='error'><?=($errors) ? $errors['ano'] : '';?></span>
      </dd>
    </div>
    <div class="left">
      <dt>
        <label for="target">matéria</label>
      </dt>
      <dd>
        <select name="materia_id" id="materia_id" class="round">
              <option value="">selecione</option>
              <? foreach($materiaList as $materia){?>
              <option value="<?=$materia->id?>" <?=((@$collectionVO["materia_id"] == $materia->id)?('selected'):(''))?> ><?=$materia->name?></option>
              <? }?>
          </select>
          <span class='error'><?=($errors) ? $errors['materia_id'] : '';?></span>
      </dd>
    </div>
    <div class="left">
        <dt>
          <label for="fechamento">fechamento</label>
        </dt>	    
        <dd>
          <input type="text" class="text date round" name="fechamento" id="fechamento" style="width:80px;" value="<?=@$collectionVO['fechamento'];?>"/>
          <span class='error'><?=Arr::get($errors, 'fechamento');?></span>
        </dd>
    </div>
    <div class="clear">
      <?foreach ($teamList as $team) {?>
        <div class="left">
            <label for="team_<?=$team->id?>">responsável <?=$team->name?></label>
            <dd>
              <select name="team[]" id="team_<?=$team->id?>" class="round" style="width:150px;">
                  <option value="">selecione</option>
                  <? 
                    foreach($userList as $user){
                      if($user->team_id == $team->id){
                  ?>
                  <option value="<?=$user->id?>" <?=((array_key_exists($user->id, $collection_users)) ? ('selected') : (''))?> ><?=$user->nome?></option>
                  <?}}?>
              </select>
              <span class='error'><?=($errors) ? $errors['team'] : '';?></span>
            </dd>
        </div>
      <?}?>
    </div>

    <dd class='clear'>
      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="Salvar" />
    </dd>
  </dl>

<span class="list_faixa light_blue round left"><?=$collection->objects->count_all();?> OED</span>
<div class="scrollable_content clear">
  <?
    if(isset($workflows)){
    foreach ($workflows as $workflow) {
      $days = 0;
      $r = $workflow->name;
    ?>

      <span class='list_alert light_blue round'><?=$workflow->name?> (<?=$workflow->days?> dias)</span>
      <table width="100%" class="gray">
        <thead>
            <th width="60%">OED</th>
            <th width="20%">início</th>
            <th width="20%">fechamento</th>
        </thead>
        <tbody>
            <? foreach($objectList as $objeto){ 

              if($objeto->workflow_id == $workflow->id){?>
            <tr>
                <td width="60%" class="tl">
                  <a class="popup textGray" href="<?=URL::base().'admin/objects/showInfos/'.$objeto->id?>" title="+ informações">
                    <div><p><b><?=$objeto->title;?></b></p></div>
                    <p><?=$objeto->taxonomia;?></p>
                  </a>
                </td>
                <td width="20%">
                  <input type="hidden" name="objects[]" value="<?=$objeto->id?>" />
                  <input type="text" name="start[]" placeholder="início" id="start_<?=$objeto->id?>" data-days="<?=$workflow->days?>" data-target="end_<?=$objeto->id?>" class="crono date round" value="<?=Utils_Helper::data(@$objeto->crono_date,'d/m/Y')?>" />
                </td>
                <td width="20%">
                  
                  <input type="text" name="end[]" placeholder="término" id="end_<?=$objeto->id?>" data-days="-<?=$workflow->days?>" data-target="start_<?=$objeto->id?>" class="crono date round" value="<?=Utils_Helper::data(@$objeto->planned_date,'d/m/Y')?>" />
                </td>
            </tr>
            <?}}?>
        </tbody>
    </table>
    <hr style="margin:8px 0;" />
  <?}}?>
  
</div>  

</form>