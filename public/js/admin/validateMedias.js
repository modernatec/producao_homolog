$(document).ready(function() {
        $("#frmMedia").validate({
            rules: {
                tag: {required:true}
            },
            messages: {
                tag: { required:"Digite uma tag."}
            },
            submitHandler: function(form) {
              $(form).submit();
            }
        })
});