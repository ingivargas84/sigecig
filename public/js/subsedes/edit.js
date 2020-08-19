$.validator.addMethod("ntel1", function (value, element ){
    var valor = value.length;
    if(valor == 8)
    {
        return true;
    }
    else
    {
    return false;
    }
}, "Debe ingresar el número de teléfono con 8 dígitos");


$.validator.addMethod("nombreunicoE", function(value, element){
    var valid = false;
    var id = $("input[name='num']").val();
    var name = $("input[name='nombre_sede']").val();
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/subsedes/nombreDisponibleEdit/",
        data: {id,name},
        dataType: "json",
        success: function (msg) {
            valid=!msg;
        }
    });
    return valid;
    }, "El nombre ya esta registrado en el sistema");


var validator = $("#subsedesUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_sede:{
            required: true,
            nombreunicoE: true
        },
            direccion:{
                required: true

            },
		correo_electronico: {
            required : true,
            email : true
		},
		telefono: {
            required : true,
            ntel1 : true

        },

	},
	messages: {
		nombre_sede: {
            required: "Por favor, ingrese el nombre de la subsede"

        },
        direccion: {
			required: "Por favor, ingrese la Dirección de la sede "
		},
		correo_electronico: {
            required: "Por favor, ingrese su correo electrónico",
            email: "Ingrese un correo electrónico correcto. ej: correo@correo.com"
		},
		telefono: {
            required: "Por favor, ingrese el número de teléfono de la sede ",
            number: "Debe ingresa un dato numerico"
        },

	}
});

$("#ButtonSubsedes").click(function(event) {
	if ($('#subsedesUpdateForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
    }



});
