function validateAjax(){
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
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                timeout: 10000,
                success: function() {
                    location.reload();
                },
                error: function(e) {
                    console.log(e);
                    alert("ocorreu um erro.");
                }
            });
            return false;       
        }
    })

    $("#frmEditTask").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                timeout: 3000,
                success: function() {
                    location.reload();
                },
                error: function(e) {
                    console.log(e);
                    alert("ocorreu um erro.");
                }
            });
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
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                timeout: 3000,
                success: function() {
                    location.reload();
                },
                error: function(e) {
                    console.log(e);
                    alert("ocorreu um erro.");
                }
            });
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
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                timeout: 3000,
                success: function() {
                    location.reload();
                },
                error: function(e) {
                    console.log(e);
                    alert("ocorreu um erro.");
                }
            });
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
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                timeout: 3000,
                success: function() {
                    location.reload();
                },
                error: function(e) {
                    console.log(e);
                    alert("ocorreu um erro.");
                }
            });
            return false;       
        }
    })


    
}