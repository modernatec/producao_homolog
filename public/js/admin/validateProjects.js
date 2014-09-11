$(document).ready(function() {
        $("#frmCreateProject").validate({
            
            submitHandler: function(form) {
              form.submit();
            }
        })
});