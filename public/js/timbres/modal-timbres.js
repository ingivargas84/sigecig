
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

    var validator = $("#form-timbres").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            cajaActivaTimbre:{
                required: true,
  
            },
            fechaInicial:{
                required: true
                
            },
            fechaFinal:{
                required: true,
                greaterThan: ["#fechaInicial","fechaFinal"]
            },
        },
        messages: {
            cajaActivaTimbre: {
                required: "Seleccione una caja",
            },
            fechaInicial: {
                required: "Elija fecha inicial"
            },
            fechaFinal: {
                required: "Elija fecha final",
                greaterThan: "Fecha final no puede ser menor a la fecha inicial"
               
            },
        
        },
    
    });
    });

    $('#modal-reporte-timbres').click(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "/timbres/getCajas",
            beforeSend:function(){
                $('.loader').show();
            },
            success: function (data) {
                $("#cajaActivaTimbre").empty();
                console.log(data);
                $("#cajaActivaTimbre").selectpicker('refresh').append('<option value="">Nothing selected</option>').selectpicker('refresh').trigger('change');

                for (let i=0; i<data.length;i++)
                {
                    $("#cajaActivaTimbre").selectpicker('refresh').append('<option value="'+data[i]["id"]+'">'+data[i]["nombre_caja"]+'</option>').selectpicker('refresh').trigger('change');
                }
            },
            error: function (jqXHR, estado, error){
                console.log(estado)
                console.log(error)
            }
        }).always(function name(params) {
            $('.loader').hide();
        });
    });
    
    