function temMensagens()
{
    setInterval(function()
    {    
        $.get('/admin/tasks/searchnew/',function(data)
        {  
            /*$(".jGrowl").remove(); é realmente necessário? */
            data = JSON.parse(data);    
            $.each(data.dados,function(i)
            {
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

function aniversariantes()
{
    $.get('/admin/users/aniversariantes/',function(data)
    {  
        data = JSON.parse(data);    
        $.each(data.dados,function(i)
        {
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

function excluirTemporario(id)
{
    var filePath = $('#'+id).attr('filePath');
    //var mimeType = $('#'+id).attr('mimeType');
    $.get('/admin/pluploader/delete/'+filePath,function(data)
    {
       if(data=='OK')
       {           
           for(var i=0; i < filesUploads.length; i++)
           {
               if(filePath == filesUploads[i]){
                   filesUploads[i] = 'empty';
                   mimeUploads[i] = 'empty';
               }
           }                     
           /*for(var i=0; i < mimeUploads.length; i++)
           {
               if(mimeType == mimeUploads[i]){
                   mimeUploads[i] = 'empty';
               }
           }*/
           $('#'+id).remove();
           $('#filesUploads').val(filesUploads.join(','));
           $('#mimeUploads').val(mimeUploads.join(','));
       }else
       {
           alert(data);
       }
    });
}

function sldBox(obj){
    var dsp = $(obj).css('display');
    if(dsp == 'none')
    {
        $(obj).slideDown('slow');
    }else
    {
        $(obj).slideUp('slow');
    }
}

function filtraTasks()
{
    var status = ($('#status').val())?($('#status').val()):'';
    var task_to = ($('#task_to').val())?($('#task_to').val()):'';
    window.location = '/admin/tasks/filter/?status='+status+'&task_to='+task_to;
}

function getUsersByEquipe(inId)
{
    $('#task_to').html('<option value="">aguarde...</a>');
    setTimeout(function()
    {
        $.get('/admin/users/equipe/'+inId,function(data)
        {
            data = JSON.parse(data);
            $('#task_to').html('<option value="">Selecione</a>');
            $.each(data.dados,function(i)
            {
                var dado = data.dados[i];
                $('#task_to').append('<option value="'+dado.id+'">'+dado.nome+'</a>');
            });
        });
    },500);
}

var popup = false;
function openPop(pagina)
{
    pagina = (pagina.indexOf('?')!=-1)?pagina+"&nocache="+Math.random():pagina+"?nocache="+Math.random();
    if(!popup)
    {
        $.post(pagina, function(data)
        {
            popup = new Popup(
            {
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
            popup.onClose = function()
            {
                popup = false;
            }
        });	
    }
}


var dhtml = false;
function openDhtml(html)
{    
    dhtml = new Popup(
    {
        bt_close:'#btOk',
        mask:false,
        Fixed:false,
        zIndex:95,
        posRelScroll:true,//posicao relacionada ao Scroll 
        closeToEsc:true,
        fade:true
    });
    dhtml.open(html);
    dhtml.onClose = function()
    {
        dhtml = false;
    }    
}

function rightClick(obj,func)
{
    $(obj).bind("contextmenu", function(e) { e.preventDefault(); if(func){ func(); } });
}

function alterarTag()
{
    var old_tag = $('#old_tag').val();
    var new_tag = $('#new_tag').val();
    if(new_tag != old_tag)
    {
        $.get('/admin/medias/alterartag/'+old_tag+'@@@'+new_tag,function(data)
        {
            $.jGrowl('Tag alterada!',
                {
                    position:'bottom-right',
                    sticky: true,
                    close:function(e,m,o)
                    {
                        window.location.reload();
                    }
                }
            );            
        });
    }else
    {
        alert('As tags são idênticas, nada foi alterado!');
    }
}

$(document).ready(function()
{	
    if(msgs.length>0)
    {		
        for(var i=0; i<msgs.length; i++)
        {
            $.jGrowl(msgs[i],{position:'bottom-right'}); 
        } 
    }
    temMensagens();
    aniversariantes();
    rightClick(window);        
    $('[rightClick="true"]').each(function()
    {
        if($(this).attr('class') == 'tags')
        {
            var tag = $(this).html();
            rightClick('#'+$(this).attr('id'),function()
            {
                var html ='<div class="dhtml">'+
                    '<label for="new_tag">Tag</label>'+
                    '<input type="hidden" class="text round" name="old_tag" id="old_tag" value="'+tag+'" />'+
                    '<input type="text" class="text round" name="new_tag" id="new_tag" value="'+tag+'" />'+
                    '<a href="javascript:alterarTag();" class="bar_button round">Salvar</a>'+
                    '<a href="javascript:;" class="bar_button round" id="btOk">Cancelar</a>'+
                '</div>'; 
                openDhtml(html);
            });
        }
    });
});