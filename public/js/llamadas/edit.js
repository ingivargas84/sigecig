var validator = $("#LlamadaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		colegiado:{
			required: true
		},
		telefono: {
			required : true
		},
		observaciones: {
			required : true
		}
	},
	messages: {
		colegiado: {
			required: "Por favor, ingrese el numero de colegiado"
		},
		telefono: {
			required: "Por favor, ingrese el telefono"
		},
		observaciones: {
			required: "por favor, ingrese las observaciones"
		}
	}
});

$("#ButtonLlamadaUpdate").click(function(event) {
	if ($('#LlamadaUpdateForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});