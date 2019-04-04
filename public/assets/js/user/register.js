$(document).ready(function() {
	$('#btnFormUserAccess').on('click', function() {
		const data = $('#formUserAccess').serializeArray();
		$.ajax({
			url: '/user/insert',
			type: 'POST',
			dataType: 'JSON',
			data: data,
		}).done(function(data) {
			if (data.erro) {
				let message = '';
				switch (data.code) {
					case '23000':
						message = 'O e-mail informado já existe!';
						break;
					default:
						message = 'Ocorreu um erro ao salvar o registro';
						break;
				}
				alert(message);
			} else {
				alert('Registro salvo com sucesso!');
				window.location.href = '/home';
			}
		}).fail(function() {
			console.log("error");
		});
	});
});
