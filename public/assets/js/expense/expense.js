$(document).ready(function() {
    $('.btnExpenseDelete').on('click', function() {
        $.ajax({
            url: '/expense/delete',
            type: 'POST',
            dataType: 'JSON',
            data: {id: $(this).data('expense-delete')}
        }).done(function(data) {
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
                    message = data.message;
                    break;
                }
            }
            configModalAlert(message, classes, redirect);
        }).fail(function() {
            configModalAlert('Ocorreu um erro ao salvar o registro!', 'error');
        });
    });

    $('#btnFormExpenseEdit').on('click', function() {
        const form = $("#formExpenseEdit");
        let validator = form.validate();
        if (validator.form()) {
            const data = form.serializeArray();
            $.ajax({
                url: '/expense/update',
                type: 'POST',
                dataType: 'JSON',
                data: data
            }).done(function(data) {
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
                        message = data.message;
                        break;
                    }
                }
                configModalAlert(message, classes, redirect);
            }).fail(function() {
                configModalAlert('Ocorreu um erro ao atualizar o registro!', 'error');
            });
        }
    });
});