
$(document).on('change', '#colegiado', function(event) {
    var no_colegiado = $(this).val();
    if ($.trim(no_colegiado) != '') {
        $.ajax({
            type: "get",
            url: "/auxilioPostumo/"+no_colegiado+"/getDatosColegiado",
            beforeSend:function(){
                $('#crearUsuario').hide();
            },
            success: function (response) {
                var D = response[0][0].fecha_nac;
                var nueva_fecha=D.split(" ")[0].split("-").reverse().join("/");
                $("input[name=n_cliente]").val(response[0][0].n_cliente);
                $("input[name=c_cliente]").val(response[0][0].c_cliente);
                $("input[name=fecha_nac]").val(nueva_fecha);
                $("input[name=registro]").val(response[0][0].registro);
                $("input[name=telefono]").val(response[0][0].telefono); 
                $("input[name=n_profesion]").val(response[0][0].n_profesion);
                $("input[name=emailColegiado]").val(response[0][0].e_mail);
                $('#miForumulario').show();
                if (response[1]==0) {
                    $('#crearUsuario').show();
                }

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
        var correo =  $("input[name=emailColegiado]").val();
        var registro =  $("input[name=registro]").val();
        $.ajax({
            type: "POST",
            url: "/auxilioPostumo/save",
            data: {no_colegiado:no_colegiado, banco:banco, tipo_cuenta:tipo_cuenta, no_cuenta:no_cuenta, telefono:telefono, correo:correo, registro:registro},
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
                alertify.set('notifier','position', 'top-center');  
                alertify.error('No se registro correctamente');
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

    jQuery.validator.addMethod("customemail", 
    function(value, element) {
        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    }, 
    "Formato de correo incorrecto"
);


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
            registro:{
                required: true,
                number:true,
                minlength: 13,
                maxlength: 13
            },
            emailColegiado:{
                required:true,
                customemail:true,
            }
        },
        messages: {
            telefono: {
                required: "Ingrese no. Teléfono",
                number: "No. de Teléfono debe ser numérico, eliminar espacios o guiones",
                minlength: "Formato XXXXXXXX 8 digitos",
                maxlength: "Formato XXXXXXXX 8 digitos"
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
            registro:{
                required: "El DPI es requerido",
                number: "No. de DPI debe ser numérico, eliminar espacios o guiones",
                minlength: "Formato 13 dígitos sin guión",
                maxlength: "Formato 13 dígitos sin guión"
            },
            emailColegiado:{
                required: "El correo electrónico es requerido"
            }
        },
    
    });
    

    
    });
    
    

    
    