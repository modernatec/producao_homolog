function checkUpload(form){
    if(newFile){
        myDropzone.processQueue();
    }else{
        ajaxPost(form);
    }
    newFile = false;
    //myDropzone.forElement("#upload").destroy();
}

var myDropzone;
var newFile = false;
function setupUpload(){
    var user_id = $("#upload").data('user');
    var form = $('#upload').closest("form");

    myDropzone = new Dropzone("#upload", {
        maxFiles:1,
        autoProcessQueue: false,
        uploadMultiple: false,
        thumbnailWidth: 100,
        thumbnailHeight: 100,
        autoDiscover: false,
        url: base_url + 'admin/users/upload/' + user_id,
        accept: function(file, done) {
           newFile = true;
           done();
        },
        init: function() {
            this.on("addedfile", function() {
                if (this.files[1]!=null){
                    this.removeFile(this.files[0]);
                }
            });        
        },
        success: function( file, response ){
            if(response == '0'){
                setMsg({
                    content:'Ops!..<br/><br/>Erro ao enviar o arquivo.<br/>tente novamente...', 
                    container:'error'
                });
                $('input[type=submit]').attr('disabled', '');
            }else{
                $('#userFoto').attr('value', response);
                form.submit();
            }
        }
    });
}

var fileDropzone;
function setupUploadFinalPackage(){
    fileDropzone = new Dropzone("#uploadPackage", {
        maxFiles:1,
        acceptedFiles: '.zip',
        autoProcessQueue: true,
        uploadMultiple: false,
        thumbnailWidth: 100,
        thumbnailHeight: 100,
        autoDiscover: false,
        url: $('#uploadPackage').data('action'),
        accept: function(file, done) {
            done();
        },
        init: function() {
            this.on("addedfile", function() {
                if (this.files[1]!=null){
                    this.removeFile(this.files[0]);
                }
            });        
        },
        success: function( file, response ){
            if(response == '0'){
                setMsg({
                    content:'Ops!..<br/><br/>Erro ao enviar o arquivo.<br/>Verifique o tamanho do pacote e tente novamente...', 
                    container:'error'
                });                
            }else{
                console.log(response);
                $('div.dz-preview').remove();

                //$('#uploadPackage').removeClass('dz-started');
                    
                setMsg({
                    content:'upload concluído',
                });
            }
        }
    });
}

// Helper function that formats the file sizes
function formatFileSize(bytes) {
    if (typeof bytes !== 'number') {
        return '';
    }

    if (bytes >= 1000000000) {
        return (bytes / 1000000000).toFixed(2) + ' GB';
    }

    if (bytes >= 1000000) {
        return (bytes / 1000000).toFixed(2) + ' MB';
    }

    return (bytes / 1000).toFixed(2) + ' KB';
}


function rightClick(obj,func)
{
    $(obj).bind("contextmenu", function(e) { e.preventDefault(); if(func){ func(); } });
}

var m_x = 0;
var m_y = 0;

function closeFilterPanel(){
    $('.filter ul li').css({'background': ''});
    $('.filter_panel').css({'display': 'none'});
    $('.filter_panel_arrow').css({'display': 'none'});
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

    $.datepicker.setDefaults($.datepicker.regional["pt-br"]);

    Dropzone.autoDiscover = false;
    updateBar();


});


setInterval(function() {
    updateBar();
}, 5000);


