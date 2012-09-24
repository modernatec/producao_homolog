var borderColor = "#000000";
var bgColor = "#B4A3CD";

function limpaCpf(cpf){
	arrponto = cpf.split("\.");
	pontook = arrponto.join("");
	
	arrtraco = pontook.split("-");
	tracook = arrtraco.join("");
	
	tudook = tracook;
	return tudook;
}

function limpaAvalia(frm){
	if (document.getElementById('divErro')) {
		var elem = document.getElementById('divErro');
		elem.parentNode.removeChild(elem);
		//document.removeChild(elem);
	}
	if (document.getElementById('sombraErro')) {
		var elem = document.getElementById('sombraErro');
		elem.parentNode.removeChild(elem);
		//frm.removeChild(document.getElementById('sombraErro'));
	}
	
	if (document.getElementById('iframeErro')) {
		var elem = document.getElementById('iframeErro');
		elem.parentNode.removeChild(elem);
		//frm.removeChild(document.getElementById('iframeErro'));
	}
}

function avalia(frm){

	limpaAvalia(frm);
	
	if(avalia.arguments[1]) {
		borderColor = avalia.arguments[1];
	}

	if(avalia.arguments[2]) {
		bgColor = avalia.arguments[2];
	}

	if(avalia.arguments[3]){
		isself = true;
		campoself = avalia.arguments[3];
	}else{
		isself = false;
	}

	var elemento_length;

	switch(isself){
		case true:
			elemento_length = 1;
		break;
		case false:
			elemento_length = frm.elements.length;
		break;
	}


	for (i = 0; i < elemento_length; i++) {

		switch(isself){
			case true:
				var elemento = campoself;
			break;
			case false:
				var elemento = frm.elements[i];
			break;
		}
		
		elemento.style.backgroundColor = "";
		//elemento.style.borderColor = "";

		if ((!document.all)&&(document.getElementById)){
			var verifica = elemento.getAttribute('disabled') == null;
		}    
		
		if ((document.all)&&(document.getElementById)){
			var verifica = !elemento.getAttribute('disabled');
		}
		
		if (elemento.getAttribute('obrigatorio') && (verifica)) {
			//alert(elemento.type)
			switch(elemento.type) {
				case "radio" :
					//alert(elemento.getAttribute('disabled'));
					if (navigator.userAgent.indexOf('Opera') < 0) {
						if (trim(elemento.value).indexOf(":") == -1 || trim(elemento.value).indexOf("\\") == -1) {
							marcados =-1;
							//alert(elemento.name)
							for (i=0; i<frm.elements[elemento.name].length; i++) {
								if (frm.elements[elemento.name][i].checked) {
									marcados = i
								}
							}
							//alert(marcados)
							if(marcados == -1){
								if (elemento.getAttribute('erro')) {
									mostraErro(frm,elemento,elemento.getAttribute('erro'));
								} else {
									mostraErro(frm,elemento,"Por favor, selecione uma das opções");
								}
							}else{
								elemento.removeAttribute('obrigatorio');
								avalia(frm);
							}
							return false;							
						}
					}
					break;

			
				case "file" :
					if (navigator.userAgent.indexOf('Opera') < 0) {
						if (trim(elemento.value).indexOf(":") == -1 || trim(elemento.value).indexOf("\\") == -1) {
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, selecione um arquivo válido");
							}
							return false;
						}
					}
					break;
				case "text" :
					if (elemento.getAttribute('email')){
						if (trim(elemento.value).indexOf("@") == -1 || trim(elemento.value).indexOf(".") == -1) {
							if (elemento.getAttribute('erro')){
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, digite um email válido");
							}
							return false;
						}
						
						if (elemento.getAttribute('compara')){
							var campo = elemento.getAttribute('compara');
							if(elemento.value != frm.elements[campo].value){
								mostraErro(frm,elemento,"E-mails não coincidem");					
								return false;							
							}
						}
					}else if (elemento.getAttribute('cpf')) {
						if (elemento.getAttribute('unibanco_cpf')){
						//=============================================================================
						// CPF
						//=============================================================================
							// verifica se está selecionado registro estrangeiro em tipo de documento
							var tipoDoc = elemento.getAttribute('tipo_doc');
							var tipoDocValue = document.getElementById(tipoDoc).value;
							if(tipoDocValue == "0003"){
								// requisita preenchimento minimo caso o registro estrangeiro não seja registro estrangeiro
								break;
							};
						};

						//=============================================================================
						if (elemento.getAttribute('diferente_garantidor')){
							// verifica se está selecionado registro estrangeiro em tipo de documento
							var idGarantidor = elemento.getAttribute('diferente_garantidor');
							var valorGarantidor = limpaCpf(trim(document.getElementById(idGarantidor).value));
							var valorUniversitario = limpaCpf(trim(elemento.value));
							//alert("G|U->"+valorGarantidor+"|"+valorUniversitario);
							if(valorUniversitario == valorGarantidor){
								mostraErro(frm,elemento,"O CPF do Universitário não pode ser igual ao do Garantidor.");
								return false;
							};
						};

						//=============================================================================
						if (elemento.getAttribute('diferente_universitario')){
							// verifica se está selecionado registro estrangeiro em tipo de documento
							var idUniversitario = elemento.getAttribute('diferente_universitario');
							var valorUniversitario = limpaCpf(trim(document.getElementById(idUniversitario).value));
							var valorGarantidor = limpaCpf(trim(elemento.value));
							//alert("G|U->"+valorGarantidor+"|"+valorUniversitario);
							if(valorUniversitario == valorGarantidor){
								mostraErro(frm,elemento,"O CPF do Garantidor não pode ser igual ao do Universitário.");
								return false;
							};
						};

						//=============================================================================
						if(trim(elemento.value) == ""){
							mostraErro(frm,elemento,"Por favor, digite um CPF válido");
							return false;
						}
						
						var cpf_ = trim(elemento.value);
						var cpfV = cpf_.replace(/\./g,"");
						var cpf = cpfV.replace(/\-/g,"");
				
						if (cpf.length < 11) { 
							if(cpf.length == 10){ 
								cpf = "0"+cpf; 
							}else if (cpf.length == 9) { 
								cpf = "00"+cpf; 
							}else{ 
								mostraErro(frm,elemento,"Por favor, digite um CPF válido");
								return false; 
							} 
						} 
						
						if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999"){ 
							mostraErro(frm,elemento,"Por favor, digite um CPF válido");
							return false; 
						} 
							
						var soma = 0;
						for (x=0; x < 9; x ++){
							soma += parseInt(cpf.charAt(x)) * (10 - x);
								resto = 11 - (soma % 11);
							}
							if (resto == 10 || resto == 11){
								resto = 0;
							}
							if (resto != parseInt(cpf.charAt(9))){
								mostraErro(frm,elemento,"Por favor, digite um CPF válido");
								return false;
							}
		
						var soma = 0;
						for (y = 0; y < 10; y ++){
							soma += parseInt(cpf.charAt(y)) * (11 - y);
								resto = 11 - (soma % 11);
							}
							if (resto == 10 || resto == 11){
								resto = 0;
							}
							if (resto != parseInt(cpf.charAt(10))){
								mostraErro(frm,elemento,"Por favor, digite um CPF válido");
								return false;
							}
							
					}else if (elemento.getAttribute('min')){
						if(elemento.value.length < elemento.getAttribute('min')){
							
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}							
							return false;
						}
						
						if (elemento.getAttribute('ano')){
							if(parseInt(elemento.value.substring(6)) < 1900 || parseInt(elemento.value.substring(6)) > 2000){
								mostraErro(frm,elemento,"Preencha uma data entre 1900 e 2000");
								return false;
							}
						}
					}else if (elemento.getAttribute('unibanco_nome')){
					//=============================================================================
					// NOME
					//=============================================================================
						if(elemento.value.length < elemento.getAttribute('u_min')){
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}							
							return false;
						};
						if (elemento.getAttribute('u_norepeat')){
							var limite = elemento.getAttribute('u_norepeat');
							var tamanho = elemento.value.length;
							var lastChar = "";
							var atualChar = "";
							var repeatedChar = 0;
							for( x = 0; x < tamanho; x++){
								atualChar = elemento.value.substring(x,(x+1));
								if(atualChar==lastChar){
									repeatedChar++;
									if(repeatedChar >= limite){
										// SE TIVER MAIS CARACTERES REPETIDOS QUE O LIMITE, MOSTRA ERRO
										var msg_saida = "Por favor, não repita o caractere \""+lastChar+"\" mais de \" "+limite+" \" vezes"
										mostraErro(frm,elemento,msg_saida);				
										return false;
									}
								}else{
									repeatedChar = 0;
								}
								lastChar = atualChar;
							};
						};
						if (elemento.getAttribute('u_nochars')){
							var filtro = "-!@#$%\"&.*()_+=<>:;?/,'-[{]}|\\º-";
							var dados = elemento.value;
							
							for( x = 0; x < dados.length; x++){
								var dadoatual = dados.substring(x,(x+1));
								for( y = 0; y < filtro.length; y++){
									var filtroatual = filtro.substring(y,(y+1));
									if(filtroatual == dadoatual){
										var msg_saida = "Por favor, não utilize caracteres especiais. Substitua o caractere \" "+dadoatual+" \"."
										mostraErro(frm,elemento,msg_saida);				
										return false;
										break;
									}
								}
							}
						};
					}else if (elemento.getAttribute('unibanco_numero_end')){
					//=============================================================================
					// NOME
					//=============================================================================
						if(elemento.value.length < elemento.getAttribute('u_min')){
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}							
							return false;
						};
						if (elemento.getAttribute('u_norepeat')){
							var limite = elemento.getAttribute('u_norepeat');
							var tamanho = elemento.value.length;
							var lastChar = "";
							var atualChar = "";
							var repeatedChar = 0;
							for( x = 0; x < tamanho; x++){
								atualChar = elemento.value.substring(x,(x+1));
								if(atualChar==lastChar){
									repeatedChar++;
									if(repeatedChar >= limite){
										// SE TIVER MAIS CARACTERES REPETIDOS QUE O LIMITE, MOSTRA ERRO
										var msg_saida = "Por favor, não repita o caractere \""+lastChar+"\" mais de \" "+limite+" \" vezes"
										mostraErro(frm,elemento,msg_saida);				
										return false;
									}
								}else{
									repeatedChar = 0;
								}
								lastChar = atualChar;
							};
						};
						if(elemento.value=="s/n" || elemento.value=="S/n" || elemento.value=="s/N" || elemento.value=="S/N"){
							return true;
						}else{
							if (elemento.getAttribute('u_nochars')){
								var filtro = "-!@#$%\"&.*()_+=<>:;?/,'-[{]}|\\º-";
								var dados = elemento.value;
								
								for( x = 0; x < dados.length; x++){
									var dadoatual = dados.substring(x,(x+1));
									for( y = 0; y < filtro.length; y++){
										var filtroatual = filtro.substring(y,(y+1));
										if(filtroatual == dadoatual){
											var msg_saida = "Por favor, não utilize caracteres especiais. Substitua o caractere \" "+dadoatual+" \"."
											mostraErro(frm,elemento,msg_saida);				
											return false;
											break;
										}
									}
								}
							}
						};
					}else if (elemento.getAttribute('unibanco_expedicao_garantidor')){
					//=============================================================================
					// EXPEDIÇÃO GARANTIDOR
					//=============================================================================
						// verifica se está selecionado registro estrangeiro em tipo de documento
						var tipoRegistro = frm.tipo_documento_garantidor.value;
						var nascimento = frm.nascimentoGarantidor.value;
						if(tipoRegistro != "0003" || elemento.value.length > 1){
							// requisita preenchimento minimo caso o registro estrangeiro não seja registro estrangeiro
							if(elemento.value.length < elemento.getAttribute('u_min')){
								if (elemento.getAttribute('erro')) {
									mostraErro(frm,elemento,elemento.getAttribute('erro'));
								} else {
									mostraErro(frm,elemento,"Por favor, preencha o campo");
								}							
								return false;
							};
						}
						var idadeMax = 130;
						var diaMax = 31;
						var mesMax = 12;
						var dataAtual = new Date();
						var anoMax = dataAtual.getFullYear();
						var dia = parseInt(elemento.value.substring(0,2),10);
						var mes = parseInt(elemento.value.substring(3,5),10);
						var ano = parseInt(elemento.value.substring(6,10),10);
						
						if(dia>diaMax || dia<1){
							mostraErro(frm,elemento,"Preencha um dia entre 1 e 31");
							return false;
						}
						if(mes>mesMax || mes<1){
							mostraErro(frm,elemento,"Preencha um mês entre 1 e 12");
							return false;
						}
						if(ano>anoMax || ano<1900){
							mostraErro(frm,elemento,"Preencha um ano entre 1900 e "+anoMax);
							return false;
						}
						if(mes == 2 && dia > 29){
							mostraErro(frm,elemento,"Para o mês de Fevereiro, preencha um dia entre 1 e 29");
							return false;
						}
						/*// nao permite data expedição maior que data atual
						if(ano == anoMax && mes > dataAtual.getMonth()+1){
							mostraErro(frm,elemento,"Insira uma data anterior ou igual à atual");
							return false;
						}else if(ano == anoMax && mes == dataAtual.getMonth()+1){
							if(dia > dataAtual.getDate()){
								mostraErro(frm,elemento,"Insira uma data anterior ou igual à atual");
								return false;
							}
						}*/
						// nao permite que ultrapasse 130 anos
						var hojetemp = dataAtual.getDate()+"/"+(dataAtual.getMonth()+1)+"/"+dataAtual.getFullYear();
						var idade = calculaIdade(elemento.value,hojetemp);
						if(idade > 130){
							mostraErro(frm,elemento,"Insira uma data posterior à idade de 130 anos");
							return false;
						}
						// consistente com a data de nascimento ( não pode ser anterior ao nascimento );
						//dataMenor("27/04/1984","27/04/1984");
						if(nascimento.length == 10){
							if(!dataMenor(nascimento, elemento.value)){
								mostraErro(frm,elemento,"Insira uma data posterior à data de nascimento");
								return false;
							};
						};

					}else if (elemento.getAttribute('unibanco_expedicao')){
					//=============================================================================
					// EXPEDIÇÃO
					//=============================================================================
						// verifica se está selecionado registro estrangeiro em tipo de documento
						var tipoRegistro = frm.tipo_documento.value;
						var nascimento = frm.nascimento.value;
						if(tipoRegistro != "0003" || elemento.value.length > 1){
							// requisita preenchimento minimo caso o registro estrangeiro não seja registro estrangeiro
							if(elemento.value.length < elemento.getAttribute('u_min')){
								if (elemento.getAttribute('erro')) {
									mostraErro(frm,elemento,elemento.getAttribute('erro'));
								} else {
									mostraErro(frm,elemento,"Por favor, preencha o campo");
								}							
								return false;
							};
						}
						var idadeMax = 130;
						var diaMax = 31;
						var mesMax = 12;
						var dataAtual = new Date();
						var anoMax = dataAtual.getFullYear();
						var dia = parseInt(elemento.value.substring(0,2),10);
						var mes = parseInt(elemento.value.substring(3,5),10);
						var ano = parseInt(elemento.value.substring(6,10),10);
						
						if(dia>diaMax || dia<1){
							mostraErro(frm,elemento,"Preencha um dia entre 1 e 31");
							return false;
						}
						if(mes>mesMax || mes<1){
							mostraErro(frm,elemento,"Preencha um mês entre 1 e 12");
							return false;
						}
						if(ano>anoMax || ano<1900){
							mostraErro(frm,elemento,"Preencha um ano entre 1900 e "+anoMax);
							return false;
						}
						if(mes == 2 && dia > 29){
							mostraErro(frm,elemento,"Para o mês de Fevereiro, preencha um dia entre 1 e 29");
							return false;
						}
						// nao permite data expedição maior que data atual
						if(ano == anoMax && mes > dataAtual.getMonth()+1){
							mostraErro(frm,elemento,"Insira uma data anterior ou igual à atual");
							return false;
						}else if(ano == anoMax && mes == dataAtual.getMonth()+1){
							if(dia > dataAtual.getDate()){
								mostraErro(frm,elemento,"Insira uma data anterior ou igual à atual");
								return false;
							}
						}
						// nao permite que ultrapasse 130 anos
						var hojetemp = dataAtual.getDate()+"/"+(dataAtual.getMonth()+1)+"/"+dataAtual.getFullYear();
						var idade = calculaIdade(elemento.value,hojetemp);
						if(idade > 130){
							mostraErro(frm,elemento,"Insira uma data posterior à idade de 130 anos");
							return false;
						}
						// consistente com a data de nascimento ( não pode ser anterior ao nascimento );
						//dataMenor("27/04/1984","27/04/1984");
						if(nascimento.length == 10){
							if(!dataMenor(nascimento, elemento.value)){
								mostraErro(frm,elemento,"Insira uma data posterior à data de nascimento");
								return false;
							};
						};
					}else if (elemento.getAttribute('unibanco_formacao')){
					//=============================================================================
					// FORMAÇAO
					//=============================================================================
						if(elemento.value.length < elemento.getAttribute('u_min')){
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}							
							return false;
						};
						var anoMin = dataAtual.getFullYear();
						var anoMax = anoMin + 6;
						var ano = parseInt(elemento.value);
						if(ano>anoMax || ano<anoMin){
							var saida = "Preencha um ano entre "+anoMin+" e "+anoMax;
							mostraErro(frm,elemento, saida);
							return false;
						}
					}else if (elemento.getAttribute('unibanco_nascimento')){
					//=============================================================================
					// DATA NASCIMENTO
					//=============================================================================
						// requisita preenchimento minimo caso o registro estrangeiro não seja registro estrangeiro
						if(elemento.value.length < elemento.getAttribute('u_min')){
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}							
							return false;
						};
						
						var idadeMax = 130;
						var diaMax = 31;
						var mesMax = 12;
						var dataAtual = new Date();
						var anoMax = dataAtual.getFullYear();
						var dia = parseInt(elemento.value.substring(0,2),10);
						var mes = parseInt(elemento.value.substring(3,5),10);
						var ano = parseInt(elemento.value.substring(6,10),10);
						
						if(dia>diaMax || dia<1){
							mostraErro(frm,elemento,"Preencha um dia entre 1 e 31");
							return false;
						}
						if(mes>mesMax || mes<1){
							mostraErro(frm,elemento,"Preencha um mês entre 1 e 12");
							return false;
						}
						if(ano>anoMax || ano<1900){
							mostraErro(frm,elemento,"Preencha um ano entre 1900 e "+anoMax);
							return false;
						}
						if(mes == 2 && dia > 29){
							mostraErro(frm,elemento,"Para o mês de Fevereiro, preencha um dia entre 1 e 29");
							return false;
						}
						// nao permite data nascimento maior que data atual
						if(ano == anoMax && mes > dataAtual.getMonth()+1){
							mostraErro(frm,elemento,"Insira uma data anterior à atual");
							return false;
						}else if(ano == anoMax && mes == dataAtual.getMonth()+1){
							if(dia > dataAtual.getDate()){
								mostraErro(frm,elemento,"Insira uma data anterior à atual");
								return false;
							}
						}
						// nao permite que ultrapasse 130 anos
						var hojetemp = dataAtual.getDate()+"/"+(dataAtual.getMonth()+1)+"/"+dataAtual.getFullYear();
						var idade = calculaIdade(elemento.value,hojetemp);
						if(idade > 130){
							mostraErro(frm,elemento,"Insira uma data posterior â idade de 130 anos");
							return false;
						}
					}else if (elemento.getAttribute('unibanco_ddd')){
					//=============================================================================
					// DDD
					//=============================================================================
						// requisita preenchimento minimo caso o registro estrangeiro não seja registro estrangeiro
						if(elemento.value.length < elemento.getAttribute('u_min')){
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}							
							return false;
						};
						
						var numMax = 99;
						var numMin = 11;
						var ddd = parseInt(elemento.value, 10);
						
						if(ddd>numMax){
							mostraErro(frm,elemento,"Preencha um DDD válido");
							return false;
						}
						if(ddd<numMin){
							mostraErro(frm,elemento,"Preencha um DDD válido");
							return false;
						}
					}else if (elemento.getAttribute('unibanco_fone')){
					//=============================================================================
					// FONE
					//=============================================================================
						// requisita preenchimento minimo caso o registro estrangeiro não seja registro estrangeiro
						if(elemento.value.length < elemento.getAttribute('u_min')){
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}							
							return false;
						};
						
						if (elemento.getAttribute('u_norepeat')){
							var limite = elemento.getAttribute('u_norepeat');
							var arraytemp = elemento.value.split("-");
							var dados = arraytemp[0]+arraytemp[1];
							
							var tamanho = dados.length;
							var lastChar = "";
							var atualChar = "";
							var repeatedChar = 0;
							for( x = 0; x < tamanho; x++){
								atualChar = dados.substring(x,(x+1));
								if(atualChar==lastChar){
									repeatedChar++;
									if(repeatedChar >= limite){
										// SE TIVER MAIS CARACTERES REPETIDOS QUE O LIMITE, MOSTRA ERRO
										var msg_saida = "Por favor, não repita o caractere \""+lastChar+"\" mais de \" "+limite+" \" vezes"
										mostraErro(frm,elemento,msg_saida);				
										return false;
									}
								}else{
									repeatedChar = 0;
								}
								lastChar = atualChar;
							};
						};
					}else if (elemento.getAttribute('unibanco_email')){
					//=============================================================================
					// EMAIL
					//=============================================================================
						if (trim(elemento.value).indexOf("@") == -1 || trim(elemento.value).indexOf(".") == -1) {
							if (elemento.getAttribute('erro')){
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, digite um email válido");
							}
							return false;
						}
						
						if (elemento.getAttribute('compara')){
							var campo = elemento.getAttribute('compara');
							if(elemento.value != frm.elements[campo].value){
								mostraErro(frm,elemento,"E-mails não coincidem");					
								return false;							
							}
						}
						// Não pode ter /  \ < >
						// Não permite espaço em branco.
						var filtro = " /\\ <> ";
						var dados = elemento.value;
						for( x = 0; x < dados.length; x++){
							var dadoatual = dados.substring(x,(x+1));
							for( y = 0; y < filtro.length; y++){
								var filtroatual = filtro.substring(y,(y+1));
								if(filtroatual == dadoatual){
									var msg_saida = "Por favor, não utilize caracteres especiais ou espaços. Substitua o caractere \" "+dadoatual+" \"."
									mostraErro(frm,elemento,msg_saida);				
									return false;
									break;
								}
							}
						}
						//Não pode ter mais de um @
						var arrayArroba = dados.split("@");
						if(arrayArroba.length > 2){
							var msg_saida = "Por favor, digite um email válido."
							mostraErro(frm,elemento,msg_saida);				
							return false;
							break;
						}
						
						//
						
						//Não permite final: .con.br, .com.b, com/
						//Não pode terminar com arroba ou ponto.
						//Não pode começar com arroba.
						var final_1 = dados.slice(-7);
						var final_2 = dados.slice(-6);
						var final_3 = dados.slice(-1);
						var final_4 = dados.substring(0, 1);
						
						final_1 = final_1.toLowerCase();
						final_2 = final_2.toLowerCase();
						final_3 = final_3.toLowerCase();
						final_4 = final_4.toLowerCase();

						if(final_1 == ".con.br" || final_2 == ".com.b" || final_2 == ".c" || final_3 == "/" || final_3 == "@" || final_3 == "." || final_4 == "@"){
							var msg_saida = "Por favor, digite um email válido."
							mostraErro(frm,elemento,msg_saida);				
							return false;
							break;
						}
						
						var indexArroba = dados.indexOf("@");
						var char1 = dados.substring(indexArroba-1, indexArroba);
						var char2 = dados.substring(indexArroba+1, indexArroba+2);
						if(char1 == "." || char2 == "."){
							var msg_saida = "Por favor, digite um email válido."
							mostraErro(frm,elemento,msg_saida);				
							return false;
							break;
						}
						/*
						Não pode ter ponto antes ou após de @
						*/
					}else if (elemento.getAttribute('unibanco_mensalidade')){
					//=============================================================================
					// MENSALIDADE
					//=============================================================================
						if(elemento.value.length < elemento.getAttribute('u_min')){
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}							
							return false;
						};
						
						var valorMin = 100;
						var valorMax = 6000;
						var valortemp = elemento.value.split(".");
						var valorsemponto = valortemp.join("");
						var valorAtual = parseInt(valorsemponto,10);						
						if (valorAtual < valorMin || valorAtual > valorMax){
							var msg_saida = "Por favor, digite um valor entre R$100,00 e R$6.000,00";
							mostraErro(frm,elemento,msg_saida);				
							return false;
							break;
						}else{
						calculaMensalidade();
						}
					//=============================================================================
					// DEFAULT
					//=============================================================================
					}else{
						if (trim(elemento.value) == "") {
							if (elemento.getAttribute('erro')) {
								mostraErro(frm,elemento,elemento.getAttribute('erro'));
							} else {
								mostraErro(frm,elemento,"Por favor, preencha o campo");
							}
							return false;
						}
					}
					break;
				case "textarea" :
					if (trim(elemento.value) == "") {
						if (elemento.getAttribute('erro')) {
							mostraErro(frm,elemento,elemento.getAttribute('erro'));
						} else {
							mostraErro(frm,elemento,"Por favor, preencha o campo");
						}
						return false;
					}
					break;	
				default :
					if (trim(elemento.value) == "") {
						if (elemento.getAttribute('erro')) {
							mostraErro(frm,elemento,elemento.getAttribute('erro'));
						} else {
							mostraErro(frm,elemento,"Campo obrigatório");
						}
						return false;
					}
				break;
			}
		}
	}

	// envia o formulário apenas caso a validação seja a global
	if(!isself){
		//var formulario = document.getElementById(frm.id);
		//formulario.submit();
	}
}

