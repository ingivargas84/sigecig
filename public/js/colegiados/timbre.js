$('#ingresoModal3').on('shown.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var dpi1 = button.data('dpi1');
      var nombre1 = button.data('nombre1');
      
      var modal = $(this);
    modal.find(".modal-body input[name='dpi1']").val(dpi1);
    modal.find(".modal-body input[name='nombre1']").val(nombre1);

   });
  

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
  
  function updateModal(button) {
      var formData = $("#TimbreForm").serialize();
      var id = $("input[name='test']").val();
      var urlActual =  $("input[name='urlActual']").val();
      $.ajax({
          type: "POST",
          headers: {'X-CSRF-TOKEN': $('#tokenTim').val()},
          url: "/cajas/"+id+"/update",
          data: formData,
          dataType: "json",
          success: function(data) {
              BorrarFormularioUpdate();
              $('#ingresoModal3').modal("hide");
              colegiados_table.ajax.reload();
              alertify.set('notifier','position', 'top-center');
              alertify.success('Profesión agregada con Éxito!!');
          },
      });
  }
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
      }
      alertify.set('notifier','position', 'top-center');
				alertify.success('Monto agregado con Éxito!!');
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
    headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
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
            }
            alertify.set('notifier','position', 'top-center');
            alertify.success('Fecha agregada con Éxito!!');
            $('#ingresoModal3').modal("hide");
    },
    error: function(response) {
            $("#mensajes").html("Error en el sistema.");
    }
});
}

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

function getDatosTimbre() {
    $("#montoTimbre").val("");
                    var invitacion = {
                        'idusuario': $("#dpi1").val()
                    };
                    $.ajax({
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
                        dataType:'JSON',
                        url: "Aspirante/getMontoTimbreAspirante",
      xhrFields: {
              withCredentials: true
        },
                        data: invitacion,
                        success: function(data){
                                //$("#mensajes").html(data);
        if(data.error==1){
                                        $("#mensajes").html("Ningún dato encontrado.");
                                        $("#mensajes").css({'color':'red'});
                                } else {
          $("#montoTimbre").val(data.montoTimbre);
        }
                                //alert(data.n_cliente);
                        },
                        error: function(response) {
                                $("#mensajes").html("Error en el sistema.");
                                $("#mensajes").css({'color':'red'});
                        }
                    });
  }
