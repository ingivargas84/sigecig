var validator = $("#TipoPagoForm").validate({
	ignore: [],
    onkeyup:false,
    onclick: false,
	rules: {
		codigo:{
            required: true,
            nombreunico : true
		},
		tipo_de_pago: {
			required : true
        },
        precio_colegiado: {
            required : true
        },
        precio_particular: {
            required : true
        },
        categoria_id:{
            required : true
        },
	},
	messages: {
		codigo: {
			required: "Por favor, ingrese el código",
		},
		tipo_de_pago: {
			required: "Por favor, ingrese el tipo de pago"
        },
        precio_colegiado: {
            required: "Por favor, ingrese el precio de colegiado"
        },
        precio_particular: {
            required: "Por favor, ingrese el precio para particular"
        },
        categoria_id:{
            required: "Por favor, seleccione una categoría"
        },
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
        error: function(errors) {
			var errors = JSON.parse(errors.responseText);
			if (errors.codigo != null) {
				$("#TipoPagoForm input[name='codigo'] ").after("<label class='error' id='Errorcodigo'>"+errors.codigo+"</label>");
            }
        }
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


$.validator.addMethod("nombreunico", function(value, element){
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/tipoDePago/nombreDisponible/",
        data:"codigo=" + value,
        dataType: "json",
        success: function (msg) {
            valid=!msg;
        }
    });
    return valid;
    }, "El código ya esta registrado en el sistema");