function trim(str) {
	while(str.charAt(0) == (" ") ) {
		str = str.substring(1);
	}
	while(str.charAt(str.length-1) == " " ) {
		str = str.substring(0,str.length-1);
	}
	return str;
}	

function mostraErro(frm,elemento,msg) {
	if(elemento.getAttribute('editor')){
		element = document.getElementById('mce_editor_1');
		calculaWidHei(element);
	}else{
		calculaWidHei(elemento);
	}

	mostraDiv(frm,msg,elemento);
	/*
	if(elemento.type == "select-one"){
		if ((!document.all)&&(document.getElementById)){
			atrib = elemento.getAttribute("onchange");
			if(atrib != null){
				elemento.setAttribute("onchange",atrib+"hideDiv(event.keyCode);");
			}else{
				elemento.setAttribute("onchange","hideDiv(event.keyCode);");				
			}
		}    
		if ((document.all)&&(document.getElementById)){
			atrib = elemento.getAttribute("onchange");
			atribute = elemento.getAttributeNode('onChange').value;
			if(atrib != null){
				elemento["onchange"] = new Function(atribute+"hideDiv(event.keyCode);");
			}else{
				elemento["onchange"] = new Function("hideDiv(event.keyCode);");				
			}

		}
	}else if(elemento.type == "radio"){
		if ((!document.all)&&(document.getElementById)){
			//atrib = elemento.getAttribute("onclick");
			for (i=0; i<frm.elements[elemento.name].length; i++) {
				atrib = frm.elements[elemento.name][i].getAttribute("onclick");
				
				if(atrib == null){
					atrib = "";	
				}
				
				frm.elements[elemento.name][i].setAttribute("onclick",atrib+"hideDiv(event.keyCode);RadioButtons("+frm.name+",'"+elemento.name+"');");
			}
		}    
		if ((document.all)&&(document.getElementById)){
			//atribute = elemento.getAttributeNode('onclick').value;
			for (i=0; i<frm.elements[elemento.name].length; i++) {
				atrib = elemento.getAttribute("onclick");
				
				if(atrib != null){
					atribute = frm.elements[elemento.name][i].getAttributeNode("onclick").value;	
					//alert("atribute = "+atribute);
					if(atribute == null){
						atribute='';	
					}
					frm.elements[elemento.name][i]["onclick"] = new Function(atribute+"hideDiv(event.keyCode);");
					//alert(frm.elements[elemento.name][i]["onclick"]);

				}else{
					frm.elements[elemento.name][i]["onclick"] = new Function("hideDiv(event.keyCode);RadioButtons("+frm.name+",'"+elemento.name+"');");
				}
				
			}
		}
	}else{
	*/

		if ((!document.all)&&(document.getElementById)){
			elemento.setAttribute("onkeyup",";hideDiv(event.keyCode);");
		}    
		if ((document.all)&&(document.getElementById)){
			elemento["onkeyup"] = new Function(";hideDiv(event.keyCode);");
		}

	/*
	}
	*/
}

