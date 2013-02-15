$(document).ready(function() {
        $("#frmCreateCountry").validate({
            rules: {
                nome: {required:true}
            },
            messages: {
                nome: { required:'Campo não pode ser vazio'}
            },
            submitHandler: function(form) {
              $(form).submit();
            }
        })
});

