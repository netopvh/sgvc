/* ------------------------------------------------------------------------------
 *
 *  Configuração do Datatable do Usuário
 *
 * ---------------------------------------------------------------------------- */

$(function() {

    // Select2 select
    $('.select').select2({
        minimumResultsForSearch: Infinity
    });

    // Default initialization
    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });

});