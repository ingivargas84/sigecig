var validator = $("#TipoPagoForm").validate({
	ignore: [],
    onkeyup:false,
    onclick: false,
	rules: {
		codigo:{
            required: true,
		},
		tipo_de_pago: {
			required : true
		}
	},
	messages: {
		codigo: {
			required: "Por favor, ingrese el codigo",
		},
		tipo_de_pago: {
			required: "Por favor, ingrese el tipo de pago"
		}
	}
});


$("#ButtonTipoModal").click(function(event) {
	event.preventDefault();
	if ($("#TipoPagoForm").valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	var formData = $("#TipoPagoForm").serialize();
    var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		url: "/tipoDePago/save",
		data: formData,
		dataType: "json",
		success: function(data) {
            $('.loader').fadeOut(225);
			$('#ingresoModal').modal("hide");
			tipodepago_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
            alertify.success('Tipo de Pago Creado con Éxito!!');
		},

	});
}

//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#ingresoModal').modal('show');
}
$('#ingresoModal').on('hide.bs.modal', function () {
    $("#TipoPagoForm").validate().resetForm();
    document.getElementById("TipoPagoForm").reset();
    window.location.hash = '#';
});
$('#ingresoModal').on('shown.bs.modal', function () {
    window.location.hash = '#create';
});
