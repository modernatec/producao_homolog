<form method="post" enctype="multipart/form-data" id="cadastroForm" class='niceform'>  
	<div class='box darkblue'> 
        <h1 class='title'>Dados do dono</h1> 
    </div> 
    <div class='form clear'>
    	<p>
            <label class='darkblue'>Nome</label> 
			<input type='text' id="name" name='name' size='60' />
        </p>
    	<p>
            <label class='darkblue'>E-mail</label> 
            <input type='text' id="email" name='email'>
		</p>
    	<p>
            <label class='darkblue'>Senha</label>
            <input type='password' id='password' name='password' size='10'>
            
            <label class='darkblue'>Confirme a senha</label>
            <input type='password' id='confirm_password' name='confirm_password' size='10' >
        </p>
    	<p>
            <label class='darkblue full'>Sexo</label> 
            <input type='radio' name='sexo' value='M' id='M' ><label for='M' class='opt'>Masculino</label>
            <input type='radio' name='sexo' value='F' id='F' ><label for='F' class='opt'>Feminino</label>
        </p>
    </div> 
    
    <div class='box darkblue clear'> 
        <h1 class='title'>Dados do Pet</h1> 
    </div> 
    
    <div class='form clear'>
    	<p>
            <label class="darkblue">Nome</label>
            <input type='text' id="petName" name="petName" size='60'>
        </p>
		<span id='petGenderErro'></span>
    	<p>
            <label class='darkblue full' id='gender'>Gênero</label>
            <select size="1" id="petGender" name="petGender" >
                <option value="">Opção 1</option>
                <option value="2">Opção 2</option>
                <option value="3">Opção 3</option>
            </select>
        </p>
    	<p>
            <label class='darkblue full'>Raça / Espécie</label>
            <select size="1" id="petRace" name="petRace" >
                <option value="">Opção 1</option>
                <option value="">Opção 2</option>
                <option value="">Opção 3</option>
            </select>
        </p>        
    	<p>
            <label class='darkblue full'>Sexo</label>
            <input type='radio' name='petSex'><label class='opt' >Masculino</label>
            <input type='radio' name='petSex'><label class='opt' >Feminino</label>
        </p>
    	<p>
            <label class='darkblue full'>Data de nascimento</label>
            <select size="1" id="petD" name="petD" >
                <option value="">Dia</option>
                <option value="02">02</option>
                <option value="03">03</option>
            </select>
			<select size="1" id="petM" name="petM" >
                <option value="">Mês</option>
                <option value="">Opção 2</option>
                <option value="">Opção 3</option>
            </select>
			<select size="1" id="petY" name="petRace" >
                <option value="">Ano</option>
                <option value="">Opção 2</option>
                <option value="">Opção 3</option>
            </select>
        </p>
        
    	<p>
            <label class='darkblue full'>Possui pedigree ?</label>
            <input type='radio' name='pedigree' value='S' id='pS'><label for='pS' class='opt' >Sim</label>
            <input type='radio' name='pedigree' value='N' id='pN'><label for='pN' class='opt' >Não</label>
        </p>
        
    	<p>
            <label class='darkblue full'>Status</label>
            <select size="1" id="petStatus" name="petStatus" >
                <option value="">Opção 1</option>
                <option value="">Opção 2</option>
                <option value="">Opção 3</option>
            </select>
        </p>
        
    	<p>
            <label class='darkblue full'>Estado civil</label>
            <select size="1" id="intPerfil" name="intPerfil" >
                <option value="">Opção 1</option>
                <option value="">Opção 2</option>
                <option value="">Opção 3</option>
            </select>
        </p>
        
    	<p>
            <label class='darkblue full'>Estado</label>
            <select size="1" id="petState" name="intPerfil" >
                <option value="">Opção 1</option>
                <option value="">Opção 2</option>
                <option value="">Opção 3</option>
            </select>
        </p>
        
    	<p>
            <label class='darkblue full'>Cidade</label>
            <select size="1" id="petCity" name="petCity" >
                <option value="">Opção 1</option>
                <option value="">Opção 2</option>
                <option value="">Opção 3</option>
            </select>
        </p>
        
    	<p>
            <label class="darkblue full">Foto</label>
            <span style='float:left;'><input type="file" id="petImage" name="petImage" /></span>
        </p>
		<p>
			<input type='submit' value='Cadastrar' class='submit' style='width:100px' />
		</p>
    </div> 
</form>