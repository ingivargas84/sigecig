var validator = $("#SolicitudForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		departamento_id:{
			number: true,
			required: true
		},
		responsable: {
			required : true
		},
		user_id: {
			required: true
		},
		quien_la_usara:{
			required: true
		},
	},
	messages: {
		departamento_id: {
			number: "el dato debe ser numerico",
			required: "Por favor, ingrese el departamento"
		},
		responsable: {
			required: "Por favor, ingrese la persona responsable"
		},

		user_id: {
			required: "Por favor, ingrese el ID del supervisor"
		},
		quien_la_usara: {
			required: "Por favor, ingrese quien usara la boleta"
		}
	}
});

$("#ButtonSolicitud").click(function(event) {
	if ($('#SolicitudForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});