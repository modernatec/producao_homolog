$(document).ready( 
	function() {
		$("body").contextMenu({
			menu: 'myMenu'
		});
	}
);

function attachSwf(local, swf, color, w, h, v){
	var so = new SWFObject(swf, local, w, h, "8", "#"+color);
	so.addParam("allowScriptAccess", "always");
	if (v)
		so.addParam("wmode", "transparent");
	so.write(local);
}

function action(indice, title, message, area){
	switch (indice){
		case "alert":
			$.prompt(
				message,
				{
					callback:myfunction,
					buttons: { 'OK': true}
				},
				title,
				action
			);
		break;
		case "confirm":
			$.prompt(
				message,
				{
					callback:myfunction,
					buttons: { 'OK': true, 'CANCELAR': false }
				},
				title,
				area
			);
		break;
		case "information":
			$.prompt(
				message,
				{
					callback:myfunction,
				},
				title,
				area
			);
		break;
		case "location":
			window.location = area;
		break
		case "back":
			window.back(-1);
		break;
		case "close":
			$.prompt.close();
		break;
	}
}

function myfunction(v,m, f, c){
	/*if(v){
		alert(v+" - "+m+" - "+f+" - "+c)
	}
    //$.prompt(v +' ' + f.alertName);*/
	if(v) action("location", null, null, c);
}

function getPageSize(){
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}

	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){	
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}

	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) 
	return arrayPageSize;
}	
function showAlert(){
	getPageSize();
	pintaFundo();
}


function initLayOut()
{
  justAll = {
	  tl: { radius: 5 },
	  tr: { radius: 5 },
	  bl: { radius: 5 },
	  br: { radius: 5 },
	  antiAlias: true,
	  autoPad: true,
	  validTags: ["div", "ul"]
  }
  
  justTop = {
	  tl: { radius: 5 },
	  tr: { radius: 5 },
	  bl: { radius: 0 },
	  br: { radius: 0 },
	  antiAlias: true,
	  autoPad: true,
	  validTags: ["div", "ul"]
  }
  
  justBottom = {
	  tl: { radius: 0 },
	  tr: { radius: 0 },
	  bl: { radius: 5 },
	  br: { radius: 5 },
	  antiAlias: true,
	  autoPad: true,
	  validTags: ["div", "ul"]
  }
}// JavaScript Document

function extraiScript(texto){
        var ini, pos_src, fim, codigo;
        var objScript = null;
        ini = texto.indexOf('<script', 0)
        while (ini!=-1){
                var objScript = document.createElement("script");
                //Busca se tem algum src a partir do inicio do script
                pos_src = texto.indexOf(' src', ini)
                ini = texto.indexOf('>', ini) + 1;
                //Verifica se este e um bloco de script ou include para um arquivo de scripts
                if (pos_src < ini && pos_src >=0){//Se encontrou um "src" dentro da tag script, esta e um include de um arquivo script
                        //Marca como sendo o inicio do nome do arquivo para depois do src
                        ini = pos_src + 4;
                        //Procura pelo ponto do nome da extencao do arquivo e marca para depois dele
                        fim = texto.indexOf('.', ini)+4;
                        //Pega o nome do arquivo
                        codigo = texto.substring(ini,fim);
                        //Elimina do nome do arquivo os caracteres que possam ter sido pegos por engano
                        codigo = codigo.replace("=","").replace(" ","").replace("\"","").replace("\"","").replace("\'","").replace("\'","").replace(">","");
                        // Adiciona o arquivo de script ao objeto que sera adicionado ao documento
                        objScript.src = codigo;
                }else{//Se nao encontrou um "src" dentro da tag script, esta e um bloco de codigo script
                        // Procura o final do script
                        fim = texto.indexOf('</script>', ini);
                        // Extrai apenas o script
                        codigo = texto.substring(ini,fim);
                        // Adiciona o bloco de script ao objeto que sera adicionado ao documento
                        objScript.text = codigo;
                }
                //Adiciona o script ao documento
                document.body.appendChild(objScript);
                // Procura a proxima tag de <script
                ini = texto.indexOf('<script', fim);
                //Limpa o objeto de script
                objScript = null;
        }
}
function redirect(area){
	window.location = area;
}
function viewPreloaer()
{
	$('div#main').append("<div id='preloader'><div id='preloaderImage'></div></div>");
}
function hiddenPreloaer()
{
	$("#preloader").remove(); 
}

function excluir(area) {
	//if (confirm("Tem certeza que deseja excluir?")) {
		//redirect(area);
	//}
//	action("alert", "Alerta Exclução", "Você realmente deseja apagar este arquivo?");
	action("confirm", "Alerta Exclu&ccedil;&atilde;o", "Voc&ecirc; realmente deseja apagar este arquivo?", area);
}

function show(element)
{
	$("#"+element+":hidden").show("fast");	
}

function limitChars(texto, limite, info){
	var text = $('#'+texto).val();
	var textlength = text.length;
	if(textlength > limite)
	{
		var txt = $('#'+texto).val().substring(0, limite)
        $('#'+texto).val(txt)
		return false;
	}
	else
	{
		$('#' + info).html('Você ainda pode escrever mais '+ (limite - textlength) +' caracteres');
		return true;
	}
}
function help(){
	$("a.closeHelp").slideToggle("slow");
}

