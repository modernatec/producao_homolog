<form name="frmTeam" id="frmTeam" method="post" class="form" action="<?=URL::base();?>admin/teams/edit/<?=@$teamVO["id"]?>" enctype="multipart/form-data">
  <dl>
    <dt>
      <label for="name">Equipe</label>
    </dt>
    <dd>
      <input type="text" class="text round" name="name" id="name" style="width:500px;" value="<?=@$teamVO['name'];?>"/>
      <span class='error'><?=Arr::get($errors, 'name');?></span>
    </dd>	
    <dt>
      <label for="name">Coordenador</label>
    </dt>
    <dd>
        <select name="userInfo_id" id="userInfo_id">
            <option value="">Selecione</option>
            <? foreach($userInfos as $userInfo){?>
                <option value="<?=$userInfo->id?>" <?=((@$teamVO["userInfo_id"] == $userInfo->id)?('selected'):(''))?> ><?=ucfirst($userInfo->nome)?></option><? }?>
        </select>
      <span class='error'><?=Arr::get($errors, 'userInfo');?></span>
    </dd>	    
    <dd>
        <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
    </dd>
  </dl>
</form>
