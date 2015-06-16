function checkUpload(form){
	
	if($('.delFiles').size() > 0){
		if(filesUploads.length <= 0){
			uploader.start();
		}else{
			ajaxPost(form);
            //form.submit();
		}
	}else{
		//form.submit();
        ajaxPost(form);
	}
		
}

function rightClick(obj,func)
{
    $(obj).bind("contextmenu", function(e) { e.preventDefault(); if(func){ func(); } });
}

var m_x = 0;
var m_y = 0;

/*
$(function () {
    setupAjax();
});
*/

function closeFilterPanel(){
    $('.filter ul li').css({'background': ''});
    $('.filter_panel').css({'display': 'none'});
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


var googleLoaded = false;

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
    
    if(window.location.hash != ""){
        var hash_url = window.location.hash.substring(1);
        var url = hash_url.substr(0,hash_url.length)
        
        if(window.location.href.indexOf('login') == -1){
            loadContent({url:base_url + 'admin/' + url , container:'#content'});
            $('a[href="'+url+'"]').addClass('selected');
        }
    }

    if($('#login').length != 0){
        $('#login').css({
            "margin-top": ($(window).height() / 2),
            "margin-left": ($(window).width() / 2) - ($('#login').css('width').replace('px', '') / 2) - 130,
        }); 
    }

    //updateBar();
});

setInterval(function() {
    updateBar();
}, 10000);

function setupScroll(){
    $(".scrollable_content").mCustomScrollbar({
        theme:"dark-3",
        axis:"y",
        scrollInertia: 0,
        
        advanced:{
            autoScrollOnFocus: false,
            updateOnContentResize: true,
            updateOnBrowserResize:true,
        },
    });

    $(".scrollable_x").mCustomScrollbar({
        theme:"dark-3",
        axis:"x",
        scrollInertia: 0,
        
        advanced:{
            autoScrollOnFocus: false,
            updateOnContentResize: true,
            updateOnBrowserResize:true,
        },
    });
}



function setupChartData(data){
    for(k in data){
        data[k] = $.parseJSON(data[k]);
        for(i in data[k]){
            if(isNaN(data[k][i]) == false){
                data[k][i] = parseInt(data[k][i]);
            };
        }
    }

    return data;
}

var chartContainer = [];
var drawCharts = function drawChart() {
    if(chartContainer[0]){
        var array = setupChartData($('#'+chartContainer[0]).data('chart'));
        var data = google.visualization.arrayToDataTable(array);
        
        var options = {
          title: $('#'+chartContainer[0]).data('title'),
          pieHole: 0.5,
          chartArea:{left:0,top:30,width:'80%',height:'80%'},
          'width':450,
          'height':260,
          legend: {position: 'right'},
          
        };

        var chart = new google.visualization.PieChart(document.getElementById(chartContainer[0]));
        chart.draw(data, options);    

        chartContainer.splice(0, 1);
        drawChart();
    }
}

