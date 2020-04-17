var validator = $("#ActaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		no_acta: {
			required : true
		},
		pdf_acta: {
			file: true,
			required: true
		},
	},
	messages: {
		no_acta: {
			required: "Por favor, ingrese el numero del Acta"
		},
		pdf_acta: {
			file: "Documento debe ser en formato PDF",
			required: "Por favor, cargue el documento"
		},
	}
});

$("#ButtonActa").click(function(event) {
	if ($('#ActaForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});