function mostraDiv(frm,msg,elemento) {
	var mensagem = document.createTextNode(msg);

	var divErro = document.createElement('div');
	divErro.setAttribute('id','divErro');
	divErro.setAttribute('name','divErro');
	frm.appendChild(divErro);
	divErro.style.left = Math.floor(pos_l + (wid / 2))+"px";//pos_l = frm.offsetWidth;
	divErro.style.position = "absolute";
	divErro.style.zIndex = "1003";
	
	var conteudoDivErro = document.createElement("div");
	conteudoDivErro.style.float = 'left';

	
	var divMsg = document.createElement('div');
	divMsg.id = 'divMsg';
	divMsg.style.padding = '3px';
	divMsg.style.borderRight = '1px solid ' + borderColor;
	divMsg.style.borderBottom = '1px solid ' + borderColor;
	divMsg.style.color = '#333333';
	divMsg.style.fontWeight = 'bold';
	divMsg.style.backgroundColor = bgColor;
	divMsg.style.fontFamily = 'Verdana, Tahoma, Arial';
	divMsg.style.fontSize = '10px';
	divMsg.style.borderTop = '1px solid ' + borderColor;	
	divMsg.style.borderLeft = '1px solid ' + borderColor;	
	if(wid/2 > 200){
		divMsg.style.width =  Math.floor(wid/2)+"px";
	}else{
		divMsg.style.width = "200px";			
	}

	divMsg.appendChild(mensagem);
	conteudoDivErro.appendChild(divMsg);
	divErro.appendChild(conteudoDivErro);

	larguraDivErro = divErro.offsetWidth;
	alturaDivErro = divErro.offsetHeight;

	alturaDivMsg = divMsg.offsetHeight;	

	larguraDivMsg = divMsg.offsetWidth;
	
	divErro.style.top = (pos_t - alturaDivMsg - 5)+"px";
	mostrarSombra(frm,msg);
	//alert(navigator.userAgent.indexOf('MSIE'));
	if (navigator.userAgent.indexOf('MSIE') > 0) {
		mostraIframe(frm,msg);
	}
	if(!isself){
		window.scrollTo(0,((pos_t-alturaDivMsg)-30));
	}
	elemento.focus();
}

