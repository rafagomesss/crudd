$(document).ready(function() {
    $('#value').mask("#.##0,00", {reverse: true});
    $("#formRegisterExpense").validate({
        errorClass: "is-invalid small text-danger",
        validClass: "is-valid",
        rules: {
            category_id: "required",
            description: {
                required: true,
                minlength: 3
            },
            value: "required",
        },
        messages: {
            category_id : {
                required: 'Selecione uma categoria!',
            },
            description: {
                required: 'O campo descrição é obrigatório!',
                minlength: 'A descrição deve conter no mínimo 3 caracteres'
            },
            value : {
                required : 'O valor é um campo obrigatório',
            }
        }
    });
    $('#btnFormRegisterExpense').on('click', function() {
        const form = $("#formRegisterExpense");
        let validator = form.validate();
        if (validator.form()) {
            const data = form.serializeArray();
            $.ajax({
                url: '/expense/insert',
                type: 'POST',
                dataType: 'JSON',
                data: data,
            }).done(function(data) {
                console.log(data)
                let message = data.message;
                let classes = 'success';
                let redirect = '/expense/list';
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
                configModalAlert(message, classes, redirect);
            }).fail(function(data) {
                console.log(data.responseText)
                configModalAlert('Ocorreu um erro ao salvar o registro!', 'error');
            });
        }
    });
});