$(function () {

    var name = $("#name");

    $(name).bind('keyup', function (e) {
        if (e.which >= 97 && e.which <= 122) {
            var newKey = e.which - 32;
            // I have tried setting those
            e.keyCode = newKey;
            e.charCode = newKey;
        }

        $(name).val(($(name).val()).toUpperCase());
    });


    $(document).keydown(function (e) {
        if(e.which == 113)
        {
            document.location.href = window.location.href + '/create'
        }
    });
});