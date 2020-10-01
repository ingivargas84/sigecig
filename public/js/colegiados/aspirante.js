
   //Mostrar y ocultar formulario
   if (window.location.hash === '#tim') {
    $('#ingresoModal3').modal('show');
  }
  $('#ingresoModal3').on('hide.bs.modal', function () {
    $("#TimbreForm").validate().resetForm();
    document.getElementById("TimbreForm").reset();
    window.location.hash = '#';
  });
  $('#ingresoModal3').on('shown.bs.modal', function () {
    window.location.hash = '#tim';
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

function getdatos() {
  $("#cleanButton").click();
	var idusuario = $("#dpi").val();
  var idusuarioF = $("#dpi").val();
	var invitacion = {
		'idusuario': idusuario
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/Aspirante/getdatosaspirante",
		data: invitacion,
		success: function(data){
				var idusuario = $("#idusuario").val();
				limpiarFormulario();
				$("#mensajes").html("");
				$("#dpi").val(idusuarioF);
				$('#fotoColegiado').attr('src', '');
				$('#firmaColegiado').attr('src', '');
					if(data.error==1){
				$("#mensajes").html("Ningún dato encontrado.");
				$("#mensajes").css({'color':'red'});
					} else {
				$("#nombres").val(data.nombre);
				$("#apellidos").val(data.apellidos);
				$("#telefono").val(data.telefono);
				$("#email").val(data.correo);
				$("#fechaUltimoPagoColegio").val(data.fechaultimopagocolegio);
				$("#fechaUltimoPagoTimbre").val(data.fechaultimopagotimbre);
				$("#status").val(data.status);
				$("#fechaColegiado").val(data.fechacolegiado);
				$("#fallecido").val(data.fallecido);
				$("#idDepartamentoNacimiento").val(data.iddepartamentonacimiento);
				$("#valDepartamentoNacimiento").val(data.valdepartamentonacimiento);
				$("#idMunicipioNacimiento").val(data.idmunicipionacimiento);
				$("#valMunicipioNacimiento").val(data.valmunicipionacimiento);
            	$("#direccion").val(data.direccionCasa);
				$("#direccionTrabajo").val(data.direccionTrabajo);
            	$("#direccionOtro").val(data.direccionOtro);
				$("#idDepartamento").val(data.idDepartamentoCasa);
				$("#valDepartamento").val(data.valDepartamentoCasa);
				$("#idMunicipio").val(data.idMunicipioCasa);
				$("#valMunicipio").val(data.valMunicipioCasa);
				$("#conyugue").val(data.conyugue);
				$("#valPais").val(data.valPais);
				$("#idPais").val(data.idPaisNacimiento);
				$("#idNacionalidad").val(data.idnacionalidad);
				$("#valNacionalidad").val(data.valNacionalidad);
				$("#idDepartamentoTrabajo").val(data.idDepartamentoTrabajo);
				$("#valDepartamentoTrabajo").val(data.valDepartamentoTrabajo);
				$("#idMunicipioTrabajo").val(data.idMunicipioTrabajo);
				$("#valMunicipioTrabajo").val(data.valMunicipioTrabajo);
				$("#idDepartamentoOtro").val(data.idDepartamentoOtro);
				$("#valDepartamentoOtro").val(data.valDepartamentoOtro);
				$("#idMunicipioOtro").val(data.idMunicipioOtro);
				$("#valMunicipioOtro").val(data.valMunicipioOtro);
				$("#zona").val(data.zona);
				$("#zonaTrabajo").val(data.zonatrabajo);
				$("#zonaOtro").val(data.zonaotro);
				$("#nit").val(data.nit);
				$("#estadoJunta").val(data.estadojunta);
				$("#sexo").val(data.sexo);
				$("#estadoCivil").val(data.estadocivil);
				$("#destino").val(data.destinoCorreo);
				$("#codigoPostal").val(data.codigopostal);
				$("#telTrabajo").val(data.telefonoTrabajo);
				$("#lugarTrabajo").val(data.lugar);
				$("#fechaNacimiento").val(data.fechaNacimiento);
				$("#tipoSangre").val(data.tipoSangre);
				$("#maxConstancias").val(data.maxconstancias);
				$("#u_egresado").val(data.u_egresado);
            	$("#telefonoContactoEmergencia").val(data.telefonoContactoEmergencia);
				$("#nombreContactoEmergencia").val(data.nombreContactoEmergencia);
           		$("#pagaAuxilio").val(data.pagaauxilio);
				$("#fechaGraduacion").val(data.fechaGraduacion);
				$("#valUniversidadGraduado").val(data.valuniversidadgraduado);
				$("#idUniversidadGraduado").val(data.universidadGraduado);
				$("#valUniversidadIncorporado").val(data.valuniversidadincorporado);
				$("#idUniversidadIncorporado").val(data.universidadIncorporado);
				$("#creditos").val(data.creditos);
				$("#tituloTesis").val(data.tituloTesis);

            if($("#estadoCivil").val() == "C") {
              $('#conyugueDiv').fadeIn(100);
            }
            if(data.carrera_afin == "1") {
              $("#ca").prop("checked", true);
            } else {
              $("#ca").prop("checked", false);
            }
			if(data.status == "Activo") {
					$("#status").css({'color':'green'});
			} else {
					$("#status").css({'color':'red'});
			}
		}
				//alert(data.n_cliente);
		},
		error: function(response) {

				$('#fotoColegiado').attr('src', '');
				$('#firmaColegiado').attr('src', '');
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function limpiarFormulario() {
  $("#nombres").val('');
  $("#apellidos").val('');
  $("#telefono").val('');
  $("#email").val('');
  $("#fechaUltimoPagoColegio").val('');
  $("#fechaUltimoPagoTimbre").val('');
  $("#status").val('');
  $("#fechaColegiado").val('');
  $("#fallecido").val('N');
  $("#idDepartamentoNacimiento").val('');
  $("#valDepartamentoNacimiento").val('');
  $("#idMunicipioNacimiento").val('');
  $("#valMunicipioNacimiento").val('');
  $("#idNacionalidad").val('');
  $("#valNacionalidad").val('');

  $("#direccion").val('');
  $("#direccionTrabajo").val('');
  $("#idDepartamento").val('');
  $("#valDepartamento").val('');
  $("#idMunicipio").val('');
  $("#valMunicipio").val('');
  $("#conyugue").val('');
  $("#conyugueDiv").fadeOut(100);



  $("#idDepartamentoTrabajo").val('');
  $("#valDepartamentoTrabajo").val('');
  $("#idMunicipioTrabajo").val('');
  $("#valMunicipioTrabajo").val('');

  $("#idDepartamentoOtro").val('');
  $("#valDepartamentoOtro").val('');
  $("#idMunicipioOtro").val('');
  $("#valMunicipioOtro").val('');
  $("#zona").val('');
  $("#zonaTrabajo").val('');
  $("#zonaOtro").val('');
  $("#dpi").val('');
  $("#nit").val('');
  $("#estadoJunta").val('01');
  $("#sexo").val('');
  $("#estadoCivil").val('');
  $("#destino").val('');
  $("#codigoPostal").val('');
  $("#telTrabajo").val('');
  $("#lugarTrabajo").val('');
  $("#idPais").val('');
  $("#valPais").val('');
  $("#fechaNacimiento").val('');
  $("#tipoSangre").val('');
  $("#maxConstancias").val('');
  $("#u_egresado").val('');
  $("#telefonoContactoEmergencia").val('');
  $("#nombreContactoEmergencia").val('');

}

function getPagosColegiado(tipo) {
  if(tipo=='01') {
    div_a_cambiar = "pagosTimbreTabla";
  } else if(tipo == '02'){
    div_a_cambiar = "pagosColegioTabla";
  }
  $('#' + div_a_cambiar).empty();
	var invitacion = {
		'colegiado': $("#idusuario").val(),
		'tipo': tipo
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "Colegiado/getpagoscolegiado",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
			var i = 1;
			var texto = "<table width='100%' class='table-striped table-bordered table-hover'>";
			texto += "<thead>";
			texto += "<tr>";
			texto += "<th align='center'>";
			texto += "Fecha";
			texto += "</th>";
			texto += "<th align='center'>";
			texto += "Serie";
			texto += "</th>";
			texto += "<th align='center'>";
			texto += "Número";
			texto += "</th>";
			texto += "<th align='center'>";
			texto += "Pagado hasta";
			texto += "</th>";
			texto += "<th align='center'>";
			texto += "Descripcion";
			texto += "</th>";
      texto += "<th align='center'>";
			texto += "Total";
			texto += "</th>";
			texto += "</tr>";
			texto += "</thead>";
			texto += "<tbody>";
			for (dato in data) {
				texto += "<tr>";
				texto += "<td align='center'>"+data[dato].fecha + "</td>";
				texto += "<td align='center'>"+data[dato].serie + "</td>";
				texto += "<td align='center'>";
        texto += "<a href='/Facturacion/caja/" + data[dato].control +"' target='_blank'>"; 
        texto += data[dato].numerofactura;
      texto += "</a>";
        texto += "</td>";
				texto += "<td align='center'>"+data[dato].fechahasta + "</td>";
				texto += "<td align='center'>"+data[dato].descripcion + "</td>";
				texto += "<td align='right'>Q"+parseFloat(data[dato].total).toFixed(2) + "</td>";
				texto += "</tr>";
				i++;

			}
			texto += "</tbody>";
			texto += "</table>";
			var div_a_cambiar = "";
			if(tipo=='01') {
				div_a_cambiar = "pagosTimbreTabla";
			} else if(tipo == '02'){
				div_a_cambiar = "pagosColegioTabla";
			}
			//$('#' + div_a_cambiar).empty();
			$('#' + div_a_cambiar).append(
				texto
			);

				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

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
                            'idusuario': $("#dpi").val()
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

      function getFechaTopeMensualidades() {
        $("#montoTimbre").val("");
                        var invitacion = {
                            'idusuario': $("#dpi").val()
                        };
                        $.ajax({
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
                            dataType:'JSON',
                            url: "Aspirante/obtenerFechaTopeMensualidades",
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
                                      $("#fechaTopeMensualidades").val(data.topefechapagocuotas)
            }
                                    //alert(data.n_cliente);
                            },
                            error: function(response) {
                                    $("#mensajes").html("Error en el sistema.");
                                    $("#mensajes").css({'color':'red'});
                            }
                        });
      }


$("#serieReciboColegio").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        e.keyCode = newKey;
        e.charCode = newKey;
    }

    $("#serieReciboColegio").val(($("#serieReciboColegio").val()).toUpperCase());
});
$("#serieReciboTimbre").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        e.keyCode = newKey;
        e.charCode = newKey;
    }

    $("#serieReciboTimbre").val(($("#serieReciboTimbre").val()).toUpperCase());
});
function generarKardex(tipoV){
    $.post("Colegiado/generarKardex",{colegiado:$("#idusuario").val(), tipo: tipoV}, function(data, status){

    });
}


function mostrarConyugue() {
  if($('#estadoCivil').val() == 'C') {
    $('#conyugueDiv').fadeIn(100);
  } else {
    $('#conyugueDiv').fadeOut(100);
  }
}
