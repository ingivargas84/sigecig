
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

    var validator = $("#form-rango").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            c_cliente:{
                required: true,
  
            },
            c_cliente1:{
                required: true,
                menorQue: true,
            },
        },
        messages: {
            c_cliente: {
                required: "Ingrese numero de colegiado",
            },
            c_cliente1: {
                required: "Ingrese numero de colegiado"
            },
        },
    });

    $.validator.addMethod("menorQue", function(value, element){
        if(
            (parseInt(document.getElementById("c_cliente").value)<parseInt(document.getElementById("c_cliente1").value))
        )
            {
                return true;
            }
            else
            {
            return false;
            }
        }, "Debe ingresar un colegiado mayor");

    });
