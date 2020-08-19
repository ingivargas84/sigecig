$('#ingresoModal2').on('shown.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var dpi = button.data('dpi');
	var nombre = button.data('nombre');
	
	var modal = $(this);
  modal.find(".modal-body input[name='dpi']").val(dpi);
  modal.find(".modal-body input[name='nombre']").val(nombre);

 });

 
$("#ButtonBoletaUpdate").click(function(event) {
	if ($('#ProfesionForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
}); 
 
$("#ButtonTipoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#ProfesionForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	var formData = $("#ProfesionForm").serialize();
	var id = $("input[name='test']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#cajasToken').val()},
		url: "/cajas/"+id+"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			BorrarFormularioUpdate();
			$('#ingresoModal2').modal("hide");
			colegiados_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Profesión agregada con Éxito!!');
		},
	});
}
 
if(window.location.hash === '#add')
{
  $('#ingresoModal2').modal('show');
}

$('#ingresoModal2').on('hide.bs.modal', function(){
  $("#ProfesionForm").validate().resetForm();
  document.getElementById("ProfesionForm").reset();
  window.location.hash = '#';
});

$('#ingresoModal2').on('shown.bs.modal', function(){
  window.location.hash = '#add';
});


function getDatosProfesionales(tipo) {
    divACambiar="";
    titulo="Profesiones";
    if(tipo=="P") {
      divACambiar="#profesiones";
    } else if(tipo=="M") {
      divACambiar="#especialidades";
      titulo="Especialidades";
    }
  
    $(divACambiar).empty();
  
      var datos = {
          'idusuario': $("#dpi").val(),
      'tipo': tipo
      };
      $.ajax({
          type: "POST",
          headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
          dataType:'JSON',
          url: "Aspirante/getDatosProfesionalesAspirante",
          xhrFields: {
                  withCredentials: true
          },
          data: datos,
          success: function(data){
              var i = 1;
        titulo="Profesiones";
        var f = "2";
        if(tipo=="M") {
          titulo="Especialidades";
          f = "1";
        }
              var texto = "<table width='100%' class='table table-striped table-hover'>";
              texto += "<thead>";
              texto += "<tr>";
        texto += "<th align='center' style='width:15%'>";
              texto += "Código";
              texto += "</th>";
              texto += "<th align='center' style='width:70%'>";
              texto += titulo;
              texto += "</th>";
        texto += "<th align='center' style='width:15%'>";
              texto += "Eliminar";
              texto += "</th>";
              texto += "</tr>";
              texto += "</thead>";
              texto += "<tbody>";
              for (dato in data) {
                  texto += "<tr>";
          texto += "<td align='center'>";
          var codigo = data[dato].c_profesion;
          var terminacion = data[dato].n_profesion;
          if(tipo=="M") {
            codigo = data[dato].c_especialidad;
            terminacion = data[dato].n_especialidad;
          }
          texto += '<input type="hidden" class="codigo1" name="codigo" disabled value="'+codigo+'" id="codigo1">';
          texto += '<input type="text" class="codigo form-control" disabled value="'+codigo+'">';
          texto += "</td>";
          texto += "<td align='center'>";
          var tituloSexo = data[dato].titulo_masculino;
          if($("#sexo").val() == 'F') {
            tituloSexo = data[dato].titulo_femenino;
          }
  
          texto += '<input type="text" class="titulo form-control" disabled value="'+ (tituloSexo ? tituloSexo : "") + ' ' + (terminacion ? terminacion : "")+'">';
          texto += "</td>";
          texto += "<td align='center'><button class='form-button btn btn-danger' onclick='eliminarPE(this, " + f + ")' type='button'>Eliminar</button></td>";
                  texto += "</tr>";
                  i++;
              }
              texto += "</tbody>";
              texto += "</table>";
        divACambiar="";
        if(tipo=="P") {
          divACambiar="#profesiones";
        } else if(tipo=="M") {
          divACambiar="#especialidades";
        }
  
              $(divACambiar).empty();
              $(divACambiar).append(texto);
  
                  //alert(data.n_cliente);
          },
          error: function(response) {
                  $("#cleanButton").click();
                  $("#mensajes").html("Error en el sistema.");
          }
      });
  }
  
