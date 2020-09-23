
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

    var validator = $("#form-vetas-xyz").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            fechaInicialVenta:{
                required: true
                
            },
            fechaFinalVenta:{
                required: true,
                greaterThan: ["#fechaInicialVenta","fechaFinalVenta"]
            },
        },
        messages: {
            fechaInicialVenta: {
                required: "Elija fecha inicial"
            },
            fechaFinalVenta: {
                required: "Elija fecha final",
                greaterThan: "Fecha final no puede ser menor a la fecha inicial"
               
            },
        
        },
    
    });
    });


    
    