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
              $(form).submit();
            }
        })
});

/*
$( "#data_lancamento" ).datepicker({ 
            dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            dayNamesMin: ["Do", "Sg", "Te", "Qa", "Qi", "Sx", "Sa"],
            dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            monthNamesShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
            nextText:'&raquo;',
            prevText:'&laquo;',
            dateFormat: "dd/mm/YY"  
        });
        $('#btSlctObjtPai').click(function(){
            var NewDialog = $('<div id="MenuDialog">'+
                '<p><b>Filtro</b></p>'+
                '<p><label for="pop_pais">País:</label><br/><select id="pop_pais" style="width:280px;" onchange="pop_load_colecao()"><option value="">Aguarde...</option></select></p>'+
                '<p><label for="pop_colecao">Coleção:</label><br/><select id="pop_colecao" style="width:280px;" onchange="pop_load_ano()"><option value="">Aguarde...</option></select></p>'+
                '<p><label for="pop_ano">Ano:</label><br/><select id="pop_ano" style="width:280px;" onchange="pop_load_objeto()"><option value="">Aguarde...</option></select></p>'+
                '<p><label for="pop_objeto">Objeto:</label><br/><select id="pop_objeto" style="width:280px;"><option value="">Aguarde...</option></select></p>'+
            '</div>');
            NewDialog.dialog({
                modal: true, show: 'clip', hide: 'clip', resizable:false,
                title: "Selecionar reaproveitamento",
                open: function( event, ui ) {
                    pop_load_pais();
                },
                close: function( event, ui ){
                    $('.ui-dialog, #MenuDialog').remove();
                },
                buttons: [
                    {text: "Cancelar", click: function() {$(this).dialog("close")}},
                    {text: "Adicionar", click: function() {
                        if($('#pop_objeto').val()!=''){
                            var pop_objeto = document.getElementById('pop_objeto');
                            $('#objectpai_id').val(pop_objeto[pop_objeto.selectedIndex].value);
                            $('#objectpai_txt').html(pop_objeto[pop_objeto.selectedIndex].text);
                            $(this).dialog("close");
                        }else{
                            $.jGrowl('Selecione um objeto para adicionar!',{ position:'bottom-right', sticky: true } );
                        }
                    }}
                ]
            });
            return false;
        });
        $('#btRmvObjtPai').click(function(){
            $('#objectpai_id').val('');
            $('#objectpai_txt').html('');
            return false;
        });
*/
