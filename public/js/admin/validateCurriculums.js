$(document).ready(function() {
        $("#frmCurriculum").validate({
            rules: {
                name: {required:true},
                objective: {required:true}
            },
            messages: {
                name: { required:"Digite o nome."},
                objective: { required:"Digite o objetivo."}
            },
            submitHandler: function(form) {
              checkUpload(form);
              //$(form).submit();
            }
        })
});