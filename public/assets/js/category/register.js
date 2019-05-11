$(document).ready(function() {
    $("#formRegisterCategory").validate({
        errorClass: "is-invalid small text-danger",
        validClass: "is-valid",
        rules: {
            description: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
        },
        messages: {
            description: {
                required: 'O campo descrição é obrigatório!',
                minlength: 'A descrição deve conter no mínimo 3 caracteres',
                maxlength: 'A descrição deve conter no máximo 50 caracteres'
            },
        }
    });
    $('#btnFormRegisterCategory').on('click', function() {
        const form = $("#formRegisterCategory");
        let validator = form.validate();
        if (validator.form()) {
            const data = form.serializeArray();
            $.ajax({
                url: '/category/insert',
                type: 'POST',
                dataType: 'JSON',
                data: data,
            }).done(function(data) {
                console.log(data)
                let message = data.message;
                let classes = 'success';
                let redirect = '/category/list';
                if (data.erro) {
                    classes = 'warning';
                    redirect = '';
                    switch (data.code) {
                        case '23000':
                        message = 'A categoria informada já existe!';
                        break;
                        default:
                        message = 'Ocorreu um erro ao salvar o registro';
                        break;
                    }
                }
                configModalAlert(message, classes, redirect);
            }).fail(function(data) {
                console.log(data.responseText)
                configModalAlert('Ocorreu um erro ao salvar o registro!', 'error');
            });
        }
    });
});