function mostrarSombra(frm,msg) {
	var sombraErro = document.createElement('div');
	frm.appendChild(sombraErro);
	sombraErro.setAttribute('id','sombraErro');
	sombraErro.setAttribute('name','sombraErro');
	frm.appendChild(sombraErro);
	
	if (navigator.userAgent.indexOf('MSIE') > 0) {
		sombraErro.style.width = larguraDivMsg;
		sombraErro.style.height = alturaDivMsg;
	}else{
		sombraErro.style.width = larguraDivMsg-5
		sombraErro.style.height = alturaDivMsg-3;
	}
	
	sombraErro.style.left =  Math.floor((pos_l + (wid / 2) + 4))+"px";
	sombraErro.style.top =  Math.floor((pos_t - alturaDivMsg -5) + 7)+"px";
	sombraErro.style.position = "absolute";
	sombraErro.style.filter = "alpha(opacity = 30)";
	sombraErro.style.mozOpacity = "0.30";
	sombraErro.style.opacity = "0.30";
	sombraErro.style.backgroundColor = "#000000";
	sombraErro.style.khtmlOpacity = "0.30";
	sombraErro.style.zIndex = "1002";
		
}

function mostraIframe(frm,msg) {
	var iframeErro = document.createElement('iframe');
	iframeErro.name= "iframeErro";
	iframeErro.id= "iframeErro";
	iframeErro.width = larguraDivMsg + 4 + "px";
	iframeErro.height = alturaDivMsg + 10 + "px";
	iframeErro.frameborder= "no";
	frm.appendChild(iframeErro);
	
	iframeErro.style.left =  Math.floor(pos_l + (wid / 2))+"px"; // Posicionando iframe ao centro do elemento
	iframeErro.style.top = pos_t - alturaDivMsg - 5; // Posicionando Div acima do elemento
	iframeErro.style.position = "absolute"; // Iframe flutuante
	iframeErro.style.filter = "alpha(opacity = 0)"; // Transparência para não mostrar o iframe
	iframeErro.style.zIndex = "1020"; // Iframe nivel 1
}

