$(document).ready(function() {
        $("#frmTeam").validate({
            rules: {
                name: {required:true}
            },
            messages: {
                name: { required:"Digite o nome do contato."}
            },
            submitHandler: function(form) {
              $(form).submit();
            }
        })
});