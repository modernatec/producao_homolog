<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/projects" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateProject" id="frmCreateProject" method="post" class="form" enctype="multipart/form-data">
	  <dl>
	    <div class="left">
		    <dt>
		      <label for="name">projeto</label>
		    </dt>
		    <dd>
		      <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=@$projectVO['name'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'name');?></span>
		    </dd>
		    <dt>
		      <label for="target">seguimento</label>
		    </dt>
		    <dd>
		      <select name="segmento_id" id="segmento_id" style="width:150px;">
	                <option value="">selecione</option>
	                <? foreach($segmentosList as $segmento){?>
	                <option value="<?=$segmento->id?>" <?=((@$projectVO["segmento_id"] == $segmento->id)?('selected'):(''))?> ><?=$segmento->name?></option>
	                <? }?>
	            </select>
	            <span class='error'><?=($errors) ? $errors['segmento_id'] : '';?></span>
		    </dd>
		    <dt>
		      <label for="description">descrição</label>
		    </dt>	    
		    <dd>
		      <textarea class="text required round" name="description" id="description" style="width:500px; height:60px;"><?=@$projectVO['description'];?></textarea>
		      <span class='error'><?=Arr::get($errors, 'description');?></span>
		    </dd>
		</div>
		<div class="left">
		    <dt>
		      <label for="collections">coleções</label>
		    </dt>
		    <div id="tabs" style="width:500px;">
				<ul>
					<? foreach($collectionsList as $collection){?>
					<li><a href="<?=URL::base();?>admin/collections/getListProject/<?=$collection->ano?>?project_id=<?=@$projectVO['id']?>"><?=$collection->ano?></a></li>
					<?}?>
				</ul>
				<div id="tabs_content" >
					
				</div>
			</div>
		    <ul class="select_holder"></ul>
		</div>
	    <dd class="clear">
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
