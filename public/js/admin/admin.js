function temMensagens(){
    setInterval(function(){    
        $.get('/admin/tasks/searchnew/',function(data){  
            /*$(".jGrowl").remove(); é realmente necessário? */
            data = JSON.parse(data);    
            $.each(data.dados,function(i){
                var dado = data.dados[i];
                var msg = 'Existem tarefas para você:<br/><br/><a href="/admin/tasks/edit/'+dado.id+'">Tarefa <b>"'+dado.title+'"</b> &raquo;</a>';
                $.jGrowl(msg,
                    {
                        position:'bottom-right',
                        sticky: true                       
                    }
                );
            });
        });
    },300000); //5 min = 300000
}

function aniversariantes(){
    $.get('/admin/users/aniversariantes/',function(data){  
        data = JSON.parse(data);    
        $.each(data.dados,function(i){
            var dado = data.dados[i];
            var msg = 'Hoje <b>'+dado.nome+'</b> faz aniversário!!<br/><br/>Dê os parabéns!!!</a>';
            $.jGrowl(msg,
                {
                    theme:'aniversariantes',
                    position:'bottom-left',
                    sticky:true                       
                }
            );
        });
    });
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

function filtraTasks(){
    var status = ($('#status').val())?($('#status').val()):'';
    var task_to = ($('#task_to').val())?($('#task_to').val()):'';
    window.location = '/admin/tasks/filter/?status='+status+'&task_to='+task_to;
}

function getUsersByEquipe(inId){
    $('#task_to').html('<option value="">aguarde...</a>');
    setTimeout(function(){
        $.get('/admin/users/equipe/'+inId,function(data){
            data = JSON.parse(data);
            $('#task_to').html('<option value="">Selecione</a>');
            $.each(data.dados,function(i){
                var dado = data.dados[i];
                $('#task_to').append('<option value="'+dado.id+'">'+dado.nome+'</a>');
            });
        });
    },500);
}

var popup = false;
function openPop(pagina){
    pagina = (pagina.indexOf('?')!=-1)?pagina+"&nocache="+Math.random():pagina+"?nocache="+Math.random();
    if(!popup){
        $.post(pagina, function(data){
            popup = new Popup({
                bt_close:'#btFechar',
                mask:true,
                maskColor:'#000',
                Fixed:false,
                zIndex:90,
                posRelScroll:true,//posicao relacionada ao Scroll 
                closeToEsc:true,
                fade:true
            });
            popup.open(data);
            popup.onClose = function(){
                popup = false;
            }
        });	
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
        temMensagens();
        aniversariantes();
});