$(document).ready(function() {
        $( "#data_lancamento" ).datepicker({ 
            dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            dayNamesMin: ["Do", "Sg", "Te", "Qa", "Qi", "Sx", "Sa"],
            dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            monthNamesShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
            nextText:'&raquo;',
            prevText:'&laquo;',
            dateFormat: "dd/mm/yy"
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
        $("#frmCreateObject").validate({
            rules: {
                nome_obj: {required:true},
                nome_arq: {required:true},
                typeobject_id: {required:true},
                colecao: {required:true},
                segmento_id: {required:true},
                arq_aberto: {required:true},
                extensao_arq: {required:true},
                interatividade: {required:true},
                empresa: {required:true},
                country_id: {required:true}
            },
            messages: {
                nome_obj: { required:'Campo não pode ser vazio'},
                nome_arq: { required:'Campo não pode ser vazio'},
                typeobject_id: { required:'Campo não pode ser vazio'},
                colecao: { required:'Campo não pode ser vazio'},
                segmento_id: { required:'Campo não pode ser vazio'},
                arq_aberto: { required:'Campo não pode ser vazio'},
                extensao_arq: { required:'Campo não pode ser vazio'},
                interatividade: { required:'Campo não pode ser vazio'},
                empresa: { required:'Campo não pode ser vazio'},
                country_id: { required:'Campo não pode ser vazio'}
            },
            submitHandler: function(form) {
              $(form).submit();
            }
        })
});

