$.validator.addMethod("ntel", function (value, element ){
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


$.validator.addMethod("nombreunico", function(value, element){
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/subsedes/nombreDisponible/",
        data:"nombre_sede=" + value,
        dataType: "json",
        success: function (msg) {
            valid=!msg;
        }
    });
    return valid;
    }, "El nombre ya esta registrado en el sistema");



var validator = $("#subsedesForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_sede:{
            required: true,
            nombreunico: true
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
            number : true,
            ntel: true
        },

	},
	messages: {
		nombre_sede: {
            required: "Por favor, ingrese el nombre de la subsede"
        },
        direccion: {
			required: "Por favor, ingrese la Dirección de la sede"
		},
		correo_electronico: {
            required: "Por favor, ingrese su correo electrónico",
            email: "ingrese un correo electrónico correcto. ej: correo@correo.com"
		},
		telefono: {
            required: "Por favor, ingrese el número de teléfono de la sede ",
            number: "Debe ingresa un dato numerico",
            ntel: "El número de teléfono debe contener 8 digitos"
        },
        telefono_2: {
            number: "Debe ingresa un dato numerico",
            ntel: "El número de teléfono debe contener 8 digitos"
		}
	}
});

$("#subsedes").click(function(event) {
	if ($('#subsedesForm').valid()) {
        $('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});