function setupScroll(){
    if($('.scrollable_content').length != 0){
        $('.scrollable_content').each(function(index, el){
            if($(el).data('bottom') == undefined){
                $(el).css({height:$(window).height() - $(el).offset().top - 5});
            }
        });
    }
    /*
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
        axis:"yx",
        scrollInertia: 0,
        scrollTo:0,
        
        advanced:{
            autoScrollOnFocus: false,
            updateOnContentResize: true,
            updateOnBrowserResize:true,
        },
    });
    */
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

function setScroll_teste(){
    console.log('chamou')
    
}

function setupAjax(container){ 
    if(container == "#taskBar"){
        $("a[rel='task_bar']").unbind('click').bind('click', function(e){
            e.preventDefault();
            loadContent({url:$(this).attr("href"), container:$(this).data("panel")});
        
            $('#menu li a').removeClass('selected');
            $('#tasks').addClass('selected');

            if($(this).data("refresh") != undefined){
                window.location.hash = $(this).attr("href");
            }
        });
    }else{

        if($('.topo').length != 0 && container == '#content'){
            $('#esquerda, #direita, #page').css({top:$('.topo').height() + 5 + 'px'});
            $('#esquerda, #direita, #page').fadeIn(1000);
        }

        if($('.crono').length != 0 && container == '#tabs_content'){
            $('.crono').css('width', $('#page').width() - $('.crono_fixed').width() - 10);
        }
        

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
                            container:'error',
                            
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
        
        if($("#upload").size() == 1){
            if(myDropzone){
                myDropzone.destroy();
                myDropzone = undefined;
            }
            console.log(myDropzone);
            setupUpload();
        }

        if($("#uploadPackage").size() == 1){
            if(fileDropzone){
                fileDropzone.destroy();
                fileDropzone = undefined;
            }
            setupUploadFinalPackage();
        }    
        
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

        $('.money').autoNumeric('init');

        $(".filter span").unbind('click').bind("click", function(e) {
            var panel = $(this).parent().children('.filter_panel');
            var arrow = $(this).parent().children('.filter_panel_arrow');
            
            if(panel.css('display') == 'none'){
                closeFilterPanel();
            }

            button_w = $('#' + e.currentTarget.id).width();
            panel_w = $(this).parent().children('.filter_panel').width();

            console.log();
            panel.css('left', '-' + ((panel_w / 2) - (button_w / 2)) + 'px');
            arrow.css('left', (button_w / 2) + 'px');
            
            arrow.fadeToggle();

            panel.fadeToggle(function(){
                if(panel.css('display') == 'none'){
                    //$(this).parent().parent().children('li').css({'background': ''});
                }
            });

            //$(this).parent().parent().children('li').css({'background': '#cccccc'});
            
        });

        $(".cancelar").unbind('click').bind('click', function() { 
            closeFilterPanel();
        });


        $("#sortable").sortable({
            placeholder: "ui-state-highlight",
            distance: 70,
            scroll: true, 
            scrollSensitivity: 100,
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

        $(".sortable_tags").sortable({
            placeholder: "ui-state-highlight",
            distance: 30,
            scroll: true, 
            scrollSensitivity: 100,
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                // POST to server using $.post or $.ajax
                $.ajax({
                    data: data,
                    type: 'POST',
                    timeout: 20000, 
                    url: base_url + '/tags/reorder'
                });
            }
        }).disableSelection();

        $(".sortable_status").sortable({
            placeholder: "ui-state-highlight",
            distance: 30,
            scroll: true, 
            scrollSensitivity: 100,
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                // POST to server using $.post or $.ajax
                $.ajax({
                    data: data,
                    type: 'POST',
                    timeout: 20000, 
                    url: base_url + '/status/reorder'
                });
            }
        }).disableSelection();

        $("#workflow_task").sortable({
            connectWith: ".connect",
            placeholder: "ui-state-highlight",
            distance: 30,
            scroll: false, 
            scrollSensitivity: 100,
            update: function (event, ui) {
            },
            helper: function(e,li) {
                copyHelper = li.clone().insertAfter(li);
                return li.clone();
            },
            stop: function(event, ui) {
                copyHelper && copyHelper.remove();
                console.log(ui.item.attr('rel'));

                item = $('ul.drop > [rel=' + ui.item.attr('rel') + "]");

                $('ul.drop > [rel=' + ui.item.attr('rel') + "] > .remover").removeClass('hide');
                
                ul = $(item).closest('ul.drop');
                if(ul){
                    var status_id = $(ul).data('status');
                    console.log(status_id);
                    
                    //$('.drop #' + ui.item.attr('id') + " > div.infos").removeClass('hide');

                    $('ul.drop > [rel=' + ui.item.attr('rel') + "] > div.infos .info").each(function(e, ui){
                        name = $(ui).attr('name');
                        $(ui).attr('name', name + '_' + status_id + '[]');
                        console.log(ui)
                    })

                    $('ul.drop > [rel=' + ui.item.attr('rel') + "] > div.infos").removeClass('hide');
                    item.attr('rel', status_id);
                }else{
                    item.addClass('hide');
                }
            }
        }).disableSelection();

        $(".sortable_workflow").sortable({
            placeholder: "ui-state-highlight",
            distance: 30,
            scroll: false, 
            receive: function(e,ui) {
                copyHelper = null;
            }
        });

        $(".sortable_status_workflow").sortable({
            connectWith: ".connect",
            placeholder: "ui-state-highlight",
            distance: 30,
            scroll: false, 
            scrollSensitivity: 100,
            
        }).disableSelection();

        $(".sortable_produtoras").sortable({
            connectWith: ".connect_suppliers",
            placeholder: "ui-state-highlight",
            distance: 30,
            scroll: false, 
            scrollSensitivity: 100,
            update: function (event, ui) {
                
            },
            stop: function (event, ui) {
                item = $('#' + ui.item.attr('id') + " > div.infos");
                if($(item).closest('ul').hasClass('drop')){
                    item.removeClass('hide');
                }else{
                    item.addClass('hide');
                }
            }
        }).disableSelection();

        $(".sortable_creditos").sortable({
            connectWith: ".connect_contacts",
            placeholder: "ui-state-highlight",
            distance: 30,
            scroll: false, 
            scrollSensitivity: 100,
            
        }).disableSelection();

        /*
        $( "#sortable1" ).sortable({
            connectWith: ".connectedSortable",
            forcePlaceholderSize: false,
            helper: function(e,li) {
                copyHelper= li.clone().insertAfter(li);
                return li.clone();
            },
            stop: function() {
                copyHelper && copyHelper.remove();
            }
        });
            $(".connectedSortable").sortable({
                receive: function(e,ui) {
                    copyHelper= null;
                }
        });

        */

        $('.remover').unbind('click').bind('click', function(e){
            e.preventDefault();
            $(this).closest("li").remove();
        });


        $("a[rel='load-content']").unbind('click').bind('click', function(e){
            e.preventDefault();
            loadContent({url:$(this).attr("href"), container: $(this).data("panel")});

            if($(this).hasClass('menu')){
                $('#menu li a').removeClass('selected');
                $(this).addClass('selected');
            }

            /*
            if($(this).hasClass('load')){
                $('.list_item li a').removeClass('selected');
                //$(this).addClass('selected');
            } 
            */   

            $("li").removeClass("blueSelection");
            $(this).closest("li").addClass("blueSelection");
        

            if($(this).data("refresh") != undefined){
                window.location.hash = $(this).attr("href");
                //hash_link + '/index/ajax';//.replace(base_url + 'admin/', '').replace('/index/ajax', '');
            }
        });

        $(".collapse").unbind('click').bind('click', function () {
            var el = $(this);
            var element = $(this).data("show");
            var pos = (el.hasClass('icon_collapse_white') || el.hasClass('icon_expand_white')) ? '_white' : '';

            if($('.' + element).length > 0){
                if(el.hasClass('icon_collapse_white') || el.hasClass('icon_collapse')){
                    el.removeClass('icon_collapse_white icon_collapse');

                    $('.' + element).each(function(ev, ui){
                        $(ui).addClass('hide');
                        el.addClass('icon_expand' +  pos);
                    });

                    if($('.collapse_' + element).length > 0){
                        $('.collapse_' + element).each(function(ev, ui){
                            $(ui).removeClass('icon_collapse');
                            $(ui).addClass('icon_expand');
                        })
                    }

                }else{
                    el.removeClass('icon_expand_white icon_expand');

                    $('.' + element).each(function(ev, ui){
                        $(ui).removeClass('hide');
                        el.addClass('icon_collapse' + pos);
                    });

                    if($('.collapse_' + element).length > 0){
                        $('.collapse_' + element).each(function(ev, ui){
                            $(ui).removeClass('icon_expand');
                            $(ui).addClass('icon_collapse');
                        })
                    }
                }
            }     
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

        $("a:contains('Excluir'), a.icon_excluir").unbind('click').bind('click', function() {        
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

        $("a.view_oed").unbind('click').bind('click', function(e) {   
            e.preventDefault();
            var url = this.href;

            $('#dialog').remove();
            $('<div id="dialog" class="loading form_panel"></div>').appendTo('body');

            $.ajax({
                type: "POST",
                url: url,
                timeout: 1000, 
                dataType : "html",
                success: function(retorno) {
                    $('#dialog').removeClass('loading');
                    if(retorno != 0){
                        $('#dialog').addClass('acervo_preview');
                        $('#dialog').show('slide', {direction: 'left'}, 300, function(){
                            $('#dialog').append(retorno);
                            setupAjax('#dialog');
                        });
                    }else{
                        setMsg({
                            content:'Ops!..<br/><br/>Não encontrei este OED.', 
                            container:'error',
                        });
                    }
                },
                error: function(e) {
                    $('#dialog').removeClass('loading');
                    console.log(e);
                    setMsg({
                        content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                        container:'error',
                    });
                }
            });  
        });

        $("a.acervo_view").unbind('click').bind('click', function(e) {   
            e.preventDefault();
            var url = this.href;

            $.ajax({
                type: "POST",
                url: url,
                timeout: 1000, 
                dataType : "html",
                success: function(retorno) {
                    //$('#dialog').removeClass('loading');
                    if(retorno != 0){
                        $('#acervo_preview').removeClass('hide');
                        //$('#dialog').addClass('acervo_preview');
                        //$('#dialog').show('slide', {direction: 'left'}, 300, function(){
                        $('.iframe_body').attr('src', retorno);
                        setupAjax('#dialog');
                        //});
                    }else{
                        setMsg({
                            content:'Ops!..<br/><br/>Não encontrei este OED.', 
                            container:'error',
                        });
                    }
                },
                error: function(e) {
                    //$('#dialog').removeClass('loading');
                    console.log(e);
                    setMsg({
                        content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                        container:'error',
                    });
                }
            });  
        });

        $("a.close_pop").unbind('click').bind('click', function(e){
            e.preventDefault();
            removeDialogs();
        });

        $('a.startTask').unbind('click').bind('click', function(e, ui) {
            e.preventDefault();
            var url = this.href;
            var task_id = $(this).data('taskid');
            var object_id = $(this).data('objectid');

            var data_post = [];
            data_post.push({name: 'task_id', value: task_id});
            data_post.push({name: 'object_id', value: object_id});

            var dialog = dialog;

            if(dialog == undefined){        
                removeDialogs();
                var NewDialog = $('<div id="dialog" class="ui-dialog loading"><p>aguarde...</p></div>');
                NewDialog.dialog({
                    modal: true,
                    dialogClass: 'noTitleStuff',
                    show: 'clip',
                    hide: 'clip',
                    resizable:false,
                });
            }
            
            $.ajax({
                type: "POST",
                url: url,
                data: data_post,
                timeout: 20000, 
                dataType : "json",
                success: function(retorno) {
                    returnData = retorno;
                    setDataPanels(dialog);
                    $('input[type=submit]').prop("disabled", '' );
                },
                error: function(e) {
                    console.log(e);
                    removeDialogs();
                    setMsg({
                        content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                        container:'error',
                        
                    });
                }
            }); 
            
        });

        $('a.popup').unbind('click').bind('click', function(e) {
            e.preventDefault();
            var url = this.href;
            var data = $(this).data('post');
            
            var form;

            
            if($(this).data('select') != undefined){
                $('div > .selected').removeClass('selected');
                $('#' + $(this).data('select')).addClass('selected');
            }
           
            $('#dialog').remove();

            $('<div id="dialog" class="loading form_panel"></div>').appendTo('body');
            $('#dialog').load(
                url,  
                data,           
                function (responseText, textStatus, XMLHttpRequest) {
                    $(this).removeClass('loading');
                    setupAjax('#dialog');

                    var is_json = true;
                    try{
                       var response = $.parseJSON(responseText);
                    }catch(err){
                       is_json = false;
                    }   

                    if(is_json){
                        setMsg({
                            content: response[0].content, 
                            container:'error',
                        });
                    }else{
                        $('#dialog').show('slide', {direction: 'left'}, 300);

                        setTimeout(function(){
                            $('#description').ckeditor();
                            
                            $('#tag_id, #status_id').unbind('change').bind('change', function(e){
                                e.preventDefault();
                                var days = $('#' + e.target.id + ' option:selected').data('days');
                                
                                $.ajax({
                                    type: "POST",
                                    url: base_url + '/admin/feriados/getWorkDay/' + days,
                                    timeout: 10000, 
                                    dataType : "html",
                                    success: function(retorno) {
                                        $('#crono_date').val(retorno);
                                    },
                                    error: function(e) {
                                        console.log(e);
                                        setMsg({
                                            content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                                            container:'error',
                                        });
                                    }
                                });

                                //getSequenceList($workflow_id)
                                if($(this).attr('id') == 'status_id'){
                                    var workflow_id = $(this).data('workflow');
                                    var status_id = $('#' + e.target.id + ' option:selected').val();

                                    var data_post = [{name: 'status_id', value:status_id}];

                                    $.ajax({
                                        type: "POST",
                                        url: base_url + '/admin/tasks/getSequenceList/' + workflow_id,
                                        data: data_post,
                                        timeout: 10000, 
                                        dataType : "html",
                                        success: function(retorno) {
                                            $('#sequence').html(retorno);
                                            setupAjax();
                                        },
                                        error: function(e) {
                                            console.log(e);
                                            setMsg({
                                                content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                                                container:'error',
                                            });
                                        }
                                    });
                                }   
                            }) 
                        }, 500);
                        
                        
                    }
                    
                }
            );
            
            return false;
        });

        $('.crono').unbind('change').bind('change', function(e){
            days = $(this).data('days');
            start = $(this).val();
            target = $(this).data('target');

            var data_post = [{name: 'from', value:start}];

            $.ajax({
                type: "POST",
                url: base_url + '/admin/feriados/getWorkDay/' + days,
                data: data_post,
                timeout: 1000, 
                dataType : "html",
                success: function(retorno) {
                    $('#' + target).val(retorno);
                },
                error: function(e) {
                    console.log(e);
                    setMsg({
                        content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                        container:'error',
                    });
                }
            });  
        });

        /*
        $('#project_segmento, #project_ano').unbind('change').bind('change', function(e){
            e.preventDefault();
            var ano = $('#project_ano option:selected').val();
            var segmento = $('#project_segmento option:selected').val();
            var project_id = $('#project_id').val();
            
            var data_post = [{name: 'ano', value:ano}, {name: 'segmento', value:segmento}];

            $.ajax({
                type: "POST",
                url: base_url + '/admin/collections/getCollectionList/' + project_id,
                data: data_post,
                timeout: 1000, 
                dataType : "html",
                success: function(retorno) {
                    $('#collections').html(retorno);
                    setupAjax('#direita');
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
        */


        $('.tabs a').unbind('click').bind('click', function(e){
            e.preventDefault();
            link = $(this).attr('href');


            if(link != lastURL){
                
                $('.content_hide').each(function(index, element){            
                    if($(this).hasClass('content_show')){
                        $(this).removeClass('content_show');

                    }
                });            

                if($(this).hasClass('ajax')){
                    $('.tabs li').removeClass('selected');
                    loadContent({url:link, container:'#tabs_content'});
                    
                    if($(this).attr('data-clear')){                    
                        $($(this).attr('data-clear')).html(" ");
                    }

                    $.removeCookie("producao");
                    $.cookie("producao", '#' + $(this).attr('id'), { expires : 1 });
                }else{
                    $('.tabs a').each(function(e, ui){
                        if($('#' + ui.id).data('show') != undefined){
                            $('#' + ui.id).closest('li').removeClass('selected');
                        }
                    });

                    $($(this).data('show')).addClass('content_show');
                }

                
                $(this).closest('li').addClass('selected');

                setupScroll();
            }
        })
        
        var tab = $.cookie("producao");

        setTimeout(function(){
            if($(container + ' ' + tab).length > 0){
                $(container + ' ' + tab).click(); 
            }else{
                $('.tabs > .selected a').each(function(e, ui){
                    if($('#' + ui.id).data('show') != undefined){
                        $($('#' + ui.id).data('show')).addClass('content_show');
                        
                    }
                });
                /*
                $('.tabs > .selected').data('show');
                if($('.tabs > .selected').data('show') != ''){
                    console.log($('.tabs > .selected').data('show'));
                }
                */
                $(container + ' a.aba').first().click(); 
            }

            setupScroll();
        }, 100);    

        $('.date').live('focus', function () {
            $(this).not('.hasDatePicker').datepicker(
                {
                    beforeShowDay: function(date){
                        var day =  date.getDay();
                        if(day == 0){
                            return [false];
                        }else{
                            var formattedDate = $.datepicker.formatDate("yy-mm-dd", date);
                            return (hollidays.indexOf(formattedDate) ==-1) ? [true] : [false];
                        }
                    }
                }
            ).val();
        });
    }
}

function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}

function ajaxPost(form, container, dialog){
    CKupdate();
    var data_post = $(form).serializeArray();
    data_post.push({name: 'from', value: window.location.hash.replace('#', '')});
    data_post.push({name: 'container', value: container});
    var dialog = dialog;
    closeFilterPanel();

    if(dialog == undefined){        
        removeDialogs();
        var NewDialog = $('<div id="dialog" class="ui-dialog loading"><p>aguarde...</p></div>');
        NewDialog.dialog({
            modal: true,
            dialogClass: 'noTitleStuff',
            show: 'clip',
            hide: 'clip',
            resizable:false,
        });
    }

    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: data_post,
        timeout: 20000, 
        dataType : "json",
        success: function(retorno) {
            returnData = retorno;
            setDataPanels(dialog);
            $('input[type=submit]').prop("disabled", '' );
        },
        error: function(e) {
            console.log(e);
            removeDialogs();
            setMsg({
                content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                container:'error',
                
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

    closeFilterPanel();
    
    if(logged_in != false){
        d = new Date();
        lastURL = url;

        if(removeDialog != true){
            removeDialogs();
        }

        
        //if($('.loading').length == 0){
            var NewDialog = $('<div class="ui-dialog loading"><p>aguarde...</p></div>');
            NewDialog.dialog({
                modal: true,
                dialogClass: 'noTitleStuff',                
                resizable:false,
            });
        //}

        data_post = {container: container};

        $.ajax({
            type: "POST",
            url: url,
            data: data_post,
            dataType : "json",
            timeout: 5000, 
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
                    container:'error',                    
                });
                setupAjax();
            }
        });  
    }else{
        alert("sessão expirada!");
    }
}

function updateBar(url){
    if(current_auth != 'assistente' && current_auth !== 'editor 1'){
        if(logged_in != false){
            d = new Date();
            url = base_url + '/admin/tasks_status/updateTasksBar', true

            $("#taskBar").load(url, function() {
                setupAjax('#taskBar');  
            });
        }else{
            alert("sessão expirada!");
        }
    }
}


function getContent(args, dialog){
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
            for(k in retorno){
                returnData.unshift(retorno[k]);    
            }
            setDataPanels(dialog);
        },
        error: function(e) {
            console.log(e);
            removeDialogs();
            setMsg({
                content:'Ops!..<br/><br/>Erro ao carregar o conteúdo.<br/>tente novamente...', 
                container:'error',
                
            });
        }
    });  
}


function setDataPanels(dialog){
    loading = true;
    if(returnData.length > 0){
        var result = returnData[0];
        returnData.shift();

        switch(result.type) {
            case 'html':
                setPanelContent(result, dialog);
                break;
            case 'url':
                getContent(result, dialog);
                break;
            case 'msg':
                setMsg(result, dialog);
                break;
        }    
    }else{
        if(dialog == undefined){   
            removeDialogs();
        }
        
        loading = false;
    }
}

function setPanelContent(args, dialog){
    var data;
    try{
        data = $.parseJSON(args.content);
    }catch(err){
        data = args.content;
    }  

    var container = args.container;

    $(container).html("<div class='loading'>loading...</div>"); 

    if($(container + " .mCSB_container").length > 0){
        holder = container + " .mCSB_container";
    }else{
        holder = container;
    }

    $(holder).html(data);
    setupAjax(container);   
    setDataPanels(dialog);
    
    /*
    $(holder).fadeOut(0, function(){
        $(holder).html(data);
    }).fadeIn(10, function(){
        setupAjax(container);   
        setDataPanels(dialog);
    });
    */    
}

function setMsg(args, dialog){
    tema = args.container || 'normal';
    fix = args.fix || false;
    
    $.jGrowl(
        args.content,
        { 
            theme:tema, 
            position:'top-right',
            sticky: fix,
            open: function() {setDataPanels(dialog);},
        }
    );
}

function removeDialogs(){   
    if($('.ui-dialog').length != 0){
        var options = {};
        $('.ui-dialog').fadeOut(200, function(){
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
        $.datepicker.parseDate('dd/mm/yy', $.trim(value));
    }
    catch (err) {
        console.log(err)
        ok = false;
    }
    return ok;
}); 