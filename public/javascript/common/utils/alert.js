/**/
function pintaFundo(type){
	  var yourShade = document.getElementById('fundo');
	
	  var d = detectMacXFF();
	  if (d) {
		yourShade.style.backgroundImage= "url(images/imagAlert.png)";
		yourShade.style.backgroundRepeat="repeat";
	  } else {
		yourShade.style.backgroundColor = "#FFF";
		yourShade.style.MozOpacity = .90;
		yourShade.style.opacity = .90;
		yourShade.style.filter = "alpha(opacity=90)";
	  }
	  yourShade.style.height = arrayPageSize[1]+"px";
	  yourShade.style.display = '';
	  if(type == 'confirm'){
		var ok = document.getElementById('alertOk');
		var cancel = document.getElementById('alertCancel');
		ok.style.display 		= '';
		cancel.style.display 	= '';
	  }
}
function detectMacXFF() {
	var userAgent = navigator.userAgent.toLowerCase();
	if (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) {
		return true;
	}
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

time = 0;
function showAlert(type){
	getPageSize();
	pintaFundo(type);
	if(type != "confirm")
		time = setInterval(ocultaAlert, 3000);
}

function ocultaAlert(){
	var _fundo = document.getElementById('fundo');
	var _alert = document.getElementById('flashAlert');
	_fundo.style.display = 'none';
	_alert.style.display = 'none';
	clearInterval(time);
}

function Confirm(area){
	ocultaAlert();
	if(area)
		window.location = area;
}