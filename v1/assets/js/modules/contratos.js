$(function() {

    $('#send').click(function () {
        $("#print").print({
            globalStyles: true,
            mediaPrint: false,
            stylesheet: null,
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 250,
            title: "Gestão de Contratos",
            doctype: '<!doctype html>'
        });
    });


    var url = window.location.protocol + '//' + window.location.host + '/';

    //DEFINE O TIPO DE CONTRATO A SER CADASTRADO
    var tipo = $('#tipo');

    $(tipo).change(function () {
        if (tipo.val() == 'N'){
            document.location.href = window.location.href + '/normal'
        }else if(tipo.val() == 'C'){
            bootbox.alert('Módulo ainda em desenvolvimento');
        }else if(tipo.val() == 'P'){
            bootbox.alert('Módulo ainda em desenvolvimento');
        }
    });

    //PREENCHE DADOS DE ACORDO COM A CASA
    $("select[name=casa_id]").change(function () {
        var casa_id = $(this).val();
        if (casa_id){
            $.get(url + 'units/' + casa_id, function (unidades) {
                if (unidades.length == 0){
                    $("select[name=unidade_id]").empty();
                    $('.select').select2("val","");
                }else{
                    $("select[name=unidade_id]").empty();
                    $("select[name=unidade_id]").append('<option value="" selected></option>');
                    $.each(unidades, function (key, value) {
                        $("select[name=unidade_id]").append('<option value=' + key + '>' + value + '</option>');
                    });
                }
            });
        }else{
            $("select[name=unidade_id]").empty();
            $('.select').select2("val","");
        }
    });

    // ESTILIZA O SELECT
    $('.select').select2({
        allowClear: true,
        placeholder: "Selecione",
        minimumResultsForSearch: -1
    });

    // ESTILIZA O SELECT
    $('.select-multiple').select2();

    //Permite somente numeros
    $("#numbers").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))                    {
            return false;
        }
    });

    // The date picker (read the docs)
    $('.datepicker').pickadate({
        monthsFull: ['Janeiro', 'Feveiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        weekdaysShort: ['Sab', 'Dom', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        format: 'dd/mm/yyyy',
        today: 'Hoje',
        clear: 'Limpar',
        close: 'Fechar'
    });

    var total = $('#total');
    var mensal = $('#mensal');

    total.maskMoney();
    mensal.maskMoney();
    $("form").submit(function() {
        total.val(total.maskMoney('unmasked')[0]);
        mensal.val(mensal.maskMoney('unmasked')[0]);
    });

    var inicio = $('#inicio');
    var fim = $('#encerramento');
    //console.log(dtInicio);

    fim.blur(function () {
        if(inicio.val() != '' || fim.val() != ''){
            var dtInicio = parseInt(inicio.val().split("/")[2].toString() + inicio.val().split("/")[1].toString() + inicio.val().split("/")[0].toString());
            var dtFim = parseInt(fim.val().split("/")[2].toString() + fim.val().split("/")[1].toString() + fim.val().split("/")[0].toString());
            if (dtInicio > dtFim){
                fim.val('');
                bootbox.alert("A Data de Fim do Contrato deve ser maior que o Inicio de Contrato!");
            }
        }else{
            bootbox.alert("Campo Fim do Contrato é Obrigatório!");
        }
    });

});