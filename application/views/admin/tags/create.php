<form name="frmCreateTipoObj" id="frmCreateTipoObj" action="<?=URL::base();?>admin/tags/salvar/<?=@$statusVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
  <dl>
    <label for="tag">tag</label>
    <dd>
        <input type="text" class="text required round" placeholder="tag" name="tag" id="tag" style="width:500px;" value="<?=@$statusVO['tag'];?>"/>
        <span class='error'><?=Arr::get($errors, 'status');?></span>
    </dd>  
    <div class="left">
        <label for="days">nº de dias</label>
        <dd>
            <input type="text" class="text required round" placeholder="nº de dias" name="days" id="days" style="width:60px;" value="<?=@$statusVO['days'];?>"/>
            <span class='error'><?=Arr::get($errors, 'days');?></span>
        </dd>   
    </div>
    <div class="left">
        <label for="hidden-input">cor</label>
        <dd>
            <input type="hidden" id="hidden-input" name="color" class="pickcolor" value="<?=@$statusVO['color'];?>">
            <span class='error'><?=Arr::get($errors, 'color');?></span>
        </dd>  

    </div>
    <div class="clear">
        <label >times</label>        
        <dd>
            <?foreach ($teamList as $team) {?>
            	<input type="checkbox" name="team[]" id="team_<?=$team->id?>" value="<?=$team->id?>" <?if(in_array($team->id, $teamsArray)){ echo "checked";}?>><label for="team_<?=$team->id?>"><?=$team->name;?></label>
            <?}?>
            <span class='error'><?=Arr::get($errors, 'class');?></span>
        </dd>
    </div>
    <dd>
      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="Salvar" />
    </dd>
  </dl>
</form>
