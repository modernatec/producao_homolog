$(document).ready(function() {
        $("#frmCreateUsers").validate({            
            ignore: ".ignore",
            rules: {
                username: {required:true},
                role: {required:true},
                team: {required:true},
                nome: {required:true}
            },
            messages: {
                username: { required:"Digite o username."},
                role: {required:"Escolha uma permissão"},
                team: {required:"Escolha uma equipe"},
                nome: {required:"Digite o nome."}
            },
            submitHandler: function(form){
              checkUpload(form);
            }
        })        
});