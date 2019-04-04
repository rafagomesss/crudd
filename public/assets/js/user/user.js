$('.btnUserDelete').on('click', function() {
	$.ajax({
		url: '/user/delete',
		type: 'POST',
		dataType: 'JSON',
		data: {id: $(this).data('user-delete')}
	}).done(function(data) {
		console.log(data)
		let message = data.message;
		if (data.erro) {
			switch (data.code) {
				case '23000':
					message = 'O e-mail informado já existe!';
				break;
				case 1:
					message = 'sssss!';
				break;
				default:
					message = data.message;
				break;
			}
			alert(message);
		} else {
			alert(message);
			window.location.href = '/user/list';
		}
	}).fail(function() {
		console.log("error");
	});
});