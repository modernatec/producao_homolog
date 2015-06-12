<form name="frmTeam" id="frmTeam" method="post" class="form" action="<?=URL::base();?>admin/teams/salvar/<?=@$teamVO["id"]?>" enctype="multipart/form-data">
  <dl>
    <div class="left">
        <label for="name">Equipe</label>
      <dd>
        <input type="text" class="text round" name="name" id="name" style="width:200px;" value="<?=@$teamVO['name'];?>"/>
        <span class='error'><?=Arr::get($errors, 'name');?></span>
      </dd>	
    </div>
    <div class="left">
        <label for="hidden-input">cor</label>
        <dd>
            <input type="hidden" id="hidden-input" name="color" class="pickcolor" value="<?=@$teamVO['color'];?>">
            <span class='error'><?=Arr::get($errors, 'color');?></span>
        </dd>  

    </div>
    <div class="clear">
      <dt>
        <label for="name">Coordenador</label>
      </dt>
      <dd>
          <select name="userInfo_id" id="userInfo_id" class="round">
              <option value="">Selecione</option>
              <? foreach($userInfos as $userInfo){?>
                  <option value="<?=$userInfo->id?>" <?=((@$teamVO["userInfo_id"] == $userInfo->id)?('selected'):(''))?> ><?=ucfirst($userInfo->nome)?></option><? }?>
          </select>
        <span class='error'><?=Arr::get($errors, 'userInfo');?></span>
      </dd>	    
      <dd>
          <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
      </dd>
    </div>
  </dl>
</form>
