<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/users" class="bar_button round">Voltar</a>
	</div>
        <?
        $idU = ($userinfo->id) ? true : false;
        $nome = ($userinfo->nome) ? ($userinfo->nome) : (Arr::get($values, 'nome'));
        $username = ($user->username) ? ($user->username) : (Arr::get($values, 'username'));
        $password = (Arr::get($values, 'password'));
        
        if($user){
            $roles = $user->roles->find_all()->as_array('id','name');        
            if(in_array('coordenador', $roles)){
                $role = 3;
            }elseif(in_array('assistente', $roles)){
                $role = 4;
            }else{
                $role = Arr::get($values, 'role');
            }
        }else{
            $role = Arr::get($values, 'role');
        }
        
        if($userinfo){
            $teams = $userinfo->team->find_all();        
            if(count($teams)>0){
                $teamId = $teams[0];
            }else{
                $teamId = Arr::get($values, 'team');
            }
        }else{
            $teamId = Arr::get($values, 'team');
        }
        
        $email = ($userinfo->email) ? ($userinfo->email) : (Arr::get($values, 'email'));
        $data_aniversario = ($userinfo->data_aniversario) ? (Utils_Helper::data($userinfo->data_aniversario.' 00:00:00','d/m')) : (Arr::get($values, 'data_aniversario'));
        $ramal = ($userinfo->ramal) ? ($userinfo->ramal) : (Arr::get($values, 'ramal'));
        $telefone = ($userinfo->telefone) ? ($userinfo->telefone) : (Arr::get($values, 'telefone'));
        $foto = ($userinfo->foto) ? ($userinfo->foto) : ('');        
        ?>
    <form name="frmCreateUsers" id="frmCreateUsers" method="post" class="form" enctype="multipart/form-data" autocomplete="off">
	  <input type="hidden" name="uri" id="uri" value="" title="<?=rawurlencode(Arr::get($_SERVER, 'HTTP_REFERER'));?>" />
	  <dl>
              <dt>
	      <label for="username">Username</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" <?=(($idU)?'ignore="true"':'')?> name="username" id="username" style="width:100px;" value="<?=$username;?>" <? if($isUpdate==1){?>readolny<? }?>/>
	      <span class='error'><?=Arr::get($errors, 'username');?></span>
	    </dd>
	    <dt>
	      <label for="password">Senha</label>
	    </dt>
	    <dd>
	      <input type="password" class="text round" <?=(($idU)?'ignore="true"':'')?> name="password" id="password" style="width:100px;" value="<?=$password;?>"/>
	      <span class='error'><?=Arr::get($errors, 'password');?></span>
	    </dd>
	    <dt>
	      <label for="password_confirm">Confirme a senha</label>
	    </dt>
	    <dd>
	      <input type="password" class="text round" <?=(($idU)?'ignore="true"':'')?> name="password_confirm" id="password_confirm" style="width:100px;" value="<?=$password_confirm;?>"/>
	      <span class='error'><?=Arr::get($errors, 'password_confirm');?></span>
	    </dd>	        	    
	    <dt>
	      <label for="role">Permissão</label>
	    </dt>
	    <dd>
                <select name="role" id="role" <?=(($idU)?'ignore="true"':'')?>>
                    <option value="">Selecione</option>
                    <option value="3" <?=(($role == 3)?('selected'):(''))?>>Coordenador</option>
                    <option value="4" <?=(($role == 4)?('selected'):(''))?>>Assistente</option>
                </select>
	      <span class='error'><?=Arr::get($errors, 'role');?></span>
	    </dd>
	    <dt>
	      <label for="nome">Nome</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="nome" id="nome" style="width:500px;" value="<?=$nome;?>"/>
	      <span class='error'><?=Arr::get($errors, 'nome');?></span>
	    </dd>
	    <dt>
	      <label for="email">Email</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="email" id="email" style="width:500px;" value="<?=$email;?>"/>
	      <span class='error'><?=Arr::get($errors, 'email');?></span>
	    </dd>       	    
	    <dt>
	      <label for="team">Equipe</label>
	    </dt>
	    <dd>
                <select name="team" id="team">
                    <option value="">Selecione</option>
                    <?
                    foreach($teamsList as $team){
                        ?><option value="<?=$team->id?>" <?=(($teamId == $team->id)?('selected'):(''))?>><?=$team->name?></option><?
                    }
                    ?>
                </select>
	      <span class='error'><?=Arr::get($errors, 'role');?></span>
	    </dd>
            <dt>
	      <label for="telefone">Telefone</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="telefone" id="telefone" style="width:100px;" value="<?=$telefone;?>" maxlength="12"/>
	      <span class='error'><?=Arr::get($errors, 'telefone');?></span>
	    </dd>
            <dt>
	      <label for="data_aniversario">Data do Aniversário (dd/mm)</label>
	    </dt>
	    <dd>
            <input type="text" class="text round" name="data_aniversario" id="data_aniversario" style="width:50px;" value="<?=$data_aniversario;?>" maxlength="5" />
	      <span class='error'><?=Arr::get($errors, 'data_aniversario');?></span>
	    </dd>
            <dt>
	      <label for="ramal">Ramal</label>
	    </dt>
	    <dd>
	      <input type="text" class="text round" name="ramal" id="ramal" style="width:50px;" value="<?=$ramal;?>" maxlength="5"/>
	      <span class='error'><?=Arr::get($errors, 'ramal');?></span>
	    </dd>
            <dt>
	      <label for="arquivo">Anexar Foto</label>
	    </dt>	    
	    <dd>
                <?
                if($foto!=''){
                    ?>
                <img src="<?=URL::base();?><?=$foto?>" width="150" alt="<?=$nome;?>" />
                    <?
                }
                ?>
                <input type="file" class="text round" name="arquivo" id="arquivo" style="width:500px;" />
	    </dd>
	    <dd>
	      <input type="submit" class="round" name="btnSubmit" id="btnSubmit" value="<? if($isUpdate==1){?>Salvar<? }else{ ?>Criar<? }?>" />
	    </dd>
	  </dl>
	</form>
</div>
