/*
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
           }*
           $('#'+id).remove();
           $('#filesUploads').val(filesUploads.join(','));
           $('#mimeUploads').val(mimeUploads.join(','));
       }else
       {
           alert(data);
       }
    });
}
*/
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
            var dialog = $('<div style="display:none" id="dialog" class="loading"></div>').appendTo('body');
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
    setupAjax();
});

function closeFilterPanel(){
    $('.filter ul li').css({'background': ''});
    $('.filter ul li ul').css({'display': 'none'});
}

function populateSelect(ui)
{
    var element = ui.target;
    var target = $('#' + element.id).data('target');
    var inId = $('#' + element.id).val();
    var url = $('#' + element.id).data('url');
    
    $('#' + target).html('<option value="">aguarde...</a>');
    $.getJSON(base_url + url + '/' + inId,function(data)
    {
        $('#' + target).html('<option value="">Selecione</a>');
        $.each(data.dados,function(i)
        {
            var dado = data.dados[i];
            $('#' + target).append('<option value="'+dado.id+'">'+dado.display+'</option>');
        });
    });
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

    /*alert para novas tarefas!*/
    old_title = document.title;
    cont_blink = 0;
    if($('#update').length != 0){
        setTimeout(function(){
            alert('existem novas tarefas!');
            clearInterval(blink);
        }, 5000);
        var blink = setInterval(
            function(){
                if(cont_blink %2 == 0){
                    document.title = "existem novas tarefas!";
                }else{
                    document.title = old_title;
                }
                cont_blink++;

            }, 500
        );
    }
    

    /*ativa a última aba selecionada*/
    //var tab = $.cookie("producao");
    //console.log('tab = ' + tab);
    
    //$("#tabs").tabs("option", "active", $("#" + tab).index());

    $(".date").datepicker({dateFormat: 'dd/mm/yy'}).val();

    //$('#head').css({height:$( window ).height()});

    

    
    //$('.list_body').css({height:$( window ).height()- $('.list_body').offset().top});

    //loadContent($(this).attr("href"), $(this).data("panel"));
    //window.location.hash = $(this).attr("href").replace(base_url + 'admin/', '').replace('/index/ajax', '');
    if(window.location.hash != ""){
        id = window.location.hash.replace('#', '');
        loadContent(base_url + '/admin/' + id + '/index/ajax' , '#content');
        $('#' + id).addClass('selected');
    }

    if($('#login').length != 0){
        $('#login').css({
            "margin-top": ($(window).height() / 2),
            "margin-left": ($(window).width() / 2) - ($('#login').css('width').replace('px', '') / 2) - 130,
        }); 
    }

    
    //setupAjax('#content');
});


function setupScroll(){
    $(".scrollable_content, #esquerda, #direita").mCustomScrollbar({
        theme:"dark-3",
        axis:"y"
    });
}


