$(document).ready(function() {
    $('#description').on('keyup', function() {
        let ucase = $(this).val().toUpperCase()
        $(this).val(ucase);
    });
});