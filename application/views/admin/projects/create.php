<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/projects" class="bar_button round">Voltar</a>
	</div>
        <?
        
        $name = ($projeto->name) ? ($projeto->name) : (Arr::get($values, 'name'));
        $target = ($projeto->target) ? ($projeto->target) : (Arr::get($values, 'target'));
        $description = ($projeto->description) ? ($projeto->description) : (Arr::get($values, 'description'));
        
        ?>
    <form name="frmCreateProject" id="frmCreateProject" method="post" class="form" enctype="multipart/form-data" autocomplete="off">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
	    <dt>
	      <label for="name">Projeto</label>
	    </dt>
	    <dd>
	      <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=$name;?>"/>
	      <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>
	    <dt>
	      <label for="target">Seguimento</label>
	    </dt>
	    <dd>
	      <input type="text" class="text required round" name="target" id="target" style="width:500px;" value="<?=$target;?>"/>
	      <span class='error'><?=Arr::get($errors, 'target');?></span>
	    </dd>
	    <dt>
	      <label for="description">Descrição</label>
	    </dt>	    
	    <dd>
	      <textarea class="text required round" name="description" id="description" style="width:500px; height:200px;"><?=$description;?></textarea>
	      <span class='error'><?=Arr::get($errors, 'description');?></span>
	    </dd>
            <? /*<dt>
	      <label for="arquivo">Anexar arquivo</label>
	    </dt>	    
	    <dd>
                <input type="file" class="text required round" name="arquivo" id="arquivo" style="width:500px;" />
	    </dd>*/?>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
        <? 
        /*if(isset($filesList) && count($filesList)>0)
        {
        ?>
        <table class="list">
            <thead>
                <th>Arquivo</th>			
                <th>Ação</th>
            </thead>
            <tbody>
            <?
            foreach($filesList as $file)
            {
                $linkDownload = URL::base().'admin/files/download/'.$file->id;
            ?>
                <tr>
                    <td><a href="<?=$linkDownload?>" title="Download" target="_blank"><?=basename($file->uri)?></a></td>				
                        <td class="acao">
                            <a class="download" href="<?=$linkDownload?>" title="Download" target="_blank">Download</a>
                        </td>
                </tr>
            <?
            }
            ?>			
            </tbody>
	</table>
        <?
        }*/
        ?>
</div>
