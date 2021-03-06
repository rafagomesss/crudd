$(document).ready(function() {
    $('#description').on('keyup', function() {
        let ucase = $(this).val().toUpperCase()
        $(this).val(ucase);
    });

    $('#btnFormEditCategory').on('click', function() {
        const form = $("#formEditCategory");
        let validator = form.validate();
        if (validator.form()) {
            const data = form.serializeArray();
            $.ajax({
                url: '/category/update',
                type: 'POST',
                dataType: 'JSON',
                data: data
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

    $('.btnCategoryDelete').on('click', function() {
        Swal.fire({
            title: 'Deseja excluir essa categoria?',
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
                    url: '/category/delete',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {id: $(this).data('category-delete')}
                }).done(function(data) {
                    let message = data.message;
                    let classes = 'success';
                    let redirect = '/category/list';
                    if (data.erro) {
                        classes = 'warning';
                        redirect = '';
                        switch (data.code) {
                            case '23000':
                            message = 'Há registros dependentes dessa categoria!';
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
});