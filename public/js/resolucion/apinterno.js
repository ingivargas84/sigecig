
$(document).on('change', '#colegiado', function(event) {
    var no_colegiado = $(this).val();
    if ($.trim(no_colegiado) != '') {
        $.ajax({
            type: "get",
            url: "/auxilioPostumo/"+no_colegiado+"/getDatosColegiado",
            success: function (response) {
                $("input[name=n_cliente]").val(response[0].n_cliente);
                $("input[name=c_cliente]").val(response[0].c_cliente);
                $("input[name=fecha_nac]").val(response[0].fecha_nac);
                $("input[name=registro]").val(response[0].registro);
                $("input[name=telefono]").val(response[0].telefono); 
                $("input[name=n_profesion]").val(response[0].n_profesion);
                $('#miForumulario').show();
            },
            error: function (jqXHR, estado, error){
                console.log(estado)
                console.log(error)
            }
        });
    }
});

$('#enviar').click(function (e) { 
    e.preventDefault();

    if ($('#miForumulario').valid()) {   
        var no_colegiado = $("input[name=c_cliente]").val();
        var banco = $("select[name=id_banco]").val();
        var tipo_cuenta = $("select[name=id_tipo_cuenta]").val();
        var no_cuenta = $("input[name=no_cuenta]").val();
        var telefono = $("input[name=telefono]").val();
        $.ajax({
            type: "POST",
            url: "/auxilioPostumo/save",
            data: {no_colegiado:no_colegiado, banco:banco, tipo_cuenta:tipo_cuenta, no_cuenta:no_cuenta, telefono:telefono},
            beforeSend:function () {
                $('.loader').show();
              },
            success: function (response) {
                alertify.set('notifier','position', 'top-center');  
                alertify.success('Registrado Correctamente');
            },
            error: function (jqXHR, estado, error){
                console.log(estado)
                console.log(error)
            }
    
        }).always(function () {
            $('.loader').hide();
            $('#miForumulario').hide();
        }).done(function () {
            window.location.href = "/resolucion";
        });      
            
    } else {
        validator.focusInvalid();
    }



});


$( document ).ready(function() {


    var validator = $("#miForumulario").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            telefono:{
                required: true,
                number:true,
                minlength: 8,
                maxlength: 8
            },
            id_banco:{
                required: true
            },
            id_tipo_cuenta:{
                required: true
            },
            no_cuenta:{
                required: true,
                number:true,
            },
        },
        messages: {
            telefono: {
                required: "Ingrese no. Telefono",
                number: "No. de Telefono invalido",
                minlength: "Debe contener 8 digitos",
                maxlength: "Debe contener 8 digitos"
            },
            id_banco: {
                required: "Seleccione un banco"
            },
            id_tipo_cuenta: {
                required: "Seleccione un tipo de cuenta"
            },
            no_cuenta: {
                required: "Ingrese No. de cuenta bancaria",
                number: "No. Cuenta invalido"
            },
        },
    
    });
    
    $("#enviar").click(function(event) {

    });
    
    
    });
    
    

    
    