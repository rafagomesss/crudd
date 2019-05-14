$(document).ready(function() {
    $('#formAuthLogin').keypress(function(event){
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode === 13){
            $('#btnFormAuthLogin').click();
        }
    });
    $("#formAuthLogin").validate({
        errorClass: "is-invalid small text-danger",
        validClass: "is-valid",
        rules: {
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
                required: 'Informe o e-mail para efetuar o acesso',
                email: 'E-mail informado possui formato inválido. Exemplo de um formato válido: nome@dominio.com',
                minlength: 'E-mail deve conter no mínimo 7 caracteres'
            },
            password : {
                required : 'A senha é uma informação obrigatória',
                minlength: 'A senha deve conter no mínimo 8 caracteres'
            }
        }
    });
    $('#btnFormAuthLogin').on('click', function(){
        const form = $('#formAuthLogin');
        const data = form.serializeArray();
        let validator = form.validate();
        if (validator.form()) {
            $.ajax({
                url: '/auth/validateLogin',
                type: 'POST',
                dataType: 'JSON',
                data: data,
            }).done(function(data) {
                console.log(data)
                let message = data.message;
                let classes = 'success';
                let redirect = data.redirect;
                if (data.erro) {
                    classes = 'warning';
                    switch (data.code) {
                        case '23000':
                            message = 'O e-mail informado já existe!';
                            break;
                        default:
                            message = data.message;
                            redirect = data.redirect;
                            break;
                    }
                    configModalAlert(message, classes, redirect);
                    return false;
                }
                window.location.href = redirect;
            }).fail(function(data) {
                console.log(data.responseText)
                configModalAlert('Ocorreu um erro ao salvar o registro!', 'error');
            });
        }
    });
});
