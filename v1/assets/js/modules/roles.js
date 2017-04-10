/* ------------------------------------------------------------------------------
 *
 *  Configuração do Datatable do Usuário
 *
 * ---------------------------------------------------------------------------- */

var associated = $("select[name='associated-permissions']");
var associated_container = $("#available-permissions");

if (associated.val() == "custom")
    associated_container.removeClass('hidden');
else
    associated_container.addClass('hidden');

associated.change(function() {
    if ($(this).val() == "custom")
        associated_container.removeClass('hidden');
    else
        associated_container.addClass('hidden');
});


$(function() {

    $("#form_create").validate({
        rules: {
            name: "http://jqueryvalidation.org/"
        },
        messages: {
            name: {
                required: "O Campo nome é obrigatório"
            }
        }
    });


// Select2 select
    $('.select').select2({
        minimumResultsForSearch: Infinity
    });


});