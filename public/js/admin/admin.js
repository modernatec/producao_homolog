function temMensagens()
{
    setInterval(function()
    {    
        $.get(base_url + 'tasks/searchnew/',function(data)
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
    $.get(base_url + 'users/aniversariantes/',function(data)
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
    $.get(base_url + 'pluploader/delete/'+filePath,function(data)
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


function checkUpload(form){
	console.log("chamou " + form);
	
	if($('.delFiles').size() > 0){
		if(filesUploads.length <= 0){
			uploader.start();
		}else{
			form.submit();
		}
	}else{
		form.submit();
	}
		
}


function filtraTasks()
{
    var status = ($('#status').val())?($('#status').val()):'';
    var task_to = ($('#task_to').val())?($('#task_to').val()):'';
    window.location = 'tasks/filter/?status='+status+'&task_to='+task_to;
}

function getUsersByEquipe(inId)
{
    $('#task_to').html('<option value="">aguarde...</a>');
    setTimeout(function()
    {
        $.get(base_url + 'admin/users/equipe/'+inId,function(data)
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

function getCollectionByProject(inId)
{
    $('#collection_id').html('<option value="">aguarde...</a>');
    setTimeout(function()
    {
        $.get(base_url + 'admin/projects/collections/'+inId,function(data)
        {
            data = JSON.parse(data);
            $('#collection_id').html('<option value="">Selecione</a>');
            $.each(data.dados,function(i)
            {
                var dado = data.dados[i];
                $('#collection_id').append('<option value="'+dado.id+'">'+dado.name+'</a>');
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
        Top: m_y,
        Left:m_x,
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
        $.get(base_url + '/admin/medias/alterartag/'+old_tag+'@@@'+new_tag,function(data)
        {
            dhtml.close();
            var msg = '';
            if(data=='ERR'){
                msg = 'Tag alterada!';
            }else if(data=='DENIED'){
                msg = 'Você não tem permissão para executar esta ação!';
            }else{
                msg = 'Houve um erro ao alterar a tag, dados não alterados!';                
            }
            $.jGrowl(msg,
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

function addTag(cmp,iptHidden)
{
    var id = cmp.options[cmp.selectedIndex].value,
        txt = cmp.options[cmp.selectedIndex].text;
    if($('#tag_'+id).length <= 0)
    {
        $('.tags').append('<div id="tag_'+id+'"> <b>'+txt+'</b> <a href="javascript:;" onclick="serializeTag('+iptHidden+')">X</a> </div>');
        serializeTag(iptHidden);
        cmp.selectedIndex = 0;
    }
    else
    {
        $.jGrowl('Conteúdo já adicionado!',{ position:'bottom-right', sticky: true } );
    }    
}
function removeTag(id,iptHidden)
{
    $('#tag_'+id).remove();
    serializeTag(iptHidden);
}
function serializeTag(iptHidden)
{
    var strIptHidden = '';
    $('.tags div').each(
        function(idx,elem)
        {
            var _id = $(elem).attr('id').replace('tag_','');
            strIptHidden += ','+_id;
        }
    );
    $('#'+iptHidden).val(strIptHidden.substr(1)).attr('class','');
    $('[for='+iptHidden+'].error').remove();
}

var m_x = 0;
var m_y = 0;

$(function () {
    $("a:contains('Excluir')").click(function() {        
        var NewDialog = $('<div id="MenuDialog">\
            <p>Deseja realmente excluir este conteúdo?</p>\
        </div>'),
            btExcluir = this;
        NewDialog.dialog({
            modal: true,
            title: "Excluir",
            show: 'clip',
            hide: 'clip',
            resizable:false,
            buttons: [
                {text: "OK", click: function() {
                    window.location.href = $(btExcluir).attr('href');	
                }},
                {text: "Cancelar", click: function() {$(this).dialog("close")}}
            ]
        });
        return false;
    });
});

$(document).ready(function()
{	
    if(msgs.length>0)
    {		
        for(var i=0; i<msgs.length; i++)
        {
            $.jGrowl(msgs[i],{ theme:'aniversariantes', position:'bottom-right',}); 
        } 
    }
	
    temMensagens();

    //aniversariantes();
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
    
     $(document).mousemove(function(e){
         m_x = e.pageX;
         m_y = e.pageY;
    });


    
     var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');

            //alert(list.data);
        
        if (window.JSON) {           
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };


    $('#nestable3').nestable()
    .on('change', updateOutput);

    updateOutput($('#nestable3').data('output', $('#nestable-output')));
    
    
    /*
    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    })
   // .on('change', updateOutput);
    
    // activate Nestable for list 2
    $('#nestable2').nestable({
        group: 1
    })
   // .on('change', updateOutput);

    // output initial serialised data
   // updateOutput($('#nestable').data('output', $('#nestable-output')));
   // updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
    */
});

function pop_load_pais(){
    $.get(base_url + '/producao/admin/objects/popload',function(data){
        data = JSON.parse(data); 
        $('#pop_pais').html('<option value="">Selecione</option>');
        $.each(data.dados,function(i)
        {
            var dado = data.dados[i];
            $('#pop_pais').append('<option value="'+dado.id+'">'+dado.title+'</option>');            
        });
    })
}

function pop_load_colecao(){
    var pop_pais = $('#pop_pais').val();
    $.get(base_url + '/producao/admin/objects/popload/?country_id='+pop_pais,function(data){
        data = JSON.parse(data); 
        $('#pop_colecao').html('<option value="">Selecione</option>');
        $.each(data.dados,function(i)
        {
            var dado = data.dados[i];
            $('#pop_colecao').append('<option value="'+dado.id+'">'+dado.title+'</option>');            
        });
    });
}

function pop_load_ano(){
    var pop_pais = $('#pop_pais').val(),
        pop_colecao = $('#pop_colecao').val();
    $.get(base_url + '/producao/admin/objects/popload/?country_id='+pop_pais+'&colecao='+pop_colecao,function(data){
        data = JSON.parse(data); 
        $('#pop_ano').html('<option value="">Selecione</option>');
        $.each(data.dados,function(i)
        {
            var dado = data.dados[i];
            $('#pop_ano').append('<option value="'+dado.id+'">'+dado.title+'</option>');            
        });
    })
}

function pop_load_objeto(){
    var pop_pais = $('#pop_pais').val(),
        pop_colecao = $('#pop_colecao').val(),
        pop_ano = $('#pop_ano').val();
    $.get(base_url + '/producao/admin/objects/popload/?country_id='+pop_pais+'&colecao='+pop_colecao+'&ano='+pop_ano,function(data){
        data = JSON.parse(data); 
        $('#pop_objeto').html('<option value="">Selecione</option>');
        $.each(data.dados,function(i)
        {
            var dado = data.dados[i];
            $('#pop_objeto').append('<option value="'+dado.id+'">'+dado.title+'</option>');            
        });
    })
}

var n = 0
function add_ProjectSteps(item_number){
    $("#nestable3 >ol").append("<li class='steps' >Passo <input class='round' type='text' name='passo[]' /> Tempo <input class='round' style='width:20px;' type='text' name='tempo[]' /> dia(s)<input type='hidden' name='id_step[]' value='0'/></li>");
    n = n + 1;
}