// Função para calcular a Largura e Altura do elemento e seu Left: e Top:
function calculaWidHei(elemento) {
	if (elemento.offsetParent) {
		wid = elemento.offsetWidth;
		hei = elemento.offsetHeight;
		pos_l = elemento.offsetLeft;
		pos_t = elemento.offsetTop;
		while (elemento = elemento.offsetParent) {
			pos_l += elemento.offsetLeft;
			pos_t += elemento.offsetTop;
		}
	}	
}
function RadioButtons(frm,element){
	for (i=0; i<frm.elements[element].length; i++) {
//		if(frm.elements[element][i].getAttribute("obrigatorio")){
			frm.elements[element][i].removeAttribute("obrigatorio")
//		}
	}
	/*   
	//document.form[frm].eleme
	alert(frm.elements[element].length);
	
	frm.elements[element].removeAttribute('obrigatorio');
	*/
}

function hideDiv(event){
	if(event != 13){
		var divErro = document.getElementById('divErro');
		var sombraErro = document.getElementById('sombraErro');
		var iframeErro = document.getElementById('iframeErro');
		
		if (divErro) {
			divErro.style.display = "none";
		}
		
		if (sombraErro) {
			sombraErro.style.display = 'none';
		}
		
		if (iframeErro) {
			iframeErro.style.display = 'none';
		}
	}
}


