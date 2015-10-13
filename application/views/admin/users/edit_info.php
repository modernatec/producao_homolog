<div class="scrollable_content">
    <form name="frmEditinfo" id="frmEditinfo" method="post" class="form" action="<?=URL::base();?>admin/users/salvarinfos/<?=$userInfoVO['id']?>" enctype="multipart/form-data" autocomplete="off">
		<div id="upload" class="dropzone" data-user="<?=$userInfoVO['id']?>">			
			<div class="dz-message" data-dz-message></div>
		</div>
		
		<input type="hidden" name="foto" id="userFoto" value="<?=$userInfoVO["foto"]?>" />
		<div class="left foto_form team_<?=@$userInfoVO["team_id"]?>" >
		<?if($userInfoVO["foto"] != ''){?>
			<img id="foto_atual" src="<?=URL::base();?><?=@$userInfoVO["foto"]?>?c=<?=date('H:i:s');?>" />
		
		<?}?>
			
		</div>

		<div class="left">

			<input type="hidden" name="team_id" id="team_id" value="<?=$userInfoVO["team_id"];?>" />
			<input type="hidden" name="status" id="status" value="<?=$userInfoVO["status"];?>" />
			<div class="clear left">
				<label for="nome">nome</label>
			    <dd>
			      <input type="text" class="text round" name="nome" id="nome" style="width:300px;" value="<?=$userInfoVO["nome"];?>"/>
			      <span class='error'><?=Arr::get($errors, 'nome');?></span>
			    </dd>
		    </div>	    
		    <div class="clear left">
			    <label for="email">e-mail</label>
			    <dd>
			      <input type="text" class="text round" name="email" id="email" style="width:250px;" value="<?=$userInfoVO["email"];?>"/>
			      <span class='error'><?=Arr::get($errors, 'email');?></span>
			    </dd>  
			</div>  	
			
		    <div class="left">
			    <label for="telefone">telefone</label>
			    <dd>
					<input type="text" class="text round" name="telefone" id="telefone" style="width:100px;" value="<?=$userInfoVO["telefone"];?>" maxlength="12"/>
					<span class='error'><?=Arr::get($errors, 'telefone');?></span>
			    </dd>
			</div>
	        <div class="left"> 
		        <label for="ramal">ramal</label>
			    <dd>
					<input type="text" class="text round" name="ramal" id="ramal" style="width:50px;" value="<?=$userInfoVO["ramal"];?>" maxlength="5"/>
					<span class='error'><?=Arr::get($errors, 'ramal');?></span>
			    </dd>
			</div>
			<div class="left"> 
			    <label for="data_aniversario">aniversário</label>
			    <dd>
		            <input type="text" class="text round" name="data_aniversario" placeholder='dd/mm' id="data_aniversario" style="width:50px;" value="<?=$userInfoVO["data_aniversario"];?>" maxlength="5" />
					<span class='error'><?=Arr::get($errors, 'data_aniversario');?></span>
			    </dd>
		    </div>
			<div class="clear">	
		    	<input type="submit" class="bar_button round left" name="btnSubmit" id="btnSubmit" value="salvar" />
		    	
		    </div>
		</div>
	</form>
</div>