$(document).ready(function(){
    $('#btnFormAuthRegister').on('click', function(){
        const form = $('#formAuthRegister');
        const data = form.serializeArray();
        $.ajax({
            url: '/auth/register',
            type: 'POST',
            dataType: 'JSON',
            data: data,
        }).done(function(data) {
            console.log(data)
            let message = data.message;
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
    });
});