function setupAjax(container){ 
    if($('.topo').length != 0 && container == '#content'){
        $('#esquerda, #direita, #page').css({top:$('.topo').height() + 'px'});
        $('#esquerda, #direita, #page').fadeIn(1000);
    }

    if($('.crono').length != 0 && container == '#tabs_content'){
        $('.crono').css('width', $('#page').width() - $('.crono_fixed').width() - 10);
    }

    $("#clone").unbind('click').bind("click", function(e) {
        $('#contato').clone().appendTo('#contatos_clone').css('display', 'block');
    });

    //******Relatorios*******//
    if($('.grafico').length != 0 && container == '#charts' && googleLoaded == true){
        $('.grafico').each(function(index, el) {
            chartContainer.push($(el).attr('id'));
        });
        drawCharts();
    }

    if($('.grafico').length != 0 && container == '#content'){
        $('.grafico').each(function(index, el) {
            chartContainer.push($(el).attr('id'));
        });
        google.load("visualization", "1", {packages:["corechart"], callback: drawCharts });
        googleLoaded = true;
    }    

    if($('#relatorios_project_id').length != 0 && container == '#content'){
        $('#relatorios_project_id').on('change', function() {
            loadContent({url:$('#' + this.id).data('url') + '/' + this.value, container:$('#' + this.id).data('panel')});
        });
    }

    $("#generateStatus").unbind('click').bind('click', function(e){
        e.preventDefault();
        var project_id = $('#relatorios_project_id').val();
        if(project_id != ''){
            $('#relatorio_project_id').val(project_id);
            $('#form_relatorio').submit();
        }else{
            setMsg({
                content:'Ops!..<br/><br/>Selecione um projeto e tente novamente...'
            });
        }
    });

    $("#updateGdocs").unbind('click').bind('click', function(e){
        e.preventDefault();
        var project_id = $('#relatorios_project_id').val();
        if(project_id != ''){
            $('#gdocs_project_id').val(project_id);
            $('#sync_gdocs').submit();
        }else{
            setMsg({
                content:'Ops!..<br/><br/>Selecione um projeto e tente novamente...'
            });
        }
    });

    $('.pickcolor').minicolors({
        control:'wheel',
    });


    //**************Acervo*****************//

    if($('#pagination').length != 0 && container == '#tabs_content'){
        $('#pagination').on('change', function() {
            var panel = $(this).data('panel');
            $.ajax({
                type: "POST",
                url: $(this).val(),
                dataType : "html",
                timeout: 20000, 
                success: function(data) {
                    reloadContent(data, panel);
                },
                error: function(e) {
                    console.log(e);
                    removeDialogs();
                    setMsg({
                        content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                        tema:'error',
                        fix: true,
                    });
                }
            });  

        });
    }

    if($(container + ' .scrollable_content').length != 0){
        $(container + ' .scrollable_content').each(function(index, el){
            if($(el).data('bottom') == undefined){
                $(el).css({height:$( window ).height() - $(el).offset().top - 5});
            }
        });
    }

    validateAjax(); 

    
    //console.log($("#pickfiles").size())

    
    if($("#pickfiles").size() == 1){
       uploader.init();
    }

    //$(container + " .scrollable_content").mCustomScrollbar("update");
    
    setupScroll();

    $('.checkAll').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.'+this.id).each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.'+this.id).each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
    $(".populate").change(function(ui) {
        populateSelect(ui);
    });

    $(".fone").mask("(99) 9999-9999");   

    $(".filter span").unbind('click').bind("click", function(e) {
        if($(this).parent().children('.filter_panel').css('display') == 'none'){
            closeFilterPanel();
        }
        $(this).parent().children('.filter_panel').fadeToggle(function(){
            if($(this).parent().children('.filter_panel').css('display') == 'none'){
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
                timeout: 20000, 
                url: base_url + '/tasks/reorder'
            });
        }
    }).disableSelection();

    $(".sortable_workflow").sortable({
        connectWith: ".connect",
        placeholder: "ui-state-highlight",
        distance: 30,
        update: function (event, ui) {
            // POST to server using $.post or $.ajax
            /*
            $.ajax({
                data: data,
                type: 'POST',
                timeout: 20000, 
                url: base_url + '/tasks/reorder'
            });
            */
        }
    }).disableSelection();



    $("a[rel='load-content']").unbind('click').bind('click', function(e){
        e.preventDefault();
        loadContent({url:$(this).attr("href"), container: $(this).data("panel")});

        if($(this).hasClass('menu')){
            $('#menu li a').removeClass('selected');
            $(this).addClass('selected');
        }

        if($(this).hasClass('load')){
            $('.list_item li a').removeClass('selected');
            $(this).addClass('selected');
        }    

        $("li").removeClass("blueSelection");
        $(this).closest("li").addClass("blueSelection");
    

        if($(this).data("refresh") != undefined){
            window.location.hash = $(this).attr("href");// hash_link + '/index/ajax';//.replace(base_url + 'admin/', '').replace('/index/ajax', '');
        }
    });

    $("a[rel='task_bar']").unbind('click').bind('click', function(e){
        e.preventDefault();
        loadContent({url:$(this).attr("href"), container:$(this).data("panel")});
    
        $('#menu li a').removeClass('selected');
        $('#tasks').addClass('selected');

        if($(this).data("refresh") != undefined){
            window.location.hash = $(this).attr("href");
        }
    });

    $(".collapse").unbind('click').bind('click', function () {
        //$header = $(this);
        var span = $('.collapse span');
        var element = $(this).data("show");
        $('.' + element).fadeToggle(200, function () {
            $('.' + element).is(":visible") ? span.attr('class', 'collapse_ico') : span.attr('class', 'expand_ico');
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
            dialogClass: 'noTitleStuff',
            show: 'clip',
            hide: 'clip',
            resizable:false,
            buttons: [
                {text: "excluir", click: function() {
                    loadContent({url:$(btExcluir).attr('href')});
                }},
                {text: "cancelar", click: function() {$(this).dialog("close")}}
            ]
        });
        return false;
    });

    $("a.close_pop").unbind('click').bind('click', function(e){
        e.preventDefault();
        removeDialogs();
    });

    $('a.popup').unbind('click').bind('click', function(e) {
        e.preventDefault();
        var url = this.href;
        var form;

        $('#dialog').remove();

        $('<div id="dialog" class="loading form_panel"></div>').appendTo('body');
        $('#dialog').load(
            url,  
            {},           
            function (responseText, textStatus, XMLHttpRequest) {
                $(this).removeClass('loading');
                setupAjax('#dialog');

                $('#dialog').show('slide', {direction: 'left'}, 300);

                setTimeout(function(){
                    $('#description').ckeditor({
                        height: $('#description').height(),
                        width: $('#description').width()});
                    
                    $('#tag_id, #status_id').unbind('change').bind('change', function(e){
                        e.preventDefault();
                        var data_post = {days : $('#' + e.target.id + ' option:selected').data('days')};
                        
                        $.ajax({
                            type: "POST",
                            url: $('#' + e.target.id).data('server'),
                            data: data_post,
                            timeout: 10000, 
                            dataType : "html",
                            success: function(retorno) {
                                $('#crono_date').val(retorno);
                            },
                            error: function(e) {
                                console.log(e);
                                setMsg({
                                    content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                                    tema:'error',
                                });
                            }
                        });   
                    }) 



                }, 500);
            }
        );
        
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
                loadContent({url:link, container:'#tabs_content'});
                
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

    $('.date').live('focus', function () {
        $(this).not('.hasDatePicker').datepicker({dateFormat: 'dd/mm/yy'}).val();
    });
}

function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}

