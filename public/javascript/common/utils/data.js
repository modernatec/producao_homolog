function data(){
	var mydate=new Date()
	var year=mydate.getYear()
	if (year < 1000)year+=1900
	var day=mydate.getDay()
	var month=mydate.getMonth()
	var daym=mydate.getDate()
	if (daym<10)daym="0"+daym
	var dayarray=new Array("Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sábado")
	var montharray=new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
	document.write(dayarray[day]+",<br />"+daym+" de "+montharray[month]+" de "+year);
	return true;
}
	
