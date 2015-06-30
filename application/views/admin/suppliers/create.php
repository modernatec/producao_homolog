	<? if(@$supplierVO['id'] != ""){?>
	<div class="bar">
		<a href="<?=URL::base();?>admin/suppliers/view/<?=@$supplierVO['id'];?>" rel="load-content" data-panel="#direita" class="bar_button round">Voltar</a>
	</div>
	<?}?>
	<div class="scrollable_content">
	    <form name="frmSupplier" id="frmSupplier" action="<?=URL::base();?>admin/suppliers/salvar/<?=$supplierVO['id']?>" method="post" class="form" enctype="multipart/form-data">
	    	<div class="left">
				<label for="empresa">empresa</label>
			    <dd>
			      <input type="text" class="text required round" name="empresa" id="empresa" style="width:400px;" value="<?=@$supplierVO['empresa'];?>"/>
			      <span class='error'><?=Arr::get($errors, 'empresa');?></span>
			    </dd>
			</div>
			<div class="left">
				<label for="status">status</label>
			    <dd>
			    	<select class="required round" name="status" id="status" style="width:100px;">
                        <option value='1' <?=(($supplierVO['status']== '1')?('selected="selected"'):(''))?>>aprovado</option>
                        <option value='0' <?=(($supplierVO['status']== '0')?('selected="selected"'):(''))?>>reprovado</option>
                    </select>
				    <span class='error'><?=Arr::get($errors, 'status');?></span>
			    </dd>
			</div>
		    	
			<div class="clear">
		        <dt>
			   		<label for="trabalho">tipo de trabalho</label>
			    </dt>
			    <dd>
			   		<? foreach ($formatos as $formato) {?>
						<input type="checkbox" name="formato[]" id="formato_<?=$formato->id?>" value="<?=$formato->id?>" <?=(array_key_exists($formato->id, $formats_arr))? 'checked' : ''?> /><label for="formato_<?=$formato->id?>"><?=$formato->name?></label> 
			   		<?}?>   

			      <span class='error'><?=Arr::get($errors, 'trabalho');?></span>
			    </dd>
			    <div class="left">
				    <dt>
				      <label for="team_id">times atendidos</label>
				    </dt>
				    <dd>
				    	<?foreach ($teams as $team) { ?>
							<input type="checkbox" name="team[]" id="team_<?=$team->id?>" value="<?=$team->id?>" <?=(array_key_exists($team->id, $team_arr))? 'checked' : ''?> /><label for="team_<?=$team->id?>"><?=$team->name?></label> 
				   		<?}?>  
			            <span class='error'><?=Arr::get($errors, 'team');?></span>
				    </dd>
				</div>
		        <dt class='clear'>
			      <label for="site">Site</label>
			    </dt>
			    <dd>
			      <input type="text" class="text round" name="site" id="site" style="width:200px;" value="<?=@$supplierVO['site'];?>"/>
			      <span class='error'><?=Arr::get($errors, 'site');?></span>
			    </dd>
			    <dt>
			    	<label class="clear left">contatos</label> <a data-qtd='<?=count($contatos);?>' class="left round_button addcontato">+</a>
			    </dt>
			    				
				<div id='contatos' class="clear">
					<?
					foreach ($contatos as $key => $contato) {

						$view = View::factory('admin/contatos/contato_item')->bind('errors', $errors);
						$view->key = $key;
						$view->contato = $contato;
						echo $view;
					}
					?>
				</div>	
		        <dt class="clear">
		            <label for="observacoes">observações</label>
		        </dt>
		        <dd>
		              <textarea class="text round" name="observacoes" id="observacoes" style="width:500px; height:200px;"><?=@$supplierVO['observacoes'];?></textarea>
		              <span class='error'><?=Arr::get($errors, 'observacoes');?></span>
		        </dd>
			    <dd>
			      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="salvar" />
			    </dd>
			</div>	
		</form>
	</div>
