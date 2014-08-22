function validateAjax(){
    //console.log("chamou validate")
    $(".date").datepicker({dateFormat: 'dd/mm/yy'}).val();

    $("#frmCreateTask").validate({
        rules: {
            topic: {required:true},
            crono_date: {required:true},
            description: {required:true},
        },
        messages: {
            topic: { required:'Campo não pode ser vazio'},
            crono_date: { required:'Campo não pode ser vazio'},
            description: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    })

    $("#frmCreateTask2").validate({
        rules: {
            topic: {required:true},
            crono_date: {required:true},
            description: {required:true},
        },
        messages: {
            topic: { required:'Campo não pode ser vazio'},
            crono_date: { required:'Campo não pode ser vazio'},
            description: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    })

    $("#frmAlteraStatus").validate({
        rules: {
            status_id: {required:true},
            prova: {required:true},
            crono_date: {required:true},
        },
        messages: {
            status_id: { required:'Selecione uma opção'},
            prova: { required:'Selecione uma opção'},
            crono_date: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            console.log('validate frmStatus');
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    })

    $("#frmStatus2").validate({
        rules: {
            status_id: {required:true},
            prova: {required:true},
            crono_date: {required:true},
        },
        messages: {
            status_id: { required:'Selecione uma opção'},
            prova: { required:'Selecione uma opção'},
            crono_date: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    })

    $("#frmAnotacoes").validate({
        rules: {
            anotacoes: {required:true},
        },
        messages: {
            anotacoes: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    });

    $("#frmAnotacoes_edit").validate({
        rules: {
            anotacoes: {required:true},
        },
        messages: {
            anotacoes: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    });

    $("#startTask").validate({
        rules: {
        },
        messages: {            
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    });

    $("#frmEditTask").validate({
        rules: {
        },
        messages: {            
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    });

    $("#formEndTask").validate({
        rules: {
        },
        messages: {            
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    });

    $("#frm_oeds").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxReload(form);
            return false;       
        }
    });

    

    $("#frmCusto2").validate({
        rules: {
            team_id: {required:true},
            supplier_id: {required:true},
            valor: {required:true},
        },
        messages: {
            team_id: { required:'Campo não pode ser vazio'},
            supplier_id: { required:'Campo não pode ser vazio'},
            valor: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false;       
        }
    })    
}

function ajaxPost(form){
    console.log('chamou ajaxPost');
    //$('input[type=submit]').attr('disabled', '');
    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: $(form).serialize(),
        timeout: 10000,
        success: function(retorno) {
            //console.log('r ' + retorno);
            
            loadContent(retorno, $(form).data('panel'));
        },
        error: function(e) {
            console.log(e);
            alert("ocorreu um erro.");
        }
    });    
}


function ajaxReload(form){
    $('input[type=submit]').attr('disabled', '');
    //console.log('chamou reload')
    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: $(form).serialize(),
        timeout: 10000,
        success: function(retorno) {
            reloadContent(retorno, $(form).data('panel'));
        },
        error: function(e) {
            console.log(e);
            alert("ocorreu um erro.");
        }
    });    
}