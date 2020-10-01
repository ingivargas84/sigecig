
$( document ).ready(function() {
    jQuery.validator.addMethod("greaterThan", function(value, element, params) {
        if ($(params[0]).val() != '') {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) >= new Date($(params[0]).val());
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        };
        return true;
    },'Must be greater than {1}.');

    var validator = $("#form-colegiados-por-anio").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            anio:{
                required: true,
                ntel: true
            },
        },
        messages: {
            anio: {
                required: "Elija fecha inicial",
                ntel: "El año debe contener 4 digitos"
            },

        },

    });
});

$.validator.addMethod("ntel", function (value, element ){
    var valor = value.length;
    if (valor == 4) {
        return true;
    } else {
        return false;
    }
}, "Debe ingresar el año con 4 dígitos");
