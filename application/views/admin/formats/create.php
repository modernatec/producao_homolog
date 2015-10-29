<form name="frmCreateSfwprod" id="frmCreateSfwprod" action="<?=URL::base();?>admin/format/salvar/<?=@$sfwprodVO["id"]?>" method="post" class="form" enctype="multipart/form-data">
	<div class="left"> 
		<label for="name">formato</label>
	    <dd>
	        <input type="text" class="text required round" placeholder="novo formato" name="name" id="name" style="width:250px;" value="<?=@$sfwprodVO['name'];?>"/>
	        <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>
	</div>
	<div class="left">
		<label for="ext">extensão</label>
        <dd>
            <select class="required round" name="ext" id="ext">
                <option value=''>selecione</option>
                <option value='index.html' <?=(($sfwprodVO['ext']== 'index.html')?('selected="selected"'):(''))?>>.html</option>
                <option value='.mp4' <?=(($sfwprodVO['ext']== '.mp4')?('selected="selected"'):(''))?>>.mp4</option>
                <option value='.mp3' <?=(($sfwprodVO['ext']== '.mp3')?('selected="selected"'):(''))?>>.mp3</option>
                <option value='.swf' <?=(($sfwprodVO['ext']== '.swf')?('selected="selected"'):(''))?>>.swf</option>
            </select>
            <span class='error'><?=Arr::get($errors, 'ext');?></span>
        </dd> 
	</div>  
	<div class="clear">          
	    <dd>
	      <input type="submit" class="round bar_button" name="btnSubmit" id="btnSubmit" value="salvar" />
	    </dd>
    </div>
</form>
