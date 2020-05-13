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



var validator = $("#subsedesForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_sede:{
            required: true
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
        telefono_2: {
            required : true,
            number : true,
            ntel: true
		}
	},
	messages: {
		nombre_sede: {
			required: "Por favor, ingrese el nombre de la subsede"
        },
        direccion: {
			required: "Por favor, ingrese la Direccion de la sede"
		},
		correo_electronico: {
            required: "Por favor, ingrese su correo electronico",
            email: "ingrese un correo electronico correcto. ej: correo@correo.com"
		},
		telefono: {
            required: "por favor, ingrese el numero de telefono de la sede ",
            number: "debe ingresa un dato numerico",
            ntel: "El número de teléfono debe contener 8 digitos"
        },
        telefono_2: {
            required: "por favor, ingrese el numero segundo numero de la subsede ",
            number: "debe ingresa un dato numerico",
            ntel: "El número de teléfono debe contener 8 digitos"
		}
	}
});

$("#ButtonSubsedes").click(function(event) {
	if ($('#SubsedesForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});
