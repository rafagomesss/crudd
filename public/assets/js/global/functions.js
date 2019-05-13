$(document).ready(function() {
	$('#btnEnterSystem').tooltip();
	$.validator.methods.email = function( value, element ) {
		return this.optional( element ) || /[a-z]+@[a-z]+\.[a-z]+/.test( value );
	}
	$('#modal-alert').on('shown.bs.modal', function(e){
		$('#btnModalAlert').focus();
	});
	$('#modal-alert').on('hidden.bs.modal', function () {
		window.location.href = $('#redirect').val();
	});
});

function configModalAlert(message, classes, redirect = '')
{
	const titleContent = {
		'error' : 'Erro!',
		'warning' : 'Atenção!',
		'success' : 'Sucesso!',
		'info' : 'Informação!',
		'question' : 'Questionamento'
	};

	Swal.fire({
		title: titleContent[classes],
		text: message,
		type: classes,
		position: "center",
	})
	.then((value) => {
		window.location.href = redirect;
	});
}

function validarFormulario(form)
{
	console.log($(form))
}
