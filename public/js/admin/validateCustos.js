$(document).ready(function() {        
    $("#frmCusto").validate({
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
          form.submit();
        }
    });    
});


