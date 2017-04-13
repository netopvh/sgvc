$(function () {

    //Custon validation
    var validator = $(".form-validate").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        rules: {
            ano: {
                required: true,
                number:true
            },
            arquivo: {
                extension: "pdf"
            }
        },
        messages: {
            ano : {
                required: "Obrigatório",
                number: "Apenas Números"
            },
            total: {
                required: "Obrigatório"
            },
            arquivo: {
                extension: "Permitido apenas arquivos no formato PDF"
            },
            inicio: {
                required: "Obrigatório"
            },
            encerramento: {
                required: "Obrigatório"
            }
        }

    });

    var button = $('#button');
    var form = $('#formAditivo');
    form.submit(function () {
        if (validator.numberOfInvalids() < 1){
            button.prop('disabled', true);
        }
    });


    // The date picker (read the docs)
    $('.datepicker').pickadate({
        monthsFull: ['Janeiro', 'Feveiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        format: 'dd/mm/yyyy',
        editable: true,
        today: '',
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
            if (dtFim < dtInicio){
                fim.val('');
                bootbox.alert("A Data de Fim do Contrato deve ser maior que o Inicio de Contrato!");
            }
        }else{
            bootbox.alert("Campo Fim do Contrato é Obrigatório!");
        }
    });

});