function ajaxPost(form, container){
    CKupdate();
    var data_post = $(form).serializeArray();
    data_post.push({name: 'from', value: window.location.hash.replace('#', '')});
    data_post.push({name: 'container', value: container});

    removeDialogs();
    var NewDialog = $('<div id="dialog" class="ui-dialog loading"><p>aguarde...</p></div>');
    NewDialog.dialog({
        modal: true,
        dialogClass: 'noTitleStuff',
        show: 'clip',
        hide: 'clip',
        resizable:false,
    });

    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: data_post,
        timeout: 20000, 
        dataType : "json",
        success: function(retorno) {
            returnData = retorno;
            setDataPanels();
            $('input[type=submit]').prop("disabled", '' );
        },
        error: function(e) {
            console.log(e);
            removeDialogs();
            setMsg({
                content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                tema:'error',
                fix: true,
            });
        }
    });    
}

lastURL = "";
var returnData = [];
var loading = false;

function loadContent(args){
    url = args.url;
    container = args.container || '';
    removeDialog = args.removeDialog || false;
    
    if(logged_in != false){
        d = new Date();
        lastURL = url;

        if(removeDialog != true){
            removeDialogs();
        }

        var NewDialog = $('<div id="dialog" class="ui-dialog loading"><p>aguarde...</p></div>');
            NewDialog.dialog({
            modal: true,
            dialogClass: 'noTitleStuff',
            show: 'clip',
            hide: 'clip',
            resizable:false,
        });
        /*
        if(container == ''){
            var NewDialog = $('<div id="dialog" class="ui-dialog loading"><p>aguarde...</p></div>');
                NewDialog.dialog({
                modal: true,
                dialogClass: 'noTitleStuff',
                show: 'clip',
                hide: 'clip',
                resizable:false,
            });
        }else{
            $(container).html("<div class='loading'>loading...</div>"); 
        }
        */

        data_post = {container: container};

        $.ajax({
            type: "POST",
            url: url,
            data: data_post,
            dataType : "json",
            timeout: 20000, 
            success: function(retorno) {
                for(k in retorno){
                    returnData.push(retorno[k]);    
                }

                if(loading == false){
                    setDataPanels();
                }
                
            },
            error: function(e) {
                console.log(e);
                removeDialogs();
                setMsg({
                    content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                    tema:'error',
                    fix: true,
                });
            }
        });  
    }else{
        alert("sessão expirada!");
    }
}

function updateBar(url){
    if(logged_in != false){
        d = new Date();

        url = base_url + '/admin/taskstatus/updateTasksBar', true

        $("#taskBar").load(url, function() {
            setupAjax('#taskBar');  
        });
    }else{
        alert("sessão expirada!");
    }
}


function getContent(args){
    var url = args.content;
    var container = args.container;
    data_post = {container: container};

    $.ajax({
        type: "GET",
        url: url,
        data: data_post,
        dataType : "json",
        timeout: 20000, 
        success: function(retorno) {
            //console.log('chamou getContent')
            for(k in retorno){
                returnData.unshift(retorno[k]);    
            }
            setDataPanels();
        },
        error: function(e) {
            console.log(e);
            removeDialogs();
            setMsg({
                content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                tema:'error',
                fix: true,
            });

            //alert("ocorreu um erro ao carregar o conteúdo. getContent");
        }
    });  
}


function setDataPanels(){
    loading = true;
    if(returnData.length > 0){
        var result = returnData[0];
        //console.log(result);

        returnData.shift();

        switch(result.type) {
            case 'html':
                setPanelContent(result);
                break;
            case 'url':
                getContent(result);
                break;
            case 'msg':
                setMsg(result);
                break;
        }    
    }else{
        removeDialogs();
        loading = false;
    }
}

function setPanelContent(args){
    var data = $.parseJSON(args.content);
    var container = args.container;

    $(container).html("<div class='loading'>loading...</div>"); 
    

    if($(container + " .mCSB_container").length > 0){
        holder = container + " .mCSB_container";
    }else{
        holder = container;
    }
    
    $(holder).hide(400, function(){
        $(holder).html(data);
    }).fadeIn(500, function(){
        setupAjax(container);   
        setDataPanels();
    });    
}

function setMsg(args){
    tema = args.tema || 'normal';
    fix = args.fix || false;
    
    $.jGrowl(
        args.content,
        { 
            theme:tema, 
            position:'bottom-right',
            sticky: fix,
            open: function() {setDataPanels();},
        }
    );
}

function removeDialogs(){
    if($('.ui-dialog').length != 0){
        var options = {};
        $('.ui-dialog').effect('clip', options, 200, function(){
            $(this).remove();
        });
    }

    if($('#dialog').length != 0){
        $('#dialog').hide('slide', {direction: 'left'}, 200, function(){
            $(this).remove();
        });
    }
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