function temMensagens(){
    setInterval(function(){    
        $.get('/admin/tasks/searchnew/',function(data){  
            $(".jGrowl").remove();
            data = JSON.parse(data);    
            $.each(data.dados,function(i){
                var dado = data.dados[i];
                var msg = 'Existem tarefas para você:<br/><br/><a href="/admin/tasks/edit/'+dado.id+'">Tarefa <b>"'+dado.title+'"</b> &raquo;</a>';
                $.jGrowl(msg,{position:'bottom-right',sticky: true});                
            });
        });
    },300000); //5 min = 300000
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
        temMensagens();
});