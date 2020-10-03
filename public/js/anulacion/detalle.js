var validator = $("#DetalleReciboAnulacionForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		solicitud:{
            required: true,

		},
	},
	messages: {
		solicitud: {
			required: "Por favor, ingrese el motivo por el cuál desea la anulación"
		},
	}
});

$("#guardar").click(function(event) {
	if ($('#DetalleReciboAnulacionForm').valid()) {
        $('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});
