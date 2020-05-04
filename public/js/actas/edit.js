
var validator = $("#ColaboradorUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre:{
			required: true
		},
		puesto: {
			required : true
		},
		departamento: {
			required: true
		},
		telefono:{
			required: true
		},
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre"
		},
		puesto: {
			required: "Por favor, ingrese el puesto"
		},

		departamento: {
			required: "Por favor, ingrese el departamento"
		},
		telefono: {
			required: "Por favor, ingrese el telefono"
		}
	}
});

$("#ButtonColaboradorUpdate").click(function(event) {
	if ($('#ColaboradorUpdateForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});