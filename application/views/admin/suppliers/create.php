	<? if(@$VO['id'] != ""){?>
		<div class="list_bar">
			<a href="<?=URL::base();?>admin/suppliers/view/<?=@$VO['id'];?>" rel="load-content" data-panel="#direita" class="bar_button round">Voltar</a>
		</div>
	<?}?>
	<div class="scrollable_content">
	    <form name="frmSupplier" id="frmSupplier" action="<?=URL::base();?>admin/suppliers/salvar/<?=$VO['id']?>" method="post" class="form" enctype="multipart/form-data">
	    
	    	<div class="left">
				<label for="empresa">empresa</label>
			    <dd>
			      <input type="text" class="text required round" name="empresa" id="empresa" style="width:400px;" value="<?=@$VO['empresa'];?>"/>
			      <span class='error'><?=Arr::get($errors, 'empresa');?></span>
			    </dd>
			</div>
			<div class="left">
				<label for="status">status</label>
			    <dd>
			    	<select class="required round" name="status" id="status" style="width:100px;">
                        <option value='1' <?=(($VO['status']== '1')?('selected="selected"'):(''))?>>aprovado</option>
                        <option value='0' <?=(($VO['status']== '0')?('selected="selected"'):(''))?>>reprovado</option>
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
			      <input type="text" class="text round" name="site" id="site" style="width:200px;" value="<?=@$VO['site'];?>"/>
			      <span class='error'><?=Arr::get($errors, 'site');?></span>
			    </dd>
	    		<a href="<?=URL::base();?>admin/contatos/getListContatos/true" class="popup"><span class='add'>contatos</span></a>                           
			    				
				<div class="clear">					
					<input type="hidden" name="contatos" id="sortable_contacts" />
					<ul class="list_item connect_contacts round sortable_creditos" data-fill="sortable_contacts" >
			        	<?foreach ($contatos_suppliers as $cs) {?>
			        		<li class="dd-item" id="contato-<?=$cs->contato->id?>">
			        			
								<div>
									 <b><?=$cs->contato->nome?></b><br/>
									<?=$cs->contato->email?>
								</div>		
								<span class="list_faixa round blue" style="margin:5px 0;"><?=$cs->contato->service->name?></span>	        			
			        		</li>
			        	<?}?>
			        </ul>
				</div>	
		        <dt class="clear">
		            <label for="observacoes">observações</label>
		        </dt>
		        <dd>
		              <textarea class="text round" name="observacoes" id="observacoes" style="width:500px; height:200px;"><?=@$VO['observacoes'];?></textarea>
		              <span class='error'><?=Arr::get($errors, 'observacoes');?></span>
		        </dd>
			    <dd>
			      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="salvar" />
			    </dd>
			</div>	
		</form>
	</div>
