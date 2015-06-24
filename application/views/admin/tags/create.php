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
            <input type="text" id="hue-demo" name="color" class="pickcolor round" value="<?=@$statusVO['color'];?>">
            <span class='error'><?=Arr::get($errors, 'color');?></span>
        </dd>  

    </div>
    <div class="left">
        <label for="sync">concomitante</label>
        <dd>
            <select class="required round" name="sync" id="sync" >
                <option value='0' <?=(($statusVO['sync']== '0')?('selected="selected"'):(''))?>>não</option>
                <option value='1' <?=(($statusVO['sync']== '1')?('selected="selected"'):(''))?>>sim</option>
            </select>
            <span class='error'><?=Arr::get($errors, 'sync');?></span>
        </dd>  
    </div>
    <div class="clear left">
        <label for="next_tag_id">ação automática</label>
        <dd>
            <select class="required round" name="next_tag_id" id="next_tag_id" >
                <option value='0' >nenhuma</option>
                <?foreach ($tagsList as $key => $tag) {?>
                    <option value='<?=$tag->id?>' <?=($statusVO['next_tag_id'] == $tag->id ) ? 'selected="selected"' : '';?> ><?=$tag->tag?></option>
                <?}?>
                
            </select>
            <span class='error'><?=Arr::get($errors, 'next_tag_id');?></span>
        </dd>  
    </div>
    <div class="left">
        <label for="to">responsável</label>
        <dd>
            <select class="required round" name="to" id="to" >
                <option value='0' <?=(($statusVO['to']== '0')?('selected="selected"'):(''))?>>em aberto</option>
                <option value='1' <?=(($statusVO['to']== '1')?('selected="selected"'):(''))?>>responsável pela coleção</option>
                <!--option value='2' <?=(($statusVO['to']== '2')?('selected="selected"'):(''))?>>usuário livre</option-->
            </select>
            <span class='error'><?=Arr::get($errors, 'sync');?></span>
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