//////////////////////////////

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

//////////////////////////////////////////

	

function Mascara (formato, keypress, objeto){
	campo = document.getElementById(objeto);
//onlynum(objeto);
//campo = eval (objeto);

// CEP
if (formato=='CEP'){
	cep = campo.value.replace(/[-]/g, "");
	ini = cep.substring(0,5);
	fim = cep.substring(5,8);
	campo.value = ini+"-"+fim;
}

// DATA
if (formato=='DATA'){
	data = campo.value.replace(/[/]/g, "");
	dia = data.substring(0,2);
	mes = data.substring(2,4);
	ano = data.substring(4,10);
	campo.value = dia+"/"+mes+"/"+ano;
}

// TELEFONE
if (formato=='TELEFONE'){
	tel = campo.value.replace(/[-]/g, "");
	ini = tel.substring(0,4);
	fim = tel.substring(4,8);
	campo.value = ini+"-"+fim;
}


}



////////////////////////////////////////////////////

//calcular a idade de uma pessoa

function calculaIdade(data,dataHoje) {
	var x = data.split("/");
	var h = dataHoje.split("/");
	var anosProvisorio = h[2] - x[2];

	if(h[1] < x[1]) {
		anosProvisorio -= 1;
	}else if(h[1] == x[1]) {
		if(h[0] < x[0]) {
			anosProvisorio -= 1;
		};
	};
	
	return anosProvisorio;
};

//verifica se a data 1 é menor que a data 2
function dataMenor(pdata1,pdata2) {
	var data1 = pdata1.split("/");
	var data2 = pdata2.split("/");
	// ano maior ?
	if(data1[2]<data2[2]){
		return true;
	}else if(data1[2]>data2[2]){
		return false;
	}else{
		// mes maior?
		if(data1[1]<data2[1]){
			return true;
		}else if(data1[1]>data2[1]){
			return false;
		}else{
			// dia maior?
			if(data1[0]<data2[0]){
				return true;
			}else{
				return false;
			}
		}
	}
};