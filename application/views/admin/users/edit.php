<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/users" class="bar_button round">Voltar</a>
	</div>
    <form name="frmCreateUsers" id="frmCreateUsers" method="post" class="form" enctype="multipart/form-data" autocomplete="off">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
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
		<div class="left">   
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
		
		<?foreach($userInfoVO["role_id"] as $roleObj){?>
			<input type="hidden" name="role_id[]" value="<?=$roleObj?>" />
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
	      <a href="<?=URL::base();?>users/editPass" class="bar_button round">Alterar senha</a>
	    </dt>              
	    <dd>
			<input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<?=(@$isUpdate) ? "Salvar" : "Criar"?>" />
	    </dd>	
	  </dl>
	</form>
</div>