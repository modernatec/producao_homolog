function validateAjax(){
    /*
    $('.date').live('focus', function () {
        $(this).not('.hasDatePicker').datepicker({dateFormat: 'dd/mm/yy'}).val();
    });
    */

    $("#frmCreateTask2").validate({
        rules: {
            task_to:{required:true},
            tag_id: {required:true},
            crono_date: {required:true},
            description: {required:{
                depends:function(){
                   CKupdate();
                   return true;
                }
            }},
        },
        messages: {
            description: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    })

    $("#frmAlteraStatus").validate({
        rules: {
            status_id: {required:true},
            prova: {required:true},
            crono_date: {required:true},
        },
        messages: {
            status_id: { required:'Selecione uma opção'},
            prova: { required:'Selecione uma opção'},
            crono_date: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    })


    $("#frmStatus2").validate({
        rules: {
            status_id: {required:true},
            prova: {required:true},
            crono_date: {required:true},
        },
        messages: {
            status_id: { required:'Selecione uma opção'},
            prova: { required:'Selecione uma opção'},
            crono_date: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    })

    $("#frmSupplier").validate({
        rules: {
            empresa:{required:true},
        },
        messages: {
            empresa: { required:"Digite o nome da empresa."},
           
        },
        submitHandler: function(form) {
            $('.sortable_creditos').each(function(index, element){ 
                var fill = $(element).data('fill');
                if(fill != undefined){
                    var data = $(element).sortable('serialize');
                    $('#' + fill).attr('value', data);
                }
            });  

            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    })

    /*
    if($('#frmSupplier').length != 0){
        $("[name^=nome]").each(function () {
            $(this).rules("add", {
                required: true
            });
        });
    }
    */
    
    $("#frmContato").validate({
        rules: {
            nome:{required:true},
        },
        messages: {
            nome: { required:"Digite o nome do contato."},
           
        },
        submitHandler: function(form) {


            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    })
    

    
    /*
    $("#frmAnotacoes").validate({
        rules: {
            anotacoes: {required:true},
        },
        messages: {
            anotacoes: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });
    */

    $("#frmAnotacoes_edit").validate({
        rules: {
            anotacao: {required:{
                depends:function(){
                   CKupdate();
                   return true;
                }
            }},
        },
        messages: {
            anotacao: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');            
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    /*
    $("#startTask").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });
    */

    $("#frmEditTask").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#frmCreateTable").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"), false);
            return false;       
        }
    });

    $("#frmCreateTable_mesa").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"), false);
            return false;       
        }
    });

    $("#frmEditTable").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });
    

    $("#frmCreateSegmento").validate({
        rules: {
            nome: {required:true}
        },
        messages: {
            nome: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })

    $("#frmCreateCollection").validate({
        rules: {
            name: {required:true},
            materia_id: {required:true},
            project_id: {required:true},
            segmento_id: {required:true},
            ano: {required:true},
            fechamento: {required:true},
        },
        /*
        messages: {
            name: { required:'Campo não pode ser vazio'},
            materia_id: {required:'Campo não pode ser vazio'},
            segmento_id: {required:'Campo não pode ser vazio'},
            ano: {required:'Campo não pode ser vazio'},
            fechamento: {required:'Campo não pode ser vazio'},
        },
        */
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })

    $("#frmCreateMaterias").validate({
        rules: {
            name: {required:true}
        },
        messages: {
            name: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })

    $("#frmCreateService").validate({
        rules: {
            name: {required:true}
        },
        messages: {
            name: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })

    

    $("#frmCreateFeriados").validate({
        rules: {
            feriado: {required:true}
        },
        messages: {
            name: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })    

    $("#frmCreateRepo").validate({
        rules: {
            name: {required:true}
        },
        messages: {
            name: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })

    $("#frmCreateWorkflow").validate({
        rules: {
            name: {required:true}
        },
        messages: {
            name: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('.sortable_workflow, .sortable_status_workflow').each(function(index, element){ 
                var fill = $(element).data('fill');
                if(fill != undefined){
                    var data = $(element).sortable('serialize');
                    $('#' + fill).attr('value', data);
                }
            });  

            
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            
            return false;    
        }
    })

    $("#frmCreatePais").validate({
        rules: {
            name: {required:true}
        },
        messages: {
            name: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })

    $("#frmCreateTipoObj").validate({
        rules: {
            name: {required:true}
        },
        messages: {
            name: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })


    $("#frmCreateSfwprod").validate({
        rules: {
            name: {required:true}
        },
        messages: {
            name: { required:'Campo não pode ser vazio'}
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    })

    $("#frmCreateProject").validate({
        rules: {
            name: {required:true},
            target: {required:true}
        },
        messages: {
            name: { required:"Digite o nome do projeto."},
            target: { required: "Digite o seguimento do projeto." },
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;    
        }
    });

    
    $("#sync_gdocs").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });
    

    $("#formEndTask").validate({
        rules: {
            description: {required:{
                depends:function(){
                   CKupdate();
                   return true;
                }
            }},
        },
        messages: {
            description: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#frmTeam").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#frm_oeds").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#frm_reset_oeds").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#filter_projects").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#reset_filter_projects").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#frm_acervo").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#frm_reset_acervo").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#frm_reset_suppliers").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    

    $("#frm_listContatos").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"), false);
            return false;       
        }
    });

    $("#frm_reset_listContatos").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"), false);
            return false;       
        }
    });

    $("#frm_reset_contatos").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"), false);
            return false;       
        }
    });

    $("#frm_listSuppliers").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"), false);
            return false;       
        }
    });

    $("#frm_reset_listSuppliers").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"), false);
            return false;       
        }
    });

    

    

    $("#frm_suppliers").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    $("#frm_usuarios").validate({
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    });

    
    

    

    $("#frmCusto2").validate({
        rules: {
            team_id: {required:true},
            supplier_id: {required:true},
            valor: {required:true},
        },
        messages: {
            team_id: { required:'Campo não pode ser vazio'},
            supplier_id: { required:'Campo não pode ser vazio'},
            valor: { required:'Campo não pode ser vazio'},
        },
        submitHandler: function(form) {
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false;       
        }
    })   


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
            $('.sortable_workflow, .sortable_produtoras').each(function(index, element){ 
                var fill = $(element).data('fill');
                if(fill != undefined){
                    var data = $(element).sortable('serialize');
                    $('#' + fill).attr('value', data);
                }
            });  
            
            $('input[type=submit]').attr('disabled', 'disabled');
            ajaxPost(form, $(form).data("panel"));
            return false; 
            
        }
    })   

     $("#frmCreateUsers").validate({            
            ignore: ".ignore",
            rules: {
                username: {required:true},
                password: {required:true},
                password_confirm: {
                    required:true,
                    equalTo: "#password"
                },
                role: {required:true},
                team: {required:true},
                nome: {required:true}
                /*,
                email: {
                    required:true,
                    email:true
                }*/
            },
            messages: {
                username: { required:"Digite o username."},
                password: { required: "Digite a senha." },
                password_confirm: {
                    required:"Confirme a senha.",
                    equalTo:"As senhas não conhecidem."
                },
                role: {required:"Escolha uma permissão"},
                team: {required:"Escolha uma equipe"},
                nome: {required:"Digite o nome."}
                /*,
                email: {
                    required:"Digite o e-mail.",
                    email:"Digite um e-mail válido."
                }*/
            },
            submitHandler: function(form){
                $('input[type=submit]').attr('disabled', 'disabled');
                ajaxPost(form, $(form).data("panel"));
                return false; 
            }
        })   
    
    $("#frmEditUsers").validate({            
        ignore: ".ignore",
        rules: {
            nome: {required:true},
            email: {
                required:true,
                email:true
            }
        },
        messages: {
            nome: {required:"Digite o nome."},
            email: {
                required:"Digite o e-mail.",
                email:"Digite um e-mail válido."
            }
        },
        submitHandler: function(form){
            $('input[type=submit]').attr('disabled', 'disabled');
            checkUpload(form, $(form).data("panel"));
            return false; 
        }
    });

    $("#frmEditPass").validate({            
            ignore: ".ignore",
            rules: {
                username: {required:true},
                password: {required:true},
                password_confirm: {
                    required:true,
                    equalTo: "#password"
                },
                
            },
            messages: {
                username: { required:"Digite o username."},
                password: { required: "Digite a senha." },
                password_confirm: {
                    required:"Confirme a senha.",
                    equalTo:"As senhas não conhecidem."
                },
            },
            submitHandler: function(form){
                $('input[type=submit]').attr('disabled', 'disabled');
                ajaxPost(form, $(form).data("panel"));
            }
        })   

            
}

