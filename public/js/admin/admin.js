function temMensagens(){
    setInterval(function(){
        $.getJSON('/admin/tasks/searchNew/',function(data){
            var mss = data.mss;
            if(mss.length>0)
            {		
                for(var i=0; i<mss.length; i++)
                {
                    $.jGrowl(mss[i],{position:'bottom-right'}); 
                } 
            }
        });
    },1000); //5 min (1000 * 60 * 5)
}

function excluirTemporario(id){
    var filePath = $('#'+id).attr('filePath');
    //var mimeType = $('#'+id).attr('mimeType');
    $.get('/admin/pluploader/delete/'+filePath,function(data){
       if(data=='OK'){           
           for(var i=0; i < filesUploads.length; i++){
               if(filePath == filesUploads[i]){
                   filesUploads[i] = 'empty';
                   mimeUploads[i] = 'empty';
               }
           }                     
           /*for(var i=0; i < mimeUploads.length; i++){
               if(mimeType == mimeUploads[i]){
                   mimeUploads[i] = 'empty';
               }
           }*/
           $('#'+id).remove();
           $('#filesUploads').val(filesUploads.join(','));
           $('#mimeUploads').val(mimeUploads.join(','));
       }else{
           alert(data);
       }
    });
}

function sldBox(obj){
    var dsp = $(obj).css('display');
    if(dsp == 'none'){
        $(obj).slideDown('slow');
    }else{
        $(obj).slideUp('slow');
    }
}

$(document).ready(function() {	
	if(msgs.length>0)
	{		
		for(var i=0; i<msgs.length; i++)
		{
			$.jGrowl(msgs[i],{position:'bottom-right'}); 
		} 
	}
        $( "#crono_date" ).datepicker({ 
            dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            dayNamesMin: ["Do", "Sg", "Te", "Qa", "Qi", "Sx", "Sa"],
            dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            monthNamesShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
            nextText:'Próx.',
            prevText:'Ant.',
            dateFormat: "dd/mm/yy"
        });
});

