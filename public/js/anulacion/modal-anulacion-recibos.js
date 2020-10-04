
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

    var validator = $("#form-anulacion-recibos").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            recibo:{
                required: true
            },
        },
        messages: {
            recibo: {
                required: "Escriba el número de Recibo"
            },
        },
    });
});

function llamada (){
    var id = $('#recibo').val();
    document.getElementById('btn-anulacion').setAttribute('href','/detalleRecibo/'+id);
}

