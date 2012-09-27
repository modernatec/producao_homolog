$(document).ready(function() {
        $("#frmCreateProject").validate({
            rules: {
                name: {required:true},
                target: {required:true},
                description: {required:true}
            },
            messages: {
                name: { required:"Digite o nome do projeto."},
                target: { required: "Digite o seguimento do projeto." },
                description: {required:"Digite uma descrição para o projeto."}
            },
            submitHandler: function(form) {
              $(form).submit();
            }
        })
});