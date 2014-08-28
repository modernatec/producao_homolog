$(document).ready(function() {
        $("#frmSupplier").validate({
            
            submitHandler: function(form) {
              form.submit();
            }
        })
});