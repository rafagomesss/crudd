$(document).ready(function(){
    $('#birthdate').datepicker();
    $('#birthdate').datepicker('option',{
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
       
    });
    $( '#birthdate' ).datepicker( $.datepicker.regional[ "pt-BR" ] );
    $('#cpf').mask('000.000.000-00');
    $('#cellphone').mask('(00) 0 0000-0000');
    $("#formAuthRegister").validate({
        errorClass: "is-invalid small text-danger",
        validClass: "is-valid",
        groups: {
            username: "gender"
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "gender") {
                error.insertAfter(".genderF");
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            cpf: {
                required: true,
                minlength: 13,
                maxlength: 14
            },
            email: {
                required: true,
                email: true,
                minlength: 7
            },
            password: {
                required: true,
                minlength: 8
            },
            confirmPassword: {
                required: true,
                minlength: 8,
                equalTo: '#password'
            },
            cellphone: {
                required: true,
                minlength: 15
            },
            address: "required",
            address_num: {
                required: true,
                maxlength: 4
            },
            gender: "required"
        },
        messages: {
            name: {
                required: "O campo nome é obrigatório!",
                minlength: "O nome deve conter no mínimo 3 letras"
            },
            cpf: {
                required: "O campo cpf é obrigatório!",
                minlength: "O cpf deve conter no mínimo 11 dígitos"
            },
            email: {
                required: 'Precisamos que informe um e-mail para efetuar o acesso',
                email: 'E-mail informado possui formato inválido. Exemplo de um formato válido: nome@dominio.com',
                minlength: 'E-mail deve conter no mínimo 7 caracteres'
            },
            password : {
                required : 'O campo senha é campo obrigatório',
                minlength: 'A senha deve conter no mínimo 8 caracteres'
            },
            confirmPassword : {
                required : 'O campo confirmar senha é campo obrigatório',
                minlength: 'A senha deve conter no mínimo 8 caracteres',
                equalTo: 'A senha não confere'
            },
            cellphone: {
                required: "O campo celular é um campo obrigatório",
                minlength: "Número inválido!"
            },
            address: {
                required: "O campo endereço é um campo obrigatório",
            },
            address_num: {
                required: "O campo N.º do endereço é um campo obrigatório",
                maxlength: "O campo permite inserir apenas 4 dígitos"
            },
            gender: {
                required:"O campo gênero é um campo obrigatório"
            }
        }
    });
    $('#btnFormAuthRegister').on('click', function(){
        const form = $('#formAuthRegister');
        const data = form.serializeArray();
        let validator = form.validate();
        if(validator.form()) {
            $.ajax({
                url: '/auth/register',
                type: 'POST',
                dataType: 'JSON',
                data: data,
            }).done(function(data) {
                console.log(data)
                if (parseInt(data.user_access_id) > 0 && parseInt(data.user_id) > 0) {

                }
                let message = 'Registro salvo com sucesso!';
                let classes = 'success';
                let modal = '#modal-alert';
                let redirect = '/auth';
                if (data.erro) {
                    classes = 'warning';
                    redirect = '';
                    switch (data.code) {
                        case '23000':
                        message = 'O e-mail informado já existe!';
                        break;
                        default:
                        message = 'Ocorreu um erro ao salvar o registro';
                        break;
                    }
                }
                configModalAlert(modal, message, classes, redirect);
            }).fail(function(data) {
                console.log(data.responseText)
                configModalAlert('#modal-alert', 'Ocorreu um erro ao salvar o registro!', 'danger');
            });
        }
    });
});
