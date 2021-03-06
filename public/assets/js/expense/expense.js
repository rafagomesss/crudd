$(document).ready(function() {
    $('#value').mask("00 000.00", {reverse: true});
    $('.btnExpenseDelete').on('click', function() {
        Swal.fire({
            title: 'Deseja excluir essa despesa?',
            text: '* Essa operação não pode ser desfeita!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#30D6A1',
            cancelButtonColor: '#EF4747',
            confirmButtonText: 'Sim, excluir!',
            customClass: {
                content: 'font-size-sm text-danger font-weight-bold',
            }
        }).then((result) => {
            if (result.value) {
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
            }
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
            }).fail(function(data) {
                console.log(data)
                configModalAlert('Ocorreu um erro ao atualizar o registro!', 'error');
            });
        }
    });
});