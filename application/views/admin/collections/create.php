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
              <select name="team[]" id="team_<?=$team->id?>" class="round" style="width:200px;">
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
</form>

<div class="scrollable_content">
  <table>
      <thead>
          <th>tax.</th>
          <th>tipo</th>
          <th>workflow</th>
          <th>início</th>
          <th>fechamento</th>
      </thead>
      <tbody>
          <? foreach($objectList as $objeto){?>
          <tr>
              <td>
                <p><b><?=$objeto->title;?></b></p>
                <p><?=$objeto->taxonomia;?></p>
              </td>
              <td>
                  <?
                    switch ($objeto->reaproveitamento) {
                      case '0':
                        echo 'novo';
                        break;
                      case '1':
                        echo 'reap.';
                        break;
                      case '2':
                        echo 'reap. integral';
                        break;  
                    }
                  ?>
              </td>
              <td><?=$objeto->workflow->name?></td>
              <td>i</td>
              <td>*</td>
          </tr>
          <?}?>
      </tbody>
  </table>
</div>  