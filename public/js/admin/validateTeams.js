$(document).ready(function() {
        $("#frmTeam").validate({
            rules: {
                name: {required:true}
            },
            messages: {
                name: { required:"Digite o nome da equipe."}
            },
            submitHandler: function(form) {
              form.submit();
            }
        })
});