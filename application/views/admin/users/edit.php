<div class="scrollable_content">
    <form name="frmEditUsers" id="frmEditUsers" method="post" class="form" action="<?=URL::base();?>admin/users/salvar/<?=$userInfoVO['id']?>" enctype="multipart/form-data" autocomplete="off">
	  <dl>
	  	<div class="left">	
		    <img class="foto_form" src="<?=URL::base();?><?=@$userInfoVO["foto"]?>" />		    
		</div>
		<div class="left">
	        <dt>
				<label for="arquivo">Anexar Foto</label>
		    </dt>
		    <?=$anexosView?> 
		</div>
		<div class="clear">
		    <dt>
		      <label for="nome">nome</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="nome" id="nome" style="width:500px;" value="<?=$userInfoVO["nome"];?>"/>
		      <span class='error'><?=Arr::get($errors, 'nome');?></span>
		    </dd>
	    </div>
	    <div class="left">
		    <dt>
		      <label for="email">e-mail</label>
		    </dt>
		    <dd>
		      <input type="text" class="text round" name="email" id="email" style="width:250px;" value="<?=$userInfoVO["email"];?>"/>
		      <span class='error'><?=Arr::get($errors, 'email');?></span>
		    </dd>  
		</div>  	
		
	    <div class="clear left">
		    <dt>
				<label for="telefone">Telefone</label>
		    </dt>
		    <dd>
				<input type="text" class="text round" name="telefone" id="telefone" style="width:100px;" value="<?=$userInfoVO["telefone"];?>" maxlength="12"/>
				<span class='error'><?=Arr::get($errors, 'telefone');?></span>
		    </dd>
		</div>
        <div class="left"> 
	        <dt>
				<label for="ramal">ramal</label>
		    </dt>
		    <dd>
				<input type="text" class="text round" name="ramal" id="ramal" style="width:50px;" value="<?=$userInfoVO["ramal"];?>" maxlength="5"/>
				<span class='error'><?=Arr::get($errors, 'ramal');?></span>
		    </dd>
		</div>
		
		<?
		if($current_auth != 'admin'){
			foreach($userInfoVO["role_id"] as $roleObj){?>
				<input type="hidden" name="role_id[]" value="<?=$roleObj?>" />
		<?}}else{?>
		<div class="clear">	    
			<dt>
		      <label for="role">permissão</label>
		    </dt>
		    <dd>
				<?foreach($rolesList as $roleObj){?>
					<input type="checkbox" name="role_id[]" id="role_<?=$roleObj->id?>" value="<?=$roleObj->id?>" <?if(in_array($roleObj->id, $userInfoVO['role_id'])){ echo "checked";}?> /><label for="role_<?=$roleObj->id?>"><?=ucfirst($roleObj->name)?></label>
				<? }?>
				<span class='error'><?=Arr::get($errors, 'role_id');?></span>
		    </dd>
		</div>
		<?}?>

		<div class="left"> 
		    <dt>
				<label for="data_aniversario">Data do Aniversário (dd/mm)</label>
		    </dt>
		    <dd>
	            <input type="text" class="text round" name="data_aniversario" id="data_aniversario" style="width:50px;" value="<?=$userInfoVO["data_aniversario"];?>" maxlength="5" />
				<span class='error'><?=Arr::get($errors, 'data_aniversario');?></span>
		    </dd>
	    </div>
	    <?
		if($current_auth == 'admin'){?>
	    <div class="clear left"> 
		    <dt>
				<label for="status">status</label>
		    </dt>
		    <dd>
	            <select name="status" id="status">
					<option value="">Selecione</option>
					<option value="0" <?=((@$userInfoVO["status"] == '0')?('selected'):(''))?> >inativo</option>
					<option value="1" <?=((@$userInfoVO["status"] == '1')?('selected'):(''))?> >ativo</option>
				</select>
				<span class='error'><?=Arr::get($errors, 'status');?></span>
		    </dd>
	    </div>
	   	<?}?>
		

	    <div class="clear left">   
		    <dt>
		      <label for="team">equipe</label>
		    </dt>
		    <dd>
	        	<input type="hidden" name="team" id="team" value="<?=$userInfoVO["team_id"]?>" />
				<?
	            	foreach($teamsList as $team){
						if($userInfoVO["team_id"] == $team->id){
							echo $team->name;	
						}
					}
	            ?>
		    </dd>
		</div>

	    <div class="clear">	    
	        <dt>
		      <label for="username">Username</label>
		    </dt>
		    <dd>
		      <input type="hidden" class="text round" name="username" id="username" value="<?=$userInfoVO["username"];?>" />
	          <?=$userInfoVO["username"];?>
		      <span class='error'><?=Arr::get($errors, 'username');?></span>
	          
		    </dd>  
  		</div>
        <dt>
	      <a href="<?=URL::base();?>users/editPass" rel="load-content" data-panel="#direita" class="bar_button round">Alterar senha</a>
	    </dt>              
	    <dd>
			<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<?=(@$isUpdate) ? "Salvar" : "Criar"?>" />
	    </dd>	
	  </dl>
	</form>
</div>