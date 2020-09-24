
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

    var validator = $("#form-reporte-envios").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            fechaInicialEnvio:{
                required: true
                
            },
            fechaFinalEnvio:{
                required: true,
                greaterThan: ["#fechaInicialEnvio","fechaFinalEnvio"]
            },
        },
        messages: {
            fechaInicialEnvio: {
                required: "Elija fecha inicial"
            },
            fechaFinalEnvio: {
                required: "Elija fecha final",
                greaterThan: "Fecha final no puede ser menor a la fecha inicial"
               
            },
        
        },
    
    });
    });


    
    