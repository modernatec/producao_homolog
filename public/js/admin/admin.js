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

$(function (){
        $('a.ajax').click(function() {
            var url = this.href;
            // show a spinner or something via css
            var dialog = $('<div style="display:none" class="loading"></div>').appendTo('body');
            // open the dialog
            dialog.dialog({
                // add a close listener to prevent adding multiple divs to the document
                close: function(event, ui) {
                    // remove div with all data and events
                    dialog.remove();
                },
                modal: true
            });
            // load remote content
            dialog.load(
                url, 
                {}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object
                function (responseText, textStatus, XMLHttpRequest) {
                    // remove the loading class
                    dialog.removeClass('loading');
                }
            );
            //prevent the browser to follow the link
            return false;
        });
    });



function rightClick(obj,func)
{
    $(obj).bind("contextmenu", function(e) { e.preventDefault(); if(func){ func(); } });
}

var m_x = 0;
var m_y = 0;

$(function () {
    $("a:contains('Excluir'), a.excluir").click(function() {        
        var NewDialog = $('<div id="MenuDialog">\
            <p>Deseja realmente excluir este conteúdo?</p></div>'),
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

    $('.show').click(function() {
        $('.hide').slideUp();

        var element = $(this).data("show");
        $('#' + element).slideToggle();
    });

    $('.fade').click(function() {
        var element = $(this).data("show");
        $('.' + element).fadeToggle();
    });

    $('.cancel').click(function() {
        var element = $(this).data("show");
        $('#' + element).slideUp();
    });

    $(".collapse").click(function () {
        $header = $(this);
        var element = $header.data("show");
        $('.' + element).fadeToggle(500, function () {
            $header.text(function () {
                return $('.' + element).is(":visible") ? "contrair" : "expandir";
            });
        });
    });

    $('a.popup').click(function() {
        var url = this.href;
        // show a spinner or something via css
        var dialog = $('<div style="display:none" class="loading"></div>').appendTo('body');
        // open the dialog
        dialog.dialog({
            // add a close listener to prevent adding multiple divs to the document
            close: function(event, ui) {
                // remove div with all data and events
                dialog.remove();
            },
            autoOpen: false,
            resizable: false,
            modal: true,
            width: 'auto',

            maxWidth: 600,
            maxHeight: 600,
            //width: $(window).width()-180,
            //height: $(window).height()-180,
        });

        // load remote content
        dialog.load(
            url, 
            {}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object
            function (responseText, textStatus, XMLHttpRequest) {
                // remove the loading class
                dialog.removeClass('loading');
                setTimeout(function(){ 
                    dialog.dialog('open');
                    validaTasks();
                    $(".date").datepicker({dateFormat: 'dd/mm/yy'}).val();
                }, 200);
            }
        );
        
        //prevent the browser to follow the link
        return false;
    });
    

});

function closeFilterPanel(){
    $('.filter ul li').css({'background': ''});
    $('.filter ul li ul').css({'display': 'none'});
}

$(document).ready(function()
{	
    if(msgs.length>0)
    {		
        for(var i=0; i<msgs.length; i++)
        {
            $.jGrowl(msgs[i],{ theme:'aniversariantes', position:'bottom-right',}); 
        } 
    }



    $("#tabs").tabs({
        load: function( event, ui ) {
            $(ui.panel).find(".tab-loading").remove();

            $(".filter span").click(function(e) {
                closeFilterPanel();
                $(this).parent().children('ul').fadeToggle();
                $(this).parent().parent().children('li').css({'background': '#cccccc'})
            });

            $(".cancelar").click(function() { 
                closeFilterPanel();
            });


        },
        select: function (e, ui) {
            var $panel = $(ui.panel);

            if ($panel.is(":empty")) {
                $panel.append("<div class='tab-loading'>Loading...</div>")
            }
        }, 

        activate: function( event, ui ) { 
            $.removeCookie("producao");
            $.cookie("producao", ui.newTab[0].id, { expires : 1 });  
            
        },
    });

    var tab = $.cookie("producao");
    console.log('tab = ' + tab);
    
    $("#tabs").tabs("option", "active", $("#" + tab).index());

    $(".date").datepicker({dateFormat: 'dd/mm/yy'}).val();


});

$.validator.addMethod('date',
    function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        var ok = true;
        try {
            $.datepicker.parseDate('dd/mm/yy', value);
        }
        catch (err) {
            ok = false;
        }
        return ok;
});


/*
    $('.select-popup').change(function() {
        var url = this.value;
        // show a spinner or something via css
        var dialog = $('<div style="display:none" class="loading"></div>').appendTo('body');
        // open the dialog
        dialog.dialog({
            // add a close listener to prevent adding multiple divs to the document
            close: function(event, ui) {
                // remove div with all data and events
                dialog.remove();
            },
            autoOpen: false,
            resizable: false,
            modal: true,
            width: 'auto',

            maxWidth: 600,
            maxHeight: 600,
            //width: $(window).width()-180,
            //height: $(window).height()-180,
            buttons: [
                {text: "OK", click: function() {
                    $('input:checkbox:checked.select').each(function () {
                        $('.select_holder').append(
                            '<li><input type="hidden" name="selected[]" id="'+$(this).attr('value')+'" value="'+$(this).attr('value')+'" />' + $(this).attr('name') + '<a href="#" class="bar_button round">remover</a></li>'
                        );
                                                  
                    });
                     $(this).dialog("close")       
                }},
                {text: "cancelar", click: function() {$(this).dialog("close")}}
            ]

        });

        // load remote content
        dialog.load(
            url, 
            {}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object
            function (responseText, textStatus, XMLHttpRequest) {
                // remove the loading class
                dialog.removeClass('loading');
                setTimeout(function(){ dialog.dialog('open') }, 200);
            }
        );
        
        
        //prevent the browser to follow the link
        return false;
    });
    */

    //aniversariantes();
    //rightClick(window);        
    /*
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
    */

    /*
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
    */

    //$('#nestable3').nestable()
    //.on('change', updateOutput);

    //updateOutput($('#nestable3').data('output', $('#nestable-output')));
    
    
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

/*
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


function temMensagens()
{
    /* é realmente necessário? *    
    setInterval(function()
    {    
        var current_data = $.format.date($.now(), "yyyy-MM-dd H:m:s");
        $.get(base_url + 'tasks/searchnew/?data=' + JSON.stringify(current_data),function(data)
        {  
            /*$(".jGrowl").remove(); 
            data = JSON.parse(data);

            //$.each(data.dados,function(i)
            //{
            
            console.log(data.total);
            if(data.total > 0){
                var msg = 'Existem '+ data.total + ' novas tarefas!';
                $.jGrowl(msg,
                    {
                        position:'bottom-right',
                        sticky: true                       
                    }
                );
            }
            //});
        });
    },300000); //5 min = 300000
    
}

*/    