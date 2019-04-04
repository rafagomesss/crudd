$(document).ready(function() {
	$('#modal-alert').on('shown.bs.modal', function(e){
		$('#btnModalAlert').focus();
	});
	$('#modal-alert').on('hidden.bs.modal', function () {
		window.location.href = $('#redirect').val();
	});
});

function configModalAlert(modal, message, classes, redirect = '')
{
	const titleContent = {
		'danger' : 'Erro!',
		'warning' : 'Atenção!',
		'success' : 'Sucesso!'
	};

	$(modal.concat(' .modal-border')).addClass('border-'.concat(classes));
	$(modal).modal('show');
	$(modal.concat(' .modal-title')).addClass('text-'.concat(classes)).html(titleContent[classes]);
	$(modal.concat(' .modal-body .col.content')).html(message);
	$(modal.concat(' #redirect')).val(redirect);
	$(modal.concat(' #btnModalAlert')).addClass('btn-'.concat(classes)).focus();
}

function validarFormulario(form)
{
	console.log($(form))
}