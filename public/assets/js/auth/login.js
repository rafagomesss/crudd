$(document).ready(function() {
    $('#btnFormAuthLogin').on('click', function(){
        const form = $('#formAuthLogin');
        const data = form.serializeArray();
        $.ajax({
            url: '/auth/validateLogin',
            type: 'POST',
            dataType: 'JSON',
            data: data,
        }).done(function(data) {
            console.log(data)
            let message = data.message;
            let classes = 'success';
            let modal = '#modal-alert';
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
                configModalAlert(modal, message, classes, redirect);
                return false;
            }
            window.location.href = data.redirect;
        }).fail(function(data) {
            console.log(data.responseText)
            configModalAlert('#modal-alert', 'Ocorreu um erro ao salvar o registro!', 'danger');
        });
    });
});
