$(document).ready(function() {
	$("#formUserAccess, #formUserEdit").validate({
		errorClass: "is-invalid small text-danger",
		validClass: "is-valid",
		rules: {
			access_level : "required",
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
			access_level : {
				required: 'Campo nível de acesso é obrigatórió!',
			},
			email: {
				required: 'Precisamos que informe um e-mail para efetuar o registro',
				email: 'E-mail informado possui formato inválido. Exemplo de um formato válido: nome@dominio.com',
				minlength: 'E-mail deve conter no mínimo 7 caracteres'
			},
			password : {
				required : 'A senha é uma informação obrigatória',
				minlength: 'A senha deve conter no mínimo 8 caracteres'
			}
		}
	});
	$('.btnUserDelete').on('click', function() {
		$.ajax({
			url: '/user/delete',
			type: 'POST',
			dataType: 'JSON',
			data: {id: $(this).data('user-delete')}
		}).done(function(data) {
			let message = data.message;
			let classes = 'success';
			let modal = '#modal-alert';
			let redirect = '/user/list';
			if (data.erro) {
				classes = 'danger';
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
			configModalAlert(modal, message, classes, redirect);
		}).fail(function() {
			configModalAlert('#modal-alert', 'Ocorreu um erro ao salvar o registro!', 'danger');
		});
	});

	$('#btnFormUserEdit').on('click', function() {
		const form = $("#formUserEdit");
		let validator = form.validate();
		if (validator.form()) {
			const data = form.serializeArray();
			$.ajax({
				url: '/user/update',
				type: 'POST',
				dataType: 'JSON',
				data: data
			}).done(function(data) {
				let message = data.message;
				let classes = 'success';
				let modal = '#modal-alert';
				let redirect = '/user/list';
				if (data.erro) {
					classes = 'danger';
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
				configModalAlert(modal, message, classes, redirect);
			}).fail(function() {
				configModalAlert('#modal-alert', 'Ocorreu um erro ao atualizar o registro!', 'danger');
			});
		}
	});
});
