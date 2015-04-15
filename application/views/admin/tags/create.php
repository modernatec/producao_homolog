<form name="frmCreateTipoObj" id="frmCreateTipoObj" action="<?=URL::base();?>admin/tags/salvar/<?=@$statusVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
  <dl>
    <dd>
        <input type="text" class="text required round" placeholder="tipo do objeto" name="tag" id="tag" style="width:500px;" value="<?=@$statusVO['tag'];?>"/>
        <span class='error'><?=Arr::get($errors, 'status');?></span>
    </dd>  
    <dd>
        <input type="text" class="text required round" placeholder="css class" name="class" id="class" style="width:200px;" value="<?=@$statusVO['class'];?>"/>
        <span class='error'><?=Arr::get($errors, 'class');?></span>
    </dd>            
    <dd>
        <?foreach ($teamList as $team) {?>
        	<input type="checkbox" name="team[]" id="team_<?=$team->id?>" value="<?=$team->id?>" <?if(in_array($team->id, $teamsArray)){ echo "checked";}?>><label for="team_<?=$team->id?>"><?=$team->name;?></label>
        <?}?>
        <span class='error'><?=Arr::get($errors, 'class');?></span>
    </dd>
    <dd>
      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="Salvar" />
    </dd>
  </dl>
</form>
