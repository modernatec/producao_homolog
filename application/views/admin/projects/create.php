<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/projects" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateProject" id="frmCreateProject" method="post" class="form" enctype="multipart/form-data">
	    <div class="left">
		    <dt>
		      <label for="name">projeto</label>
		    </dt>
		    <dd>
		      <input type="text" class="text required round" name="name" id="name" style="width:500px;" value="<?=@$projectVO['name'];?>"/>
		      <span class='error'><?=Arr::get($errors, 'name');?></span>
		    </dd>
		    <div class="left">
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
			</div>
		    <dt>
		      <label for="status">status</label>
		    </dt>
		    <dd>
		      <select class="required round" name="status" id="status" style="width:150px;">
                    <option value=''>Selecione</option>
                    <option value='0' <?=(($projectVO['status']==0)?('selected="selected"'):(''))?>>finalizado</option>
                    <option value='1' <?=(($projectVO['status']==1)?('selected="selected"'):(''))?>>em produção</option>
               
                </select>
	            <span class='error'><?=($errors) ? $errors['status'] : '';?></span>
		    </dd>
		    <dt>
		      <label for="description">descrição</label>
		    </dt>	    
		    <dd>
		      <textarea class="text required round" name="description" id="description" style="width:500px; height:60px;"><?=@$projectVO['description'];?></textarea>
		      <span class='error'><?=Arr::get($errors, 'description');?></span>
		    </dd>		 
		    <dd class="clear">
				<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />		      
		    </dd>
		    <?
		     if(!empty($projectVO['id'])){?>
			    <hr style="margin:8px 0;">
	            <a href="<?=URL::base();?>admin/relatorios/relatorioLink?project_id=<?=@$projectVO['id']?>" class="round bar_button">gerar relatório</a> 
		    <?}?>
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
	</form>
</div>
