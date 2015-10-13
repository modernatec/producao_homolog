<form name="frmTeam" id="frmTeam" method="post" class="form" action="<?=URL::base();?>admin/teams/salvar/<?=@$teamVO["id"]?>" enctype="multipart/form-data">
  <dl>
    <div class="left">
      <label for="name">time</label>
      <dd>
        <input type="text" class="text round" name="name" id="name" style="width:200px;" value="<?=@$teamVO['name'];?>"/>
        <span class='error'><?=Arr::get($errors, 'name');?></span>
      </dd>	
    </div>
    <div class="left">
        <label for="name">coordenador</label>
      <dd>
          <select name="userInfo_id" id="userInfo_id" class="round">
              <option value="">Selecione</option>
              <? foreach($userInfos as $userInfo){?>
                  <option value="<?=$userInfo->id?>" <?=((@$teamVO["userInfo_id"] == $userInfo->id)?('selected'):(''))?> ><?=ucfirst($userInfo->nome)?></option><? }?>
          </select>
        <span class='error'><?=Arr::get($errors, 'userInfo');?></span>
      </dd>   
        
    </div>
    <div class="clear left">
        <label for="hidden-input">cor 2</label>
        <dd>
            <input type="text" id="hue-demo" name="color2" class="pickcolor round" value="<?=@$teamVO['color2'];?>">
            <span class='error'><?=Arr::get($errors, 'color2');?></span>
        </dd>  
    </div>
    <div class="left">
      <label for="hidden-input">cor</label>
      <dd>
          <input type="text" id="hue-demo" name="color" class="pickcolor round" value="<?=@$teamVO['color'];?>">
          <span class='error'><?=Arr::get($errors, 'color');?></span>
      </dd>  
    </div>
    <div class="clear">
      <dd>
          <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
      </dd>
    </div>
  </dl>
</form>
