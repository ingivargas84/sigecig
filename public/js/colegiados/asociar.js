var validator = $("#AsociarForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		colegiado:{
        required: true,
        },
        fechaColegiado:{
        required: true,
	    }
	},
	messages: {
        colegiado: {
        required: "Por favor, ingrese el numero de colegiado"
        },
        fechaColegiado: {
        required: "Por favor, ingrese la fecha"
	    }
	}
});

$('#ingresoModal4').on('shown.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var dpi2 = button.data('dpi2');
      var nombre2 = button.data('nombre2');
      
      var modal = $(this);
    modal.find(".modal-body input[name='dpi2']").val(dpi2);
    modal.find(".modal-body input[name='nombre2']").val(nombre2);

   });
  
$("#ButtonTipoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#AsociarForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	var formData = $("#AsociarForm").serialize();
	var id = $("input[name='test']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenAs').val()},
		url: "/cajas/"+id+"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			BorrarFormularioUpdate();
			$('#ingresoModal4').modal("hide");
			colegiados_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Colegiado agregado con Éxito!!');
		},
	});
}
if(window.location.hash === '#add')
{
  $('#ingresoModal4').modal('show');
}

$('#ingresoModal4').on('hide.bs.modal', function(){
  $("#AsociarForm").validate().resetForm();
  document.getElementById("AsociarForm").reset();
  window.location.hash = '#';
});

$('#ingresoModal4').on('shown.bs.modal', function(){
  window.location.hash = '#add';
});

   function asociarColegiado() {
    var invitacion = {
        'idusuario': $("#dpi").val(),
        'colegiado': $("#colegiado").val(),
        'fechaColegiado': $("#fechaColegiado").val(),
        'fechaUltimoPagoColegio': $("#fechaUltimoPagoColegio").val(),
        'fechaUltimoPagoTimbre': $("#fechaUltimoPagoTimbre").val(),
        'observaciones': $("#observaciones").val(),
        'memo': $("#memo").val(),
        'password': $("#password").val(),
    };
    $("#password").val('');
    $.ajax({
      type: "POST",
      headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
      dataType:'JSON',
      url: "Aspirante/asociarColegiado",
      data: invitacion,
      success: function(data){
        if(data.error==0){
          $("#mensajes").html("Colegiado asociado correctamente.");
          $("#mensajes").css({'color':'green'});
  
        } else if(data.error==2){
          $("#mensajes").html("Error de autenticación.");
          $("#mensajes").css({'color':'red'});
  
        } else if(data.error==3){
          $("#mensajes").html("Colegiado ya existente.");
          $("#mensajes").css({'color':'red'});
  
        } else {
          $("#mensajes").html("Error al guardar.");
          $("#mensajes").css({'color':'red'});
        }
      },
      error: function(response) {
        $("#mensajes").html("Error en el sistema.");
      }
    });
  }

  $("#ButtonBoletaUpdate").click(function(event) {
      if ($('#TimbreForm').valid()) {
          $('.loader').addClass("is-active");
      } else {
          validator.focusInvalid();
      }
  }); 
   
  $("#ButtonTipoModalUpdate").click(function(event) {
      event.preventDefault();
      if ($('#TimbreForm').valid()) {
          updateModal();
      } else {
          validator.focusInvalid();
      }
  });
  
function cargarDatos() {
    getdatos();
    $(".colegiado").val($("#idusuario").val());
    if($('.nav-tabs .active').text() == "Pagos de colegio") {
      getPagosColegiado("02");
    } else if($('.nav-tabs .active').text() == "Pagos de timbre") {
      getPagosColegiado("01");
    }  else if($('.nav-tabs .active').text() == "Datos profesionales") {
      getDatosProfesionales("M");
      getDatosProfesionales("P");
    } else if($('.nav-tabs .active').text() == "Datos timbre y restricciones") {
      getDatosTimbre();
      getFechaTopeMensualidades();
    }
  }

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href");
    var tipo = "";
    if(target == '#pagosTimbre') {
      tipo = "01";
      getPagosColegiado(tipo);
    } else if(target == '#pagosColegio') {
      tipo = "02";
      getPagosColegiado(tipo);
    } else if(target == '#datosProfesionales') {
      getDatosProfesionales("M");
      getDatosProfesionales("P");
    } else if(target == '#datosTimbre') {
      getDatosTimbre();
      getFechaTopeMensualidades();
    }
  });
