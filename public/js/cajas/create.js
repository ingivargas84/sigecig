var validator = $("#BoletaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		no_boleta:{
			required: true
		},
		nombre_usuario: {
			required : true
		},
		solicitud_boleta_id: {
			required : true
		}
	},
	messages: {
		no_boleta: {
			required: "Por favor, ingrese el numero de boleta"
		},
		nombre_usuario: {
			required: "Por favor, ingrese su nombre de usuario"
		},
		solicitud_boleta_id: {
			required: "por favor, ingrese el numero de solicitud de Boleta"
		}
	}
});

$("#ButtonBoleta").click(function(event) {
	if ($('#BoletaForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});