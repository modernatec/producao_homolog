function initLayOut(LT,RT,LB,RB,Color){
	
	var so = new SWFObject("./common/swf/common/curva.swf", "Borda", "5", "5", "7", "#"+Color);
	so.addParam("allowScriptAccess", "always");
	so.addParam("wmode", "transparent");
	so.addVariable("cor", Color);

	so.write(LT);
	so.addVariable("rotacao", "90");
	so.write(RT);

	var so = new SWFObject("./common/swf/common/curva.swf", "Borda", "5", "5", "7", "#"+Color);
	so.addParam("allowScriptAccess", "always");
	so.addParam("wmode", "transparent");
	so.addVariable("cor", Color);
	
	so.addVariable("rotacao", "270");
	so.write(LB);

	var so = new SWFObject("./common/swf/common/curva.swf", "Borda", "5", "5", "7", "#"+Color);
	so.addParam("allowScriptAccess", "always");
	so.addParam("wmode", "transparent");
	so.addVariable("cor", Color);
	
	so.addVariable("rotacao", "180");
	so.write(RB);
}


function initTopo(){
	initLayOut("topoTL","topoTR","topoBL","topoBR","FFFFFF");
}
function initMenu(){
	initLayOut("menuTL","menuTR","menuBL","menuBR","FFFFFF");
}
function initLogin(){
	initLayOut("loginTL","loginTR","loginBL","loginBR","FFFFFF");
}
function initLoginCadastro(){
	initLayOut("cadastroTL","cadastroTR","cadastroBL","cadastroBR","FFFFFF");
}
function initSite(color){
	initLayOut("siteTL","siteTR","siteBL","siteBR",color);
}
function initConteudo(){
	initLayOut("conteudoTL","conteudoTR","conteudoBL","conteudoBR","FFFFFF");
}
function initRodape(){
	initLayOut("rodapeTL","rodapeTR","rodapeBL","rodapeBR","FFFFFF");
}