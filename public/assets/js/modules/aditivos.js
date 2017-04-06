$(function () {
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

    mensal.blur(function () {
        if(mensal.val() != ''){
            if (mensal.val() > total.val() && total.val() < mensal.val()){
                mensal.val('');
                bootbox.alert("O Valor MENSAL deve ser menor que o TOTAL!");
            }
        }
    });

    var inicio = $('#inicio');
    var fim = $('#encerramento');
    //console.log(dtInicio);

    fim.blur(function () {
        if(inicio.val() != '' || fim.val() != ''){
            var dtInicio = parseInt(inicio.val().split("/")[2].toString() + inicio.val().split("/")[1].toString() + inicio.val().split("/")[0].toString());
            var dtFim = parseInt(fim.val().split("/")[2].toString() + fim.val().split("/")[1].toString() + fim.val().split("/")[0].toString());
            if (dtFim < dtInicio){
                fim.val('');
                bootbox.alert("A Data de Fim do Contrato deve ser maior que o Inicio de Contrato!");
            }
        }else{
            bootbox.alert("Campo Fim do Contrato é Obrigatório!");
        }
    });
});