function setupAjax(container){   
    if($('#direita').length != 0){
        //$('#esquerda, #direita').css({width: ($(window).width() / 2) - (($('#esquerda').offset().left / 2) + 10)}); 
        //$('#esquerda, #direita').css({height:$(window).height() - ($('#esquerda').offset().top + 5)});
    }

    //$('.list_body').css('padding-top', $('.list_header').height() + 20);

    if($(container + ' .scrollable_content').length != 0){
        console.log($(container + ' .scrollable_content').offset().top, $( window ).height())
        $(container + ' .scrollable_content').css({height:$( window ).height() - $(container + ' .scrollable_content').offset().top - 5});
    }

    validateAjax(); 

    $(container + " .scrollable_content").mCustomScrollbar("update");

    setupScroll();

    $(".populate").change(function(ui) {
        populateSelect(ui);
    });

    $(".fone").mask("(99) 9999-9999");

    

    $(".filter span").unbind('click').bind("click", function(e) {
        if($(this).parent().children('ul').css('display') == 'none'){
            closeFilterPanel();
        }
        $(this).parent().children('ul').fadeToggle(function(){
            if($(this).parent().children('ul').css('display') == 'none'){
                $(this).parent().parent().children('li').css({'background': ''});
            }
        });

        $(this).parent().parent().children('li').css({'background': '#cccccc'});
        
    });

    $(".cancelar").unbind('click').bind('click', function() { 
        closeFilterPanel();
    });


    $("#sortable").sortable({
        placeholder: "ui-state-highlight",
        distance: 70,
        axis: 'y',
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: base_url + '/tasks/reorder'
            });
        }
    });

    $("#sortable").disableSelection();

    $("a[rel='load-content']").unbind('click').bind('click', function(e){
        e.preventDefault();
        $('#direita').fadeOut();
        loadContent($(this).attr("href"), $(this).data("panel"));
        console.log($(this).data("refresh") );

        if($(this).hasClass('menu')){
            $('#menu li a').removeClass('selected');
            $(this).addClass('selected');
        }

        if($(this).hasClass('load')){
            $('.list_item li a').removeClass('selected');
            $(this).addClass('selected');
        }    

        if($(this).data("refresh") != undefined){
            window.location.hash = $(this).attr("href").replace(base_url + 'admin/', '').replace('/index/ajax', '');
        }
    });

    $(".collapse").unbind('click').bind('click', function () {
        $header = $(this);
        var element = $header.data("show");
        $('.' + element).fadeToggle(500, function () {
            $header.text(function () {
                return $('.' + element).is(":visible") ? "contrair" : "expandir";
            });
        });
    });

    $('.show').unbind('click').bind('click', function() {
        $('.hide').slideUp();

        var element = $(this).data("show");
        $('#' + element).slideToggle();


    });

    $('.fade').unbind('click').bind('click', function() {
        var element = $(this).data("show");
        $('.' + element).fadeToggle();
    });

    $('.cancel').unbind('click').bind('click', function() {
        var element = $(this).data("show");
        $('#' + element).slideUp();
    });

    $("a:contains('Excluir'), a.excluir").unbind('click').bind('click', function() {        
        var NewDialog = $('<div id="dialog"><p>Deseja realmente excluir este conteúdo?</p></div>'),
            btExcluir = this;
            NewDialog.dialog({
            modal: true,
            title: "Excluir",
            show: 'clip',
            hide: 'clip',
            resizable:false,
            buttons: [
                {text: "OK", click: function() {
                    $.ajax({
                        type: "POST",
                        url: $(btExcluir).attr('href'),
                        dataType : "json",
                        //data: $(form).serialize(),
                        success: function(data) {
                            setDataPanels(data);
                        },
                        error: function(e) {
                            console.log(e);
                            alert("ocorreu um erro.");
                        }
                    });    
                }},
                {text: "Cancelar", click: function() {$(this).dialog("close")}}
            ]
        });
        return false;
    });

    $('a.popup').unbind('click').bind('click', function() {
        var url = this.href;
        // show a spinner or something via css
        var dialog = $('<div style="display:none" id="dialog" class="loading"></div>').appendTo('body');
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
                    validateAjax();
                    
                }, 200);
            }
        );
        
        //prevent the browser to follow the link
        return false;
    });


    $('.tabs a').unbind('click').bind('click', function(e){
        e.preventDefault();
        link = $(this).attr('href');
        if(link != lastURL){
            $('.tabs li').removeClass('selected');
            $('.content_hide').each(function(index, element){            
                if($(this).hasClass('content_show')){
                    $(this).removeClass('content_show');
                }
            });            

            if($(this).hasClass('ajax')){
                loadContent(link, '#tabs_content');
                
                if($(this).attr('data-clear')){
                    
                    $($(this).attr('data-clear')).html(" ");
                }
                

            }else{
                $($(this).attr('href')).addClass('content_show');
            }

            $.removeCookie("producao");
            $.cookie("producao", '#' + $(this).attr('id'), { expires : 1 });
            $(this).parent().addClass('selected');
        }
    })
    
    var tab = $.cookie("producao");
    
    setTimeout(function(){
        if($(container + ' ' + tab).length > 0){
            $(container + ' ' + tab).click(); 
        }else{
            $(container + ' #tab_1').click(); 
        }
    }, 100);    
}


function ajaxPost(form){
    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: $(form).serialize(),
        timeout: 10000,
        dataType : "json",
        success: function(data) {
            setDataPanels(data);
            $('input[type=submit]').prop("disabled", '' );
        },
        error: function(e) {
            console.log(e);
            alert("ocorreu um erro.");
        }
    });    
}

function ajaxReload(form){    
    //console.log('chamou reload')
    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: $(form).serialize(),
        timeout: 10000, 
        success: function(retorno) {
            reloadContent(retorno, $(form).data('panel'));
            $('input[type=submit]').prop("disabled", '' );
        },
        error: function(e) {
            console.log(e);
            alert("ocorreu um erro.");
        }
    });    
}

lastURL = "";

function loadContent(url, container){
    console.log('loadContent = ' + url);
    lastURL = url;
    $(container).html("<div class='loading'>loading...</div>"); 
    $('#dialog, ui-dialog').remove();

    if($(container + " .mCSB_container").length > 0){
        holder = container + " .mCSB_container";
    }else{
        holder = container;
    }

    $(holder).load(url, function() {
        $(holder).hide().fadeIn(500, function(){
            //console.log("terminou -> " + $(container).attr('id'));
            setupAjax(container);  


        });      
    });
}


function setDataPanels(data){
    console.log(data);
    
    if(data.content){
        console.log("content *********")
        loadContent(data.content, '#content');
    }else{
        if(data.esquerda){
            loadContent(data.esquerda, '#esquerda');
        }else{
            //$('#esquerda').fadeOut();
        }
        
        if(data.direita){
            loadContent(data.direita, '#direita');
        }else{
            //$('#direita').fadeOut();
        }

        if(data.tabs_content){
            loadContent(data.tabs_content, '#tabs_content');
        }else{
            //$('#direita').fadeOut();
        }
    }

    if(data.msg){
        $.jGrowl(data.msg,{ theme:'aniversariantes', position:'top-right',});
    } 
}

function reloadContent(data, container){
    $(container).html("<div class='loading'>loading...</div>"); 
    $('#dialog, ui-dialog').remove();

    if($(container + " .mCSB_container").length > 0){
        holder = container + " .mCSB_container";
    }else{
        holder = container;
    }

    
    $(holder).hide(400, function(){
        $(holder).html( data );
    }).fadeIn(500, function(){
        setupAjax(container);   
    });  

    /*
    $(container).fadeOut(function(){
        $(container + " .mCSB_container").html( data );
        $(container).slideDown(function(){
            setupAjax();
        });         
    });
    */    
}






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


