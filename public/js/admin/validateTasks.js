$(document).ready(function() {        
    $("#frmCreateTask").validate({
        rules: {
            topic: {required:true},
            crono_date: {required:true},
            description: {required:true},
        },
        messages: {
            topic: { required:'não pode ser vazio'},
            crono_date: { required:'não pode ser vazio'},
            description: { required:'não pode ser vazio'},
        },
        submitHandler: function(form) {          
          $('input[type=submit]').attr('disabled', 'disabled');
          form.submit();
        }
    });

    $("#frmStatus").validate({
        rules: {
            status_id: {required:true},
            prova: {required:true},
            crono_date: {required:true},
        },
        messages: {
            status_id: { required:'Selecione uma opção'},
            prova: { required:'Selecione uma opção'},
            crono_date: { required:'não pode ser vazio'},
        },
        submitHandler: function(form) {
          $('input[type=submit]').attr('disabled', 'disabled');  
          form.submit();
        }
    })

    $("#formEndTask").validate({
        submitHandler: function(form) {
          $('input[type=submit]').attr('disabled', 'disabled');  
          form.submit();
        }
    })

    $('#correcao').click(function(){
        $('#next_step').val('6');
        $('#submit_btn').click();
    });
        

    
});