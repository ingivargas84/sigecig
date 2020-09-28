
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
            cajaActivaxyz:{
                required: true,
  
            },
            fechaInicialVenta:{
                required: true
                
            },
            fechaFinalVenta:{
                required: true,
                greaterThan: ["#fechaInicialVenta","fechaFinalVenta"]
            },
        },
        messages: {
            cajaActivaxyz: {
                required: "Seleccione una caja",
            },
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

    $('#modal-reporte-ventas-xyz').click(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "/reportes/getCajas",
            beforeSend:function(){
            },
            success: function (data) {
                $("#cajaActivaxyz").empty();
                $("#cajaActivaxyz").selectpicker('refresh').append('<option value="">Nothing selected</option>').selectpicker('refresh').trigger('change');

                for (let i=0; i<data.length;i++)
                {
                    $("#cajaActivaxyz").selectpicker('refresh').append('<option value="'+data[i]["c_bodega"]+'">'+data[i]["n_bodega"]+'</option>').selectpicker('refresh').trigger('change');

                }
            },
            error: function (jqXHR, estado, error){
                console.log(estado)
                console.log(error)
            }
        });
    });


    
    