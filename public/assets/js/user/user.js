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