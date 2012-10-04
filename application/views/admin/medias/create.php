<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/medias" class="bar_button round">Voltar</a>
	</div>
        <?
        //print_r($errors);
        $tag = ($media->tag) ? ($media->tag) : (Arr::get($values, 'tag'));
        ?>
    <form name="frmMedia" id="frmMedia" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	    <dt>
	      <label for="tag">Tag</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="tag" id="tag" style="width:500px;" value="<?=$tag;?>"/>
	      <span class='error'><?=Arr::get($errors, 'tag');?></span>
	    </dd>
            <dt>
                <label for="arquivo"><b>Anexar arquivo</b></label>
            </dt>	    
            <dd>
                <? /*<input type="file" class="text required round" name="arquivo" id="arquivo" style="width:300px;" />*/?>
                <input type="hidden" name="filesUploads" id="filesUploads" value=""/>
                <input type="hidden" name="mimeUploads" id="mimeUploads" value=""/>
                <div id="container">
                    <div id="filelist">
                        <a id="excluirTodos" class="excluir_todos">Excluir todos</a>
                   </div>
                    <br />
                    <a id="pickfiles" href="javascript:;" class="bar_button round">Anexar arquivo</a> 
                    <a id="uploadfiles" href="javascript:;" class="bar_button round">Subir</a>
                </div>
                <br/>
            </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
