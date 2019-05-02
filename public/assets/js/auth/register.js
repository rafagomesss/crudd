$(document).ready(function(){
     $("#formAuthRegister").validate({
        errorClass: "is-invalid small text-danger",
        validClass: "is-valid",
        rules: {
            name: "required",
            email: {
                required: true,
                email: true,
                minlength: 7
            },
            password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            email: {
                required: 'Precisamos que informe um e-mail para efetuar o acesso',
                email: 'E-mail informado possui formato inválido. Exemplo de um formato válido: nome@dominio.com',
                minlength: 'E-mail deve conter no mínimo 7 caracteres'
            },
            password : {
                required : 'A senha é uma informação obrigatória',
                minlength: 'A senha deve conter no mínimo 8 caracteres'
            }
        }
    });
    $('#btnFormAuthRegister').on('click', function(){
        const form = $('#formAuthRegister');
        const data = form.serializeArray();
        let validator = form.validate();
        if(validator) {
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
