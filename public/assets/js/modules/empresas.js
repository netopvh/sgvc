function upper(name){
    $(name).bind('keyup', function (e) {
        if (e.which >= 97 && e.which <= 122) {
            var newKey = e.which - 32;
            // I have tried setting those
            e.keyCode = newKey;
            e.charCode = newKey;
        }

        return $(name).val(($(name).val()).toUpperCase());
    });
}

$(function () {

    var razao = $('#razao');
    var fantasia = $('#fantasia');

    $('.upper').bind('keyup',function (e) {
        razao.val((razao.val()).toUpperCase());
        fantasia.val((fantasia.val()).toUpperCase());
    });


    //Faz a verificação e realiza a mascara na leitura do documento
    var tipo = $('#tipo');
    var cnpj = $('#cnpj');

    if(tipo.val() == 'PJ'){
        $(cnpj).inputmask("99.999.999/9999-99", {
            removeMaskOnSubmit: true
        });
    }else if(tipo.val() == 'PF'){
        $(cnpj).inputmask("999.999.999-99", {
            removeMaskOnSubmit: true
        });
    }

    //Muda de acordo com a ação
    $(tipo).change(function () {

        if(tipo.val() == 'PJ'){
            $(cnpj).inputmask("99.999.999/9999-99", {
                removeMaskOnSubmit: true
            });
        }else if(tipo.val() == 'PF'){
            $(cnpj).inputmask("999.999.999-99", {
                removeMaskOnSubmit: true
            });
        }else{
            $(cnpj).inputmask('remove');
        }
    });

    // Select2 select
    $('.select').select2({
        minimumResultsForSearch: Infinity
    });
});
