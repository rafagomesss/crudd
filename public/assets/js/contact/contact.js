$(document).ready(function() {
    $('#telefone').mask('(00) 0 0000-0000');
    $('#mensagem_help').text('Caracteres restantes: 255');
    $('#mensagem').on('keyup', function(){
        const messageHelp = $('#mensagem_help');
        const maxlength = 255;
        let contador = maxlength - $(this).val().length;
        messageHelp.html('Caracteres restantes: ' .concat(contador));
        messageHelp.removeClass('text-danger');

        if (parseInt(contador) <= 0) {
            messageHelp.addClass('text-danger');
        }
    });

    $('#formContact').validate({
        errorClass: 'is-invalid small text-danger',
        validClass: 'is-valid',
        rules: {
            nome: {
                required: true,
                minlength: 2,
                maxlength: 200
            },
            email: {
                required: true,
                email: true,
                minlength: 7
            },
            telefone: {
                required: true,
                minlength: 15
            },
            mensagem: {
                required: true,
                minlength: 6,
                maxlength: 255
            }
        },
        messages: {
            nome: {
                required: 'O campo nome é obrigatório',
                minlength: 'O campo deve conter no mínimo 2 caracteres',
                maxlength: 'O campo não deve exceder o limite de 200 caracteres'
            },
            email: {
                required: 'O campo e-mail é obrigatório',
                email: 'O e-mail informado não é um e-mail válido',
                minlength: 'O campo e-mail deve ter no mínimo 7 caracteres'
            },
            telefone: {
                required: 'O campo contato é obrigatório',
                minlength: 'O campo telefone deve conter no mínimo 15 caracteres'
            },
            mensagem: {
                required: 'O campo mensagem é obrigatório',
                minlength: 'O campo mensagem deve ter no mínimo 6 caracteres',
                maxlength: 'O campo mensagem deve conter no máximo 255 caracteres'
            }
        }
    });

    $('#btnSubmitFormContact').on('click', function() {
        const form = $('#formContact');
        let validator = form.validate();
        if (validator.form()) {
            form.submit();
        }
    });
});