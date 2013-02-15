$(document).ready(function() {
        $( "#crono_date" ).datepicker({ 
            dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            dayNamesMin: ["Do", "Sg", "Te", "Qa", "Qi", "Sx", "Sa"],
            dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            monthNamesShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
            nextText:'&raquo;',
            prevText:'&laquo;',
            dateFormat: "dd/mm/yy"
        });
        $("#frmTask").validate({
            //debug: true,
            rules: {
                project_id: {required:true},
                title: {required:true},
                pasta: {required:true},
                task_to: {required:true},
                priority_id: {required:true},
                statu_id: {required:true},
                description: {required:true}
            },
            messages: {
                project_id: { required:"Escolha o projeto da tarefa."},
                title: { required: "Digite o título da tarefa." },
                pasta: {required:"Digite ocaminho da pasta da tarefa."},
                task_to: {required:"Escolha o usuário responsável da tarefa."},
                priority_id: {required:"Escolha a prioridade da tarefa."},
                statu_id: {required:"Escolha o status da tarefa."},
                description: {required:"Digite uma descrição para a tarefa."}
            },
            submitHandler: function(form) {
				checkUpload(form);
            }
        })
});