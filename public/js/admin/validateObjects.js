$(document).ready(function() {        
        $("#frmCreateObject").validate({
            rules: {
                title: {required:true},
                taxonomia: {required:true},
                collection_id: {required:true},
                country_id: {required:true},
                fase: {required:true},
                typeobject_id: {required:true},
                supplier_id: {required:true},
                crono_date: {required:true},
                ini_date: {required:true},
                arq_aberto: {required:true},
                interatividade: {required:true},
                format_id:{required:true},
                reaproveitamento:{required:true},
            },
            messages: {
                title: { required:'Campo não pode ser vazio'},
                taxonomia: { required:'Campo não pode ser vazio'},
                collection_id: { required:'Selecione uma opção'},
                country_id: { required:'Selecione uma opção'},
                fase: { required:'Selecione uma opção'},
                typeobject_id: { required:'Selecione uma opção'},
                supplier_id: { required:'Selecione uma opção'},
                crono_date: { required:'Campo não pode ser vazio'},
                ini_date: { required:'Campo não pode ser vazio'},
                arq_aberto: { required:'Selecione uma opção'},
                interatividade: { required:'Selecione uma opção'},
                format_id:{ required:'Selecione uma opção'},
                reaproveitamento:{ required:'Selecione uma opção'},
            },
            submitHandler: function(form) {
                $('input[type=submit]').attr('disabled', 'disabled');  
                $(form).submit();
            }
        })
});
