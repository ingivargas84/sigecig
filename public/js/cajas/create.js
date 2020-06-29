var validator = $("#CajasForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_caja:{
			required: true
		},
		subsede: {
			required : true
		},
		cajero: {
			required : true
		}
	},
	messages: {
		nombre_caja: {
			required: "Por favor, ingrese el numero de boleta"
		},
		subsede: {
			required: "Por favor, ingrese su nombre de usuario"
		},
		cajero: {
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

$.validator.addMethod("nombreunico", function(value, element){
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/cajas/nombreDisponible/",
        data:"nombre_sede=" + value,
        dataType: "json",
        success: function (msg) {
            valid=!msg;
        }
    });
    return valid;
	}, "La subsede ya está registrada en el sistema");
	
	$("#ButtonTipoModal1").click(function(event) {
		event.preventDefault();
		if ($("#CajasForm").valid()) {
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
			url: "/cajas/save",
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
					$("#CajasForm input[name='codigo'] ").after("<label class='error' id='Errorcodigo'>"+errors.codigo+"</label>");
				}
			}
		});
	}
	
	//Mostrar y ocultar formulario
	if (window.location.hash === '#create') {
		$('#ingresoModal').modal('show');
	}
	$('#ingresoModal').on('hide.bs.modal', function () {
		$("#CajasForm").validate().resetForm();
		document.getElementById("CajasForm").reset();
		window.location.hash = '#';
	});
	$('#ingresoModal').on('shown.bs.modal', function () {
		window.location.hash = '#create';
	});
	