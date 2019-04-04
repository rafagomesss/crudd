$(document).ready(function() {
	$('#btnFormUserAccess').on('click', function() {
		const form = $("#formUserAccess");
		let validator = form.validate();
		if (validator.form()) {
			const data = form.serializeArray();
			$.ajax({
				url: '/user/insert',
				type: 'POST',
				dataType: 'JSON',
				data: data,
			}).done(function(data) {
				let message = data.message;
				let classes = 'success';
				let modal = '#modal-alert';
				let redirect = '/user/list';
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
			}).fail(function() {
				configModalAlert('#modal-alert', 'Ocorreu um erro ao salvar o registro!', 'danger');
			});
		}
	});
});


