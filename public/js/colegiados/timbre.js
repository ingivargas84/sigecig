var validator = $("#TimbreForm").validate({
	ignore: [],
    onkeyup:false,
    onclick: false,
	rules: {
		montoTimbre:{
      required: true
		},
		fechaTopeMensualidades: {
			required : true
        }
	},
	messages: {
		montoTimbre: {
			required: "Por favor, ingrese el monto"
		},
		fechaTopeMensualidades: {
			required: "Por favor, ingrese la fecha"
        }
	}
});

$('#ingresoModal3').on('shown.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var dpi1 = button.data('dpi1');
    var nombre1 = button.data('nombre1');
      
    var modal = $(this);
    modal.find(".modal-body input[name='dpi1']").val(dpi1);
    modal.find(".modal-body input[name='nombre1']").val(nombre1);

   });
  
  $("#guardarTimbre").click(function(event) {
    event.preventDefault();
      if ($('#TimbreForm').valid()) {
        guardarMontoTimbreF();
      } else {
          validator.focusInvalid();
      }
  }); 
  $("#modificarFecha").click(function(event) {
      event.preventDefault();
      if ($('#TimbreForm').valid()) {
          guardarFechaTopeMensualidadesF();
      } else {
          validator.focusInvalid();
      }
  });
 
function guardarMontoTimbreF()
{
  var invitacion = {
    'idusuario': $("#dpi1").val(),
    'montoTimbre': $("#montoTimbre").val(),
    'nombres': $("#nombres").val(),
    'apellidos': $("#apellidos").val(),

    'sexo': $("#sexo").val(),
    'fechaNacimiento': $("#fechaNacimiento").val(),
    'idDepartamentoNacimiento': $("#idDepartamentoNacimiento").val(),
    'idMunicipioNacimiento': $("#idMunicipioNacimiento").val(),
    'idPaisNacimiento': $("#idPais").val(),
    //'tipoSangre': $("#tipoSangre").val(),

    'idNacionalidad': $("#idNacionalidad").val(),
    'telefono': $("#telefono").val(),
    'telTrabajo': $("#telTrabajo").val(),
    'email': $("#email").val(),
    //'nit': $("#nit").val(),
    'estadoCivil': $("#estadoCivil").val(),

    //'conyugue': $("#conyugue").val(),

    'direccion': $("#direccion").val(),
    'zona': $("#zona").val(),
    'idDepartamentoCasa': $("#idDepartamento").val(),
    'idMunicipioCasa': $("#idMunicipio").val(),
    //'codigoPostal': $("#codigoPostal").val(),

    'direccionTrabajo': $("#direccionTrabajo").val(),
    'zonaTrabajo': $("#zonaTrabajo").val(),
    'idDepartamentoTrabajo': $("#idDepartamentoTrabajo").val(),
    'idMunicipioTrabajo': $("#idMunicipioTrabajo").val(),
    //'lugarTrabajo': $("#lugarTrabajo").val(),

    //'direccionOtro': $("#direccionOtro").val(),
    //'zonaOtro': $("#zonaOtro").val(),
    //'idDepartamentoOtro': $("#idDepartamentoOtro").val(),
    //'idMunicipioOtro': $("#idMunicipioOtro").val(),
    'destino': $("#destino").val(),

    'fechaGraduacion': $("#fechaGraduacion").val(),
    'idUniversidadGraduado': $("#idUniversidadGraduado").val(),
    'idUniversidadIncorporado': $("#idUniversidadIncorporado").val(),
    //'creditos': $("#creditos").val(),

    'tituloTesis': $("#tituloTesis").val(),
    'telefonoContactoEmergencia': $("#telefonoContactoEmergencia").val(),
    'nombreContactoEmergencia': $("#nombreContactoEmergencia").val()
  };
  $.ajax({
    type: "POST",
    headers: {'X-CSRF-TOKEN': $('#tokenTim').val()},
    dataType:'JSON',
    url: "Aspirante/guardarMontoTimbreAspirante",
    data: invitacion,
    success: function(data){
      if(data.error==1){
        $("#mensajes").html("Ningún dato encontrado.");
        $("#mensajes").css({'color':'red'});
      } else {
        $("#mensajes").html("Datos guardados correctamente.");
        $("#mensajes").css({'color':'green'});
        alertify.set('notifier','position', 'top-center');
				alertify.success('Monto agregado con Éxito!!');
      }
      
    },
    error: function(response) {
      $("#mensajes").html("Error en el sistema.");
    }
  });
}

function guardarFechaTopeMensualidadesF(){
var invitacion = {
    'fechaTopeMensualidades': $("#fechaTopeMensualidades").val(),
    'idusuario': $("#dpi1").val(),
    'nombres': $("#nombres").val(),
    'apellidos': $("#apellidos").val(),

    'sexo': $("#sexo").val(),
    'fechaNacimiento': $("#fechaNacimiento").val(),
    'idDepartamentoNacimiento': $("#idDepartamentoNacimiento").val(),
    'idMunicipioNacimiento': $("#idMunicipioNacimiento").val(),
    'idPaisNacimiento': $("#idPais").val(),
    //'tipoSangre': $("#tipoSangre").val(),

    'idNacionalidad': $("#idNacionalidad").val(),
    'telefono': $("#telefono").val(),
    'telTrabajo': $("#telTrabajo").val(),
    'email': $("#email").val(),
    //'nit': $("#nit").val(),
    'estadoCivil': $("#estadoCivil").val(),

    //'conyugue': $("#conyugue").val(),

    'direccion': $("#direccion").val(),
    'zona': $("#zona").val(),
    'idDepartamentoCasa': $("#idDepartamento").val(),
    'idMunicipioCasa': $("#idMunicipio").val(),
    //'codigoPostal': $("#codigoPostal").val(),

    'direccionTrabajo': $("#direccionTrabajo").val(),
    'zonaTrabajo': $("#zonaTrabajo").val(),
    'idDepartamentoTrabajo': $("#idDepartamentoTrabajo").val(),
    'idMunicipioTrabajo': $("#idMunicipioTrabajo").val(),
    //'lugarTrabajo': $("#lugarTrabajo").val(),

    //'direccionOtro': $("#direccionOtro").val(),
    //'zonaOtro': $("#zonaOtro").val(),
    //'idDepartamentoOtro': $("#idDepartamentoOtro").val(),
    //'idMunicipioOtro': $("#idMunicipioOtro").val(),
    'destino': $("#destino").val(),

    'fechaGraduacion': $("#fechaGraduacion").val(),
    'idUniversidadGraduado': $("#idUniversidadGraduado").val(),
    'idUniversidadIncorporado': $("#idUniversidadIncorporado").val(),
    //'creditos': $("#creditos").val(),

    'tituloTesis': $("#tituloTesis").val(),
    'telefonoContactoEmergencia': $("#telefonoContactoEmergencia").val(),
    'nombreContactoEmergencia': $("#nombreContactoEmergencia").val()
};
$.ajax({
    type: "POST",
    headers: {'X-CSRF-TOKEN': $('#tokenTim').val()},
    dataType:'JSON',
    url: "Aspirante/guardarFechaTopeMensualidades",
    data: invitacion,
    success: function(data){
            if(data.error==1){
                    $("#mensajes").html("Error al guardar.");
                    $("#mensajes").css({'color':'red'});
            } else {
                    $("#mensajes").html("Datos guardados correctamente.");
                    $("#mensajes").css({'color':'green'});
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Fecha agregada con Éxito!!');
                    $('#ingresoModal3').modal("hide");
            }
            
    },
    error: function(response) {
            $("#mensajes").html("Error en el sistema.");
    }
});
}