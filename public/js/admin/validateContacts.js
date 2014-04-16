$(document).ready(function() {
        $("#frmContact").validate({
            rules: {
                nome: {required:true},
                email: {required:true,email:true},
                telefone: {required:true}
            },
            messages: {
                nome: { required:"Digite o nome do contato."},
                target: { required: "Digite o email do contato." },
                telefone: {required:"Digite o telefone o contato."}
            },
            submitHandler: function(form) {
              form.submit();
            }
        })
});