/*   $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
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
  }); */
  
$(window).on('load', function(e) {
    $("#idusuario").val(location.hash);
      if($("#idusuario").val()) {
        getdatos();
      }
      $(".nombreEspecialidad").autocomplete({
        source: "General/busquedaEspecialidadAutocomplete",
        focus: function(event, ui) {
          // prevent autocomplete from updating the textbox
          event.preventDefault();
          // manually update the textbox
          $(this).val(ui.item.label);
        },
        select: function(event, ui) {
          // prevent autocomplete from updating the textbox
          event.preventDefault();
          // manually update the textbox and hidden field
  
          $(this).val(ui.item.label);
          $('#idespecialidad').val(ui.item.value);
          //$(this).nextAll('input').first().val(ui.item.value);
        }
      });
  
      $(document).ready(function() {
        $('.selectpicker').selectpicker({
          style: 'btn btn-light',
          size: 4
        });
   });

      $(".nombreProfesion").autocomplete({
        source: "General/busquedaProfesionAutocomplete",
        focus: function(event, ui) {
          // prevent autocomplete from updating the textbox
          event.preventDefault();
          // manually update the textbox
          $(this).val(ui.item.label);
        },
        select: function(event, ui) {
          // prevent autocomplete from updating the textbox
          event.preventDefault();
          // manually update the textbox and hidden field
  
          $('#nombreProfesion').val(ui.item.label);
          $('#idprofesion').val(ui.item.value);
          return false;

          //$(this).nextAll('input').first().val(ui.item.value);
        },
        success: function(data)
{
     $("#nombreProfesion").selectpicker('refresh');
}
      });
  }); 
  /* 
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
  } */

  

function agregarProfesionF() {
	var invitacion = {
		'idprofesion': $("#idprofesion").val(),
    'idusuario': $("#dpi").val(),
   /* 'nombres': $("#nombres").val(),
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
    'nombreContactoEmergencia': $("#nombreContactoEmergencia").val() */
	};
  $("#mensajes").html("");
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "Aspirante/setDatosProfesionalesAspirante",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
      if(data.retorno==0) {
        $("#mensajes").html("Profesión guardada correctamente.");
        $("#mensajes").css({'color':'green'});
        getDatosProfesionales("P");
      } else if(data.retorno==1) {
        $("#mensajes").html("Especialidad ya presente.");
        $("#mensajes").css({'color':'red'});
      } else {
        var a = "Error en el sistema.";
        if(data.hasOwnProperty("mensaje")) {
          a += " " + data.mensaje;
        }
        $("#mensajes").html(a);
        $("#mensajes").css({'color':'red'});
        alertify.set('notifier','position', 'top-center');
        alertify.success('Profesión agregada con Éxito!!');
      }
		},
		error: function(response) {
				$("#mensajes").html("Error en el sistema.");
        $("#mensajes").css({'color':'red'});
		}
	});
}
  
function agregarEspecialidadF() {
	var invitacion = {
		'idespecialidad': $("#idespecialidad").val(),
    'idusuario': $("#dpi").val(),
 /*   'nombres': $("#nombres").val(),
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
    'nombreContactoEmergencia': $("#nombreContactoEmergencia").val() */
	};
  $("#mensajes").html("");
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "Aspirante/setDatosEspecialidadesAspirante",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
      if(data.retorno==0) {
        $("#mensajes").html("Especialidad guardada correctamente.");
        $("#mensajes").css({'color':'green'});
        getDatosProfesionales("M");
      } else if(data.retorno==1) {
        $("#mensajes").html("Especialidad ya presente.");
        $("#mensajes").css({'color':'red'});
      } else {
        var a = "Error en el sistema.";
        if(data.hasOwnProperty("mensaje")) {
          a += " " + data.mensaje;
        }
        $("#mensajes").html(a);
        $("#mensajes").css({'color':'red'});
      }
        colegiados_table.ajax.reload();
        alertify.set('notifier','position', 'top-center');
        alertify.success('Especialidad agregada con Éxito!!');
        $('#ingresoModal2').modal("hide");
		},
		error: function(response) {
				$("#mensajes").html("Error en el sistema.");
        $("#mensajes").css({'color':'red'});
		}
	});
}