<div class="scrollable_content">
    <form name="frmEditUsers" id="frmEditUsers" method="post" class="form" action="<?=URL::base();?>admin/users/salvar/<?=$userInfoVO['id']?>" enctype="multipart/form-data" autocomplete="off">
		<div class="left">
			<?if($userInfoVO["foto"] != ''){?>
			<div class="left foto_form team_<?=@$userInfoVO["team_id"]?>" >
				<img id="foto_atual" src="<?=URL::base();?><?=@$userInfoVO["foto"]?>?c=<?=date('H:i:s');?>" />
			</div>
			<?}?>
			<div id="upload" class="dropzone" data-user="<?=$userInfoVO['id']?>">			
				<div class="dz-message" data-dz-message></div>
			</div>
			
			<input type="hidden" name="foto" id="userFoto" />
	  	</div>
	  	<div class="left">

			<div class="clear left">
				<label for="nome">nome</label>
			    <dd>
			      <input type="text" class="text round" name="nome" id="nome" style="width:300px;" value="<?=$userInfoVO["nome"];?>"/>
			      <span class='error'><?=Arr::get($errors, 'nome');?></span>
			    </dd>
		    </div>	    
		    <div class="left"> 
		    	<label for="team">time</label>
			    <dd>
					<select name="team_id" id="team_id" class="round">
						<option value="">Selecione</option>
						<? foreach($teamsList as $team){?>
		                	<option value="<?=$team->id?>" <?=((@$userInfoVO["team_id"] == $team->id)?('selected'):(''))?> ><?=ucfirst($team->name)?></option><? }?>
					</select>
					<span class='error'><?=Arr::get($errors, 'role');?></span>
			    </dd>
			</div>
		    <div class="left"> 
			    <label for="status">status</label>
			    <dd>
		            <select name="status" id="status" class="round">
						<option value="">Selecione</option>
						<option value="0" <?=((@$userInfoVO["status"] == '0')?('selected'):(''))?> >inativo</option>
						<option value="1" <?=((@$userInfoVO["status"] == '1')?('selected'):(''))?> >ativo</option>
					</select>
					<span class='error'><?=Arr::get($errors, 'status');?></span>
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
				<label for="role">permissão</label>
			    <dd>
					<?foreach($rolesList as $roleObj){?>
						<input type="checkbox" name="role_id[]" id="role_<?=$roleObj->id?>" value="<?=$roleObj->id?>" <?if(in_array($roleObj->id, $userInfoVO['role_id'])){ echo "checked";}?> /><label for="role_<?=$roleObj->id?>"><?=ucfirst($roleObj->name)?></label>
					<? }?>
					<span class='error'><?=Arr::get($errors, 'role_id');?></span>
			    </dd>
			</div>
			<div class="clear left">	    
		      	<label for="username">username</label>
				<dd>
					<?=@$userInfoVO["username"];?>
					<a href="<?=URL::base();?>admin/users/editPass/<?=$userInfoVO["user_id"]?>" class="bar_button round left" rel="load-content" data-panel="#direita" >alterar senha</a>
				</dd>
			</div>	
			<div class="clear">	
		    	<input type="submit" class="bar_button round left" name="btnSubmit" id="btnSubmit" value="salvar" />
		    	
		    </div>
		</div>
	</form>
</div>