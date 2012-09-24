/***
*	�ndice:
*
*	Log para Debug............................: 20
*	Redimensionar por classe..................: 45
*	Link Ativo................................: 65
*	Blank.....................................: 79
*	Classe Voltar.............................: 92
*	Tira bordas do Flash no IE................: 104
*	Reset de formul�rio.......................: 149
*	Exibe div de bloqueio.....................: 165
*	AbsoluteCenter............................: 230
*
****/

/***
*	:: Log para Debug ::
*	:: 2007 ::
*
*	l(<Mensagem>,<true ou false para IE>);
*
*	Exibe um log para Debug.
*	ex:
*		l("testando");
*		l("testando",true);
***/
function l(x,consoleIE){
	consoleIE = typeof(consoleIE) == "undefined" ? false : consoleIE;
	if(window.console){
		console.log(x);
	}else if(consoleIE){
		if(!$("#dmDebug").is("div")){
			$("body").append("<div id=\"dmDebug\" style=\"width:"+($(window).width()-50+"px")+"; border:1px solid #000; position:absolute; bottom:0; left:0; height:150px; overflow:auto; filter:alpha(opacity=80); font-size:12px; padding:5px; font-family:Tahoma, Arial, Helvetica, sans-serif; background:#fff; z-index:99999;\"></div>");
		}
		$("#dmDebug").append("<p style=\"margin:0; border-bottom:1px dashed #000; color: #000; font-weight: bold;\">"+x+"</p>");
	}
}


