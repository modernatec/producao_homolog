<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/curriculums" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCurriculum" id="frmCurriculum" method="post" class="form" enctype="multipart/form-data">
	  <dl>
	    <dt>
	      <label for="name">Nome</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="name" id="name" style="width:500px;" value="<?=@$curriculumVO['name'];?>"/>
	      <span class='error'><?=Arr::get($errors, 'name');?></span>
	    </dd>
        <dt>
	      <label for="objective">Objetivo</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="objective" id="objective" style="width:500px;" value="<?=@$curriculumVO["objective"];?>"/>
	      <span class='error'><?=Arr::get($errors, 'objective');?></span>
	    </dd>
        <dt>
	      <label for="formado">Formado</label>
	    </dt>
	    <dd>
			<select name="formado" id="formado">
				<option value="">Selecione</option>
                <option value="1" <?=((@$curriculumVO["formado"] == 1)?('selected'):(''))?> >Sim</option>
				<option value="0" <?=((@$curriculumVO["formado"] == 0)?('selected'):(''))?> >Não</option>
			</select>
			<span class='error'><?=Arr::get($errors, 'role');?></span>
	    </dd>
        <dt>
	      <label for="description">Observações</label>
	    </dt>	    
	    <dd>
	      <textarea class="text required round" name="description" id="description" style="width:500px; height:200px;"><?=@$curriculumVO['description'];?></textarea>
	      <span class='error'><?=Arr::get($errors, 'description');?></span>
	    </dd>
        <?=$anexosView?>
	    <dd>
        	<ul>
            <?
             	if(isset($curriculumVO['file'])){
					foreach($curriculumVO['file'] as $file){
			?>
            			<li><a href="<?=URL::base();?>admin/files/download/<?=$file->id?>" ><?=basename($file->uri);?></a></li>
            <?		
					}	
				}
			?>  
            </ul>
	    </dd>	    
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
