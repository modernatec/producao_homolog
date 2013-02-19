<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/medias" class="bar_button round">Voltar</a>
	</div>
    <form name="frmMedia" id="frmMedia" method="post" class="form" enctype="multipart/form-data">
	  <dl>
	    <dt>
	      <label for="tag">Media</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="tag" id="tag" style="width:500px;" value="<?=@$mediaVO['tag'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'tag');?></span>
	    </dd>
        <?=$anexosView?>
		<?
            if(isset($mediaFiles)){
				echo '<dd><label>Lista de arquivos</label><ul class="filelist">';
                foreach($mediaFiles as $file){
        ?>
                    <li><a href="<?=URL::base();?>admin/files/download/<?=$file->id?>" ><?=basename($file->uri);?></a></li>
        <?		
                }
				echo '</ul></dd>';	
			}
        ?>  
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
