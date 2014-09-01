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

    $("#frmSupplier").validate({
        rules: {
            empresa:{required:true},
            "nome[]": {required:true},
            "email[]": {required:true,email:true},
            "telefone[]": {required:true}
        },
        messages: {
            empresa: { required:"Digite o nome da empresa."},
            "nome[]": { required:"Digite o nome do contato."},
            "email[]": { required: "Digite o email do contato." },
            "telefone[]": {required:"Digite o telefone o contato."}
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

    $("#frm_suppliers").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxReload(form);
            return false;       
        }
    });

    $("#frm_usuarios").validate({
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


    $("#frmCreateObject").validate({
        rules: {
            title: {required:true},
            taxonomia: {required:true},
            collection_id: {required:true},
            country_id: {required:true},
            fase: {required:true},
            typeobject_id: {required:true},
            supplier_id: {required:true},
            crono_date: {required:true},
            ini_date: {required:true},
            arq_aberto: {required:true},
            interatividade: {required:true},
            format_id:{required:true},
            reaproveitamento:{required:true},
        },
        messages: {
            title: { required:'Campo não pode ser vazio'},
            taxonomia: { required:'Campo não pode ser vazio'},
            collection_id: { required:'Selecione uma opção'},
            country_id: { required:'Selecione uma opção'},
            fase: { required:'Selecione uma opção'},
            typeobject_id: { required:'Selecione uma opção'},
            supplier_id: { required:'Selecione uma opção'},
            crono_date: { required:'Campo não pode ser vazio'},
            ini_date: { required:'Campo não pode ser vazio'},
            arq_aberto: { required:'Selecione uma opção'},
            interatividade: { required:'Selecione uma opção'},
            format_id:{ required:'Selecione uma opção'},
            reaproveitamento:{ required:'Selecione uma opção'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form);
            return false; 
        }
    })   
}

function ajaxPost(form){
    $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: $(form).serialize(),
        timeout: 10000,
        success: function(retorno) {
            //console.log('r ' + retorno);
            
            loadContent(retorno, $(form).data('panel'));
            $('input[type=submit]').prop("disabled", null );
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
            $('input[type=submit]').prop("disabled", null );
        },
        error: function(e) {
            console.log(e);
            alert("ocorreu um erro.");
        }
    });    
}