<form action="<?=URL::base();?>admin/segmentos/edit/<?=@$segmentoVO["id"]?>" name="frmCreateSegmento" id="frmCreateSegmento" method="post" class="form"  data-panel="#direita"  enctype="multipart/form-data">
	<dl>            
		<dd>
			<input type="text" class="text required round" placeholder="nome do segmento" name="name" id="name" style="width:500px;" value="<?=@$segmentoVO['name'];?>"/>
			<span class='error'><?=Arr::get($errors, 'name');?></span>
		</dd>            
		<dd>
			<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate){ ?>Salvar<? }else{?>Criar<? }?>" />
		</dd>
	</dl>
</form>