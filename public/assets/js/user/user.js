$(document).ready(function() {
	$("#formUserAccess, #formUserEdit").validate({
		errorClass: "is-invalid small text-danger",
		validClass: "is-valid",
		rules: {
			access_level_id : "required",
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
				required: 'Campo nível de acesso é obrigatório!',
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
		Swal.fire({
            title: 'Deseja excluir esse usuário?',
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
					url: '/user/delete',
					type: 'POST',
					dataType: 'JSON',
					data: {id: $(this).data('user-delete')}
				}).done(function(data) {
					console.log(data)
					let message = data.message;
					let classes = 'success';
					let redirect = '/user/list';
					if (data.erro) {
						classes = 'warning';
						redirect = '';
						switch (data.code) {
							case '23000':
							message = 'Usuário com cadastro completo, não pode ser excluído!';
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
				let redirect = '/user/list';
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