$(document).ready( function(){
	/***
	*	:: Redimensionar por classe ::
	*	:: 2007 ::
	*
	*	Redimenciona um elemente setando uma classe para ele.
	*	ex:
	*		<div class="width150">teste</div>
	*		<div class="height5050">teste</div>
	***/
	$("*[class*=width]").each(function(){
		var dmClasses = $(this).attr("class").split(" ");
		$.each(dmClasses, function(i,n){ if(n.indexOf("width") != -1){ dmTamanho = dmClasses[i].replace("width",""); } });
		$(this).css("width",dmTamanho+"px");
	});
	$("*[class*=height]").each(function(){
		var dmClasses = $(this).attr("class").split(" ");
		$.each(dmClasses, function(i,n){ if(n.indexOf("height") != -1){ dmTamanho = dmClasses[i].replace("height",""); } });
		$(this).css("height",dmTamanho+"px");
	});

	/***
	*	:: Link Ativo ::
	*	:: 2007 ::
	*
	*	Adiciona a classe "ativo" para o link que tiver o destino (href) identico � pagina aberta
	***/
	dmPaginaAtivo = window.location+"";
	dmPaginaAtivo = dmPaginaAtivo.split("/").pop();
	if(dmPaginaAtivo != ""){
		$('a[href="'+dmPaginaAtivo+'"]').addClass('ativo');
		$('a[href="'+dmPaginaAtivo+'"]').siblings('ul').removeClass('hide');
		$('a[href="'+dmPaginaAtivo+'"]').parents('ul').removeClass('hide').siblings('a').addClass('ativo');
	}
		
	/***
	*	:: Blank ::
	*	:: 2007 ::
	*
	*	Abre um link em uma nova janela.
	*	ex:
	*		<a href="http://www.agenciadmk.com.br/" title="Agencia DMK" class="blank">Ag�ncia DMK</a>
	***/
	$(".blank").live('click',function(){
		window.open($(this).attr("href"));
		return false;
	});
	
	/***
	*	:: Classe Voltar ::
	*
	*	Adiciona um evento em um objeto que volta no hist�rico no navegador
	*	Ex.: <a href="javascript:void(0);" title="voltar" class="voltar">voltar</a>
	***/
	$(".voltar").live('click',function(){
		window.history.go(-1);
		return false;
	});

	/***
	*	:: Tira bordas do Flash no IE ::
	*	:: 2008 ::
	*
	*	Retira as bordas pontilhadas do flash no Internet Explorer
	*	Ex.: 	$("#flash").addFlash({
	*				src: "swf/banner2.swf",
	*				width: 584,
	*				height: 201,
	*				title: "Nome do banner"
	*			});
	***/
	$.extend({
		addFlash: {
			version: 1.2,
			defaults: {
				src: "",
				width: 100,
				height: 50,
				title: "",
				quality: "high",
				menu: "false",
				wmode: "transparent"
			}
		}
	});
	$.fn.extend({
		addFlash: function(options){
			options = $.extend({}, $.addFlash.defaults, options);
			return this.each(function(){
				if(options.src != ""){
					var flash = '<object type="application/x-shockwave-flash" data="'+options.src+'?clicktag=./" width="'+options.width+'" height="'+options.height+'" tabindex="0" title="'+options.title+'">'
					flash += '<param name="movie" value="'+options.src+'?clicktag=./" />'
					flash += '<param name="quality" value="'+options.quality+'" />'
					flash += '<param name="menu" value="'+options.allowFullScreen+'" />'
					flash += '<param name="wmode" value="'+options.wmode+'" />'
					flash += '<p>Para visualizar este conte�do corretamente, � necess�rio ter o <a title="Clique para instalar o flash player" href="http://www.macromedia.com/shockwave/download/alternates/" rel="nofollow">Flash Player</a> instalado.</p>'
					flash += '</object>'
					$(this).html(flash);
				}
			});
		}
	});

	/***
	*	:: Reset de formul�rio ::
	*	:: 2007 ::
	*
	*	Reseta um formul�rio
	*	Ex.: $("#contato").resetForm();
	***/
	$.fn.resetForm = function() {
		return this.each(function() {
			dmRfName = $(this).attr("name") + "";
			dmRfName = dmRfName == "undefined" || dmRfName == "" ? "dmRfName" : dmRfName;
			$(this).attr("name",dmRfName);
			eval("document."+dmRfName+".reset()");
		});
	}; 

	
	/***
	*	:: Exibe div de bloqueio ::
	*	:: 2007 ::
	*
	*	Fun��o que abre uma div cobrindo toda a tela bloqueando o site, com fun��o de callback.
	*	ex:
	*		bloqueia({ speed: "slow", bgcolor: "#000" });
	*		bloqueia({ speed: "slow", evento: "fim" });
	*
	*	OBS: Nescess�rio plugin Dimension.
	***/
	bloqueia = function(options,callback){
		var defaults = {
			versao: 2.1,
			id: "bloqueio",
			evento: "inicio",
			bgColor: "#000",
			opacity: "0.5",
			speed: "normal",
			zIndex: "100",
			cursor: "default",
			animate: true
		}
		options = $.fn.extend({},defaults,options);

		if((options.id == "" || options.id == "bloqueio") && !$("#bloqueio").is("div")) $("body").append("<div id=\"bloqueio\" style=\"display:none\"></div>");

		var altura = $(document).height() > $(window).height() ? $(document).height() : $(window).height();

		if(options.evento == "inicio"){
			if($.browser.msie && $.browser.version == "6.0") $("select:visible").addClass("hiddenForDmBlock").css("visibility","hidden");
			$("#"+options.id).css({
				background:options.bgColor,
				cursor:options.cursor,
				height:altura,
				left:"0",
				opacity:options.opacity,
				position:"absolute",
				top:"0",
				width:"100%",
				zIndex:options.zIndex
			});
			if(options.animate){
				$("#"+options.id).fadeIn(options.speed, function(){ if(typeof(callback) != "undefined"){ callback(); } });
			}else{
				$("#"+options.id).css("display","block");
				if(typeof(callback) != "undefined"){ callback(); }
			}
			carregandoResize = function(){
				altura = $(document).height() > $(window).height() ? $(document).height() : $(window).height();
				$("#"+options.id).css({height:altura});
			}
			$(window).bind('resize',carregandoResize);
		}else{
			$("select.hiddenForDmBlock").css("visibility","visible");
			$(window).unbind('resize',carregandoResize);
			if(options.animate){
				$("#"+options.id).fadeOut(options.speed, function(){ if(typeof(callback) == "function"){ callback(); } });
			}else{
				$("#"+options.id).css("display","none");
				if(typeof(callback) == "function"){ callback(); }
			}
		}
	}
	
	/***
	*	:: Absolute Center ::
	*
	*	Fun��o que centraliza um objeto na tela.
	*	ex:
	*		$("#teste").absoluteCenter({limit:[0,10,0,10]});
	*		$("#teste").absoluteCenter({clear:true;}
	*
	*	OBS: Nescess�rio plugin Dimension.
	***/
	$.fn.extend({
		absoluteCenter: function(options, speed, callback){
			var defaults = {
				dellay: 100,
				limitTop: 0,
				limitRight: 0,
				limitBottom: 0,
				limitLeft: 0,
				limit: null,
				animation: true,
				clear:false
			}
			options = $.extend({}, defaults, options);
					
			if(options.limit != null){
				if(typeof(options.limit) == "object"){
					options.limitTop = typeof(options.limit[0]) != "undefined" ? options.limit[0] : options.limitTop;
					options.limitRight = typeof(options.limit[1]) != "undefined" ? options.limit[1] : options.limitRight;
					options.limitBottom = typeof(options.limit[2]) != "undefined" ? options.limit[2] : options.limitBottom;
					options.limitLeft = typeof(options.limit[3]) != "undefined" ? options.limit[3] : options.limitLeft;
				}else{
					options.limitTop = options.limit;
					options.limitRight = options.limit;
					options.limitBottom = options.limit;
					options.limitLeft = options.limit;
				}
			}
			
			speed = typeof(speed) == "undefined" ? "fast" : speed;
			
			return this.each(function(){

				var obj = this;
				var timeOut = null;
				
				var ajustaScroll = function(){
					
					if($(obj).css("display") == "none") $(window).unbind("scroll",ajustaScroll).unbind("resize",ajustaScroll);
					
					var altura = parseInt($(obj).outerHeight());
					var largura = parseInt($(obj).outerWidth());
					
					var limiteC = parseInt($(obj).css("top"));
					var limiteB = limiteC + altura;
					var limiteE = parseInt($(obj).css("left"));
					var limiteD = limiteE + largura;
					
					var scrollTop = parseInt($(window).scrollTop());
					var scrollLeft = parseInt($(window).scrollLeft());
					var janelaAltura = parseInt($(window).height());
					var janelaLargura = parseInt($(window).width());
					
					var documentoAltura = parseInt($("body").outerHeight());
					var documentoLargura = parseInt($(document).width());
					
					var top = janelaAltura > altura
						? parseInt(scrollTop + (( janelaAltura / 2 ) - parseInt(altura / 2)))
						: scrollTop < (limiteC - options.limitTop)
							? scrollTop + options.limitTop
							: (scrollTop + janelaAltura) > (limiteB + options.limitBottom)
								? scrollTop - (altura - janelaAltura) - options.limitBottom
								: limiteC
					;
					top = (top + altura) > documentoAltura ? documentoAltura - altura : top;
					
					var left = janelaLargura > largura
						? parseInt(scrollLeft + (( janelaLargura / 2 ) - parseInt(largura / 2)))
						: scrollLeft < (limiteE - options.limitLeft)
							? scrollLeft + options.limitLeft
							: (scrollLeft + janelaLargura) > (limiteD + options.limitRight)
								? scrollLeft - (largura - janelaLargura) - options.limitRight
								: limiteE
					;
					left = (left + largura) > documentoLargura ? documentoLargura - largura : left;
														
					top = isNaN(top) ? 0 : top;
					left = isNaN(left) ? 0 : left;
					
					top = top < 0 ? 0 : top;
					
					if(options.animation){
						clearTimeout(timeOut);
						timeOut = setTimeout(function(){
							$(obj).animate({top:top+"px",left:left+"px"},speed,function(){ if(typeof(callback) != "undefined") callback(); });
						},options.dellay);
					}else{
						$(obj).css({top:top+"px",left:left+"px"});
					}
					
				}
				ajustaScroll();
				
				if(options.animation) {
					$(window).unbind('scroll', ajustaScroll).unbind('resize', ajustaScroll);
					$(window).scroll(ajustaScroll).resize(ajustaScroll);
				}

			});
		}
	});
	
/***
	*	:: Valida��o Gen�rica ::
	*	:: 2008 ::
	*
	*	Valida��o gen�rica para formul�rios. Para adicionar uma valida��o em um campo, atribuir a classe
	*	"validar" e no atributo "title", acrescentar as regras.
	*
	*	Regras:
	*	-------
	*		min:<inteiro>
	*			Quantidade m�nima de caracteres.
	*			{min:1}
	*
	*		max:<inteiro>
	*			Quantidade m�xima de caracteres
	*			{max:5}
	*
	*		igualA:<string>
	*			Igual a valor de um outro campo ou a string
	*			{igualA:'teste'} ou {igualA:'#texte'}
	*		
	*		diferenteDe:<string>
	*			Diferente do valor de um outro campo ou a string
	*			{diferenteDe:'teste'} ou {diferenteDe:'#texte'}
	*		
	*		tipo:<string>
	*			Define o tipo obrigat�rio
	*			"inteiro" / "int": Num�rico inteiro
	*			"email" / "e-mail": E-mail
	*			"data": Data tipo dd/mm/aaaa
	*			"obrigat�rio": Preenchimento obrigat�rio
	*	
	*	Ex.:
	*	----
	*		<input id="teste" name="teste" type="text" class="validar" title="Teste{min:5,tipo:'email',max:50,diferenteDe:'exemplo@dominio.com.br'}" />
	*	
	*	M�todos:
	*	--------
	*		validar.init()
	*			Inicializa a valida��o aplicando os eventos.
	*		validar.form(<string opcional>)
	*			Executa a valida��o em um determinado formul�rio.
	*		validar.verificaCampos(<objetos>)
	*			Executa a valida��o em um conjunto de objetos espec�ficos.
	***/
	/*
	validar = {
		versao: "2.15.8.2008",
		
		// Vari�veis
		obj: null,
		nome: null,
		valor: null,
		valido: true,
		msg: null,
		campos: new Object(),
		timeout: null,
		
		// Inicializa��o
		init: function(){
			$(".validar").each(function(){
				
				var regras = $(this).attr("title");
				var obj = $(this);
				
				if(typeof(regras) != "undefined"){
					if(regras.indexOf("{") > 0){

						// Gera as regras
						var opcoes = new Object();
						regras = regras.substring(regras.indexOf("{"),regras.length).replace("{","").replace("}","").split(",");
						
						$.each(regras,function(i,val){
							var nome = val.split(":")[0];
							var valor = eval(val.split(":")[1].replace("(doispontos)",":"));
							opcoes[nome] = valor;
						});
						
						// Cria uma biblioteca com os campos e as regras
						validar.campos[$(this).attr("id")] = opcoes;

						// Eventos
						var validacaoBlur = function(){
							validar.obj = $(this);
							validar.valor = $(this).val();
							validar.valido = true;
							validar.verifica();
						}
						$(this).not(".calendario").unbind('blur',validacaoBlur).blur(validacaoBlur);
						
						// M�scaras
						if($(this).attr("title").indexOf("mascara") != -1){
							switch(opcoes.mascara){
								case "R$": $(this).maskMoney({symbol:"",decimal:",",thousands:"."}); break;
								default: $(this).mask(opcoes.mascara); break;
							}
						}
						
						if($(this).attr("title").indexOf("inteiro") != -1){
						
				            $(this).keypress(function(e){
            					
					            if ($.browser.msie){
						            var char = e.keyCode;
						            if (char < 48 || char > 57 && char != 8 && char != 9) return false;
					            }else{
						            var char = e.which
						            if (char && char != 8 && (char < 48 || char > 57)) { e.preventDefault(); }
					            }
            	
				            })
		    
						}						
					}
				}
				
				var titulo = $(this).attr("title");
				$(this).attr("title",titulo.split("{")[0]);

			});
			
		if($(".validar").length > 0){
			$("form").unbind('submit',validar.form).submit(validar.form);
		}
		},
		
		form: function(form){
			var valido = true;
			//obj = typeof(form) == "string" ? $(form) : typeof(form) == "object" ? form : this;
			//obj = this;
			$(".validar",form).each(function(){
				//if(!$(this).parents(":hidden:eq(0)").is(":hidden")){
					if(valido){
						validar.obj = $(this);
						validar.valor = $(this).val();
						validar.valido = true;
						validar.verifica();
						valido = validar.valido;
						if(!validar.valido) $(validar.obj).focus();
					}
				//}
			});
			
			return valido;
		},
		
		// Fun��o que faz as verifica��es
		verifica: function(){
			if($(validar.obj).hasClass("validar")) {
				var id = $(validar.obj).attr("id");
				$.each(validar.campos[id],function(funcao,val){
					if(validar.valido && funcao != "mascara") validar[funcao](val);
				});
				if(!validar.valido){
					$(validar.obj).removeClass("form_ok").addClass("form_erro");
					validar.nome = $(validar.obj).attr("title");
					validar.exibeMsg();
				}else{
					$(validar.obj).removeClass("form_erro").addClass("form_ok");
				}
			}
		},
		
		// Exibir mensagem
		exibeMsg: function(){

			var msg = "O campo <strong>\""+validar.nome+"\"</strong> "+validar.msg // Mensagem

			// Gera Box da mensagem
			var posicaoBox = function(){
				$(".boxMsg").css($(validar.obj).offset({scroll: false, border: true, padding: true}));
				$(".boxMsg").css({
					opacity: "0.9",
					top: parseInt($(".boxMsg").css("top")) - parseInt($(".boxMsg").height()) - 22,
					left: parseInt($(".boxMsg").css("left")) - 1
				});
//				setTimeout(function(){
//					if($(".boxMsg").is("div")) posicaoBox();
//				},100);
			}
			$(".boxMsg").remove();
			$("body").prepend("<div class=\"boxMsg\" style=\"display:none;\">"+msg+"</div>");
			$(".boxMsg").css($(validar.obj).offset({scroll: false, border: true, padding: true}));
				$(".boxMsg")
					.stop()
					.css({
						opacity: "0.9",
						top: parseInt($(".boxMsg").css("top")) - parseInt($(".boxMsg").height()) - 22,
						left: parseInt($(".boxMsg").css("left")) - 1
					})
					.fadeIn("fast", function(){
						clearTimeout(validar.timeout);
						validar.timeout = setTimeout(function(){ validar.escondeMsg(); },5000);
						posicaoBox();
					})
					.click(validar.escondeMsg);
		},
		
		escondeMsg: function(){
			clearTimeout(validar.timeout);
			if($(".boxMsg").length > 0) $(".boxMsg").fadeOut("fast",function(){ $(".boxMsg").remove(); });
		},
		
		verificaCampos: function(objs){
			validar.valido = true;
			$(objs).filter(".validar").not("[disabled]").each(function(){
				if(validar.valido){
					validar.obj = $(this);
					validar.valor = $(this).val();
					validar.valido = true;
					validar.verifica();
					if(!validar.valido) $(validar.obj).focus();
				}
			});
			return validar.valido;
		},
		
		// Quantidade m�nima de caracteres
		min: function(regra){
			if(validar.valor.length < regra){
				validar.valido = false;
				validar.msg = "deve ser preenchido com no m&iacute;nimo <strong>"+regra+"</strong> caracteres.";
			}
		},
		
		// Quantidade m�xima de caracteres
		max: function(regra){ 
			if(validar.valor.length > regra){
				validar.valido = false;
				validar.msg = "deve ser preenchido com no m&aacute;ximo <strong>"+regra+"</strong> caracteres.";
			}
		},
		
		// Maior que inteiro ou data
		maiorQue: function(regra){
			if(validar.valor != ""){
				if(typeof(regra) == "number"){
					if(validar.valor < regra){
						validar.valido = false;
						validar.msg = "deve ser maior que <strong>"+regra+"</strong>.";
					}
				}else{
					if(regra == "hoje"){
						var hoje = new Date();
						hoje = hoje.getDate() + "/" + (hoje.getMonth() + 1) + "/" + hoje.getFullYear();
						if(dmDate.dateDiff(hoje,validar.valor) < 0){
							validar.valido = false;
							validar.msg = "deve ser maior que <strong>"+hoje+"</strong>.";
						}
					}
				}
			}
		},
		
		// Igual a campo ou string
		igualA: function(regra){
			var valor = regra.indexOf("#") == -1 ? regra : $(regra).val();
			if(validar.valor != valor){
				validar.valido = false;
				validar.msg = "n&atilde;o foi preenchido corretamente.";
			}
		},
		
		// Diferente de campo ou string
		diferenteDe: function(regra){
			var valor = regra.indexOf("#") == -1 ? regra : $(regra).val();
			if(validar.valor == valor){
				validar.valido = false;
				validar.msg = "n&atilde;o foi preenchido corretamente.";
			}
		},
		
		// Defini��es de tipos
		tipo: function(regra){
			switch(regra){
				
				// Num�rico inteiro
				case "inteiro": case "int":
					if(validar.valor != ""){
						var expressao = /^\d+$/;
						if(!expressao.test(validar.valor)){
							validar.valido = false;
							validar.msg = "deve ser preenchido com um <strong>n&uacute;mero inteiro</strong>!";
						}
					}
				break;
				
				// E-mail
				case "email": case "e-mail":
					if(validar.valor != ""){
						var expressao = /^[a-zA-Z0-9]{1}([\._a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+){1,3}$/;
						if(!expressao.test(validar.valor)){
							validar.valido = false;
							validar.msg = "n&atilde;o &eacute; um <strong>e-mail v&aacute;lido</strong>!";
						}
					}
				break;
				
				// Data tipo dd/mm/aaaa
				case "data":
					if(validar.valor != ""){
						var expressao = /^((0?[1-9]|[12]\d)\/(0?[1-9]|1[0-2])|30\/(0?[13-9]|1[0-2])|31\/(0?[13578]|1[02]))\/(19|20)\d{2}$/;
						if(!expressao.test(validar.valor)){
							validar.valido = false;
							validar.msg = "n&atilde;o &eacute; uma data v&aacute;lida, utilize o formato <strong>dd/mm/aaaa</strong>!";
						}
					}
				break;
				
				// Obrigatorio
				case "obrigat�rio": case "obrigatorio":
					if(validar.valor.length == 0){
						validar.valido = false;
						validar.msg = "deve ser preenchido!";
					}
				break;
			}
		},
		
		// Valida��o de tipos
		validacao: function(regra){
			switch(regra){
				
				// CPF
				case "cpf": case "CPF":
					cpf = validar.valor.replace(/[^0-9]/g,"");
					erro = new String;
					if(cpf.length >= 11){
						if(cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999"){
							erro += " &eacute; um n&uacute;mero de CPF inv&aacute;lido!";
						}else{
							var a = [];
							var b = new Number;
							var c = 11;
							for(i=0; i<11; i++){
								a[i] = cpf.charAt(i);
								if(i < 9) b += (a[i] * --c);
							}
							if((x = b % 11) < 2){ a[9] = 0; }else{ a[9] = 11-x; }
							b = 0;
							c = 11;
							for(y=0; y<10; y++) b += (a[y] * c--);
							if((x = b % 11) < 2) { a[10] = 0; }else{ a[10] = 11-x; }
							if((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])) erro += " &eacute; um n&uacute;mero de CPF inv&aacute;lido!";
						}
						if (erro.length > 0){
							validar.msg = erro;
							validar.valido = false;
						}else{
							validar.valido = true;
						}
					}
				break;
				
				//hora
				case "hora":
				    var hora = validar.valor.split(':')[0];
				    var minuto = validar.valor.split(':')[1];
				    
				    if  (hora > 19 || minuto > 59){
				        validar.msg = 'deve ser preenchido entre 10:00 &agrave;s 20:00';
						validar.valido = false;
						
					}else{
						validar.valido = true;
					}
				    
				break;
				
				//Data
				case "data":
					var bissexto = 0;
					var data = validar.valor; 
					var tam = data.length;
					var hoje = new Date()
					hoje = hoje.getDate() + '/' + (hoje.getMonth()+1) + '/' + hoje.getFullYear();
					var dia = data.substr(0,2);
					var mes = data.substr(3,2);
					var ano = data.substr(6,4);
					if (!isNaN(dia)){
						
						validar.valido = false;
						validar.msg = " &eacute; uma data inv&aacute;lida";
						if ((ano > 1900)||(ano < 2100))
						{
								switch (mes) 
								{
										case '01': case '03': case '05': case '07': case '08': case '10': case '12':
											if  (dia <= 31) validar.valido = true;
										break;
										
										case '04': case '06': case '09': case '11':
											if  (dia <= 30) validar.valido = true;
										break;
										
										case '02':
											// Validando ano Bissexto / fevereiro / dia 
											if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) bissexto = 1; 
											if ((bissexto == 1) && (dia <= 29)) validar.valido = true;                             
											if ((bissexto != 1) && (dia <= 28)) validar.valido = true; 
										break;
								}
						}
						
						//if($(validar.obj).hasClass('dataMenor')){
							
							//if( dmDate.dateDiff(data, hoje) <= 0 ){
								//validar.msg = " deve ser menor que a data atual.";
								//validar.valido = false;
							//}
						//}
						//if($(validar.obj).hasClass('dataMaior')){
							
							//if( dmDate.dateDiff(data, hoje) > 0 ){
								//validar.msg = " deve ser maior que a data atual.";
								//validar.valido = false;
							//}
						//}
					}
				break;
			}
		}
	}
	validar.init();
	*/
});