$.validator.addMethod("ntelc", function (value, element ){
    var valor = value.length;
    if(valor == 8)
    {
        return true;
    }
    else
    {
    return false;
    }
}, "Debe ingresar el número de teléfono con 8 dígitos");// validacion de telefono

$.validator.addMethod("ntelc1", function (value, element ){
    var valor = value.length;
    if(valor == 8)
    {
        return true;
    }
    else
    {
    return false;
    }
}, "Debe ingresar el número de teléfono con 8 dígitos");// validacion de telefono


function cuiIsValid(cui){
    var console = window.console;
    if (!cui) {
        console.log("CUI vacío");
        return true;
    }
    var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;
    if (!cuiRegExp.test(cui)) {
        console.log("CUI con formato inválido");
        return false;
    }
    cui = cui.replace(/\s/, '');
    var depto = parseInt(cui.substring(9, 11), 10);
    var muni = parseInt(cui.substring(11, 13));
    var numero = cui.substring(0, 8);
    var verificador = parseInt(cui.substring(8, 9));
    // Se asume que la codificación de Municipios y
    // departamentos es la misma que esta publicada en
    // http://goo.gl/EsxN1a
    // Listado de municipios actualizado segun:
    // http://goo.gl/QLNglm
    // Este listado contiene la cantidad de municipios
    // existentes en cada departamento para poder
    // determinar el código máximo aceptado por cada
    // uno de los departamentos.
    var munisPorDepto = [
        /* 01 - Guatemala tiene:      */ 17 /* municipios. */,
        /* 02 - El Progreso tiene:    */  8 /* municipios. */,
        /* 03 - Sacatepéquez tiene:   */ 16 /* municipios. */,
        /* 04 - Chimaltenango tiene:  */ 16 /* municipios. */,
        /* 05 - Escuintla tiene:      */ 13 /* municipios. */,
        /* 06 - Santa Rosa tiene:     */ 14 /* municipios. */,
        /* 07 - Sololá tiene:         */ 19 /* municipios. */,
        /* 08 - Totonicapán tiene:    */  8 /* municipios. */,
        /* 09 - Quetzaltenango tiene: */ 24 /* municipios. */,
        /* 10 - Suchitepéquez tiene:  */ 21 /* municipios. */,
        /* 11 - Retalhuleu tiene:     */  9 /* municipios. */,
        /* 12 - San Marcos tiene:     */ 30 /* municipios. */,
        /* 13 - Huehuetenango tiene:  */ 32 /* municipios. */,
        /* 14 - Quiché tiene:         */ 21 /* municipios. */,
        /* 15 - Baja Verapaz tiene:   */  8 /* municipios. */,
        /* 16 - Alta Verapaz tiene:   */ 17 /* municipios. */,
        /* 17 - Petén tiene:          */ 14 /* municipios. */,
        /* 18 - Izabal tiene:         */  5 /* municipios. */,
        /* 19 - Zacapa tiene:         */ 11 /* municipios. */,
        /* 20 - Chiquimula tiene:     */ 11 /* municipios. */,
        /* 21 - Jalapa tiene:         */  7 /* municipios. */,
        /* 22 - Jutiapa tiene:        */ 17 /* municipios. */
    ];
    if (depto === 0 || muni === 0)
    {
        console.log("CUI con código de municipio o departamento inválido.");
        return false;
    }
    if (depto > munisPorDepto.length)
    {
        console.log("CUI con código de departamento inválido.");
        return false;
    }
    if (muni > munisPorDepto[depto -1])
    {
        console.log("CUI con código de municipio inválido.");
        return false;
    }
    // Se verifica el correlativo con base
    // en el algoritmo del complemento 11.
    var total = 0;
    for (var i = 0; i < numero.length; i++)
    {
        total += numero[i] * (i + 2);
    }
    var modulo = (total % 11);
    console.log("CUI con módulo: " + modulo);
    return modulo === verificador;
}

$.validator.addMethod("dpi", function(value, element) {
    var valor = value;
    if (cuiIsValid(valor) == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}, "El CUI/DPI ingresado está incorrecto");

$.validator.addMethod("dpiunico", function(value, element){
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/Aspirante/dpiDisponible/",
        data:"dpi=" + value,
        dataType: "json",
        success: function (msg) {
            valid=!msg;
        }
    });
    return valid;
    }, "El CUI/DPI ya esta registrado en el sistema");

        var validator = $("#colegiadosForm").validate({
            ignore: [],
            onkeyup:false,
            rules: {
                nombres:{
              required: true,
                },
            apellidos:{
              required: true,
                    },
            telefono: {
              required : true,
              numero : true
                },
            dpi: {
              required : true,
              dpi : true,
              dpiunico : true
                },
            valDepartamentoNacimiento: {
                    required: true
                },
            fechaNacimiento: {
                    required: true
                },
            fechaGraduacion: {
              required: true
                },
            valMunicipioNacimiento: {
                    required: true
                },
            valPais: {
                    required: true
                },
            valNacionalidad: {
                    required: true
                },
            email: {
                    required: true
                },
            estadoCivil: {
                    required: true
                },
            direccion: {
                    required: true
                },
            zona: {
                    required: true
                },
            municipioc: {
                    required: true
                },
            fechagrad: {
                    required: true
                },
            nombreContactoEmergencia: {
                    required: true
                },
            telefonoContactoEmergencia: {
					required: true,
					ntelc : true
                    },
            telefono:{
              required: true,
              ntelc : true
                },
            valMunicipio:{
              required: true
              },
            valUniversidadGraduado:{
              required: true
              }
            },
            messages: {
            nombres: {
                    required: "Por favor, ingrese el nombre"
                },
            apellidos: {
                    required: "Por favor, ingrese el nombre"
                    },
            dpi: {
                    required: "Por favor, ingrese un número de CUI/DPI"
                    },
            valDepartamentoNacimiento: {
                    required: "Por favor, seleccione un departamento"
                },
            sexo: {
                    required: "Por favor, seleccione un sexo"
                    },
            telefono: {
                    required: "Por favor, ingrese el teléfono"
                },
            valMunicipioNacimiento: {
                    required: "Por favor, ingrese un municipio"
                },
            valPais: {
                    required: "Por favor, ingrese un pais"
                },
            valNacionalidad: {
                    required: "Por favor, ingrese una nacionalidad"
                },
            email: {
                    required: "Por favor, ingrese un corre electrónico"
                },
            estadoCivil: {
                    required: "Por favor, ingrese el estado civil"
                },
            direccion: {
                    required: "Por favor, ingrese una dirección"
                },
            zona: {
                    required: "Por favor, ingrese una zona"
                },
            municipioc: {
                    required: "Por favor, ingrese un municipio"
                },
            valUniversidadGraduado: {
              required: "Por favor, ingrese una universidad"
                },
            nombreContactoEmergencia: {
                    required: "Por favor, ingrese un nombre"
                },
            telefonoContactoEmergencia: {
                    required: "Por favor, ingrese un número"
                },
            fechaGraduacion: {
                    required: "Por favor, ingrese fecha"
                },
            fechaNacimiento: {
                    required: "Por favor, ingrese la fecha de nacimiento"
                },
            valMunicipio: {
              required: "Por favor, ingrese un municipio"
                }
            }
        });

$("#ButtonGuardarAspirante").click(function(event) {
	if ($('#colegiadosForm').valid()) {
        guardarAspiranteF();
	} else {
		validator.focusInvalid();
	}
}); 

function guardarAspiranteF() {
   

    $("#cleanButton").click();
    var carrera_afin = 0;
    
    if($('#ca').is(":checked")) {
      carrera_afin = 1;
    }
      var datos = {
      'idusuario': $("#dpi").val(),
      'nombres': $("#nombres").val(),
      'apellidos': $("#apellidos").val(),
      'sexo': $("#sexo").val(),
      'fechaNacimiento': $("#fechaNacimiento").val(),
      'idDepartamentoNacimiento': $("#idDepartamentoNacimiento").val(),
      'idMunicipioNacimiento': $("#idMunicipioNacimiento").val(),
      'idPaisNacimiento': $("#idPais").val(),
      'idNacionalidad': $("#idNacionalidad").val(),
      'telefono': $("#telefono").val(),
      'telTrabajo': $("#telTrabajo").val(),
      'email': $("#email").val(),
      'estadoCivil': $("#estadoCivil").val(),
      'direccion': $("#direccion").val(),
      'zona': $("#zona").val(),
      'idDepartamentoCasa': $("#idDepartamento").val(),
      'idMunicipioCasa': $("#idMunicipio").val(),
      'direccionTrabajo': $("#direccionTrabajo").val(),
      'zonaTrabajo': $("#zonaTrabajo").val(),
      'idDepartamentoTrabajo': $("#idDepartamentoTrabajo").val(),
      'idMunicipioTrabajo': $("#idMunicipioTrabajo").val(),
      'destino': $("#destino").val(),
      'fechaGraduacion': $("#fechaGraduacion").val(),
      'idUniversidadGraduado': $("#idUniversidadGraduado").val(),
      'idUniversidadIncorporado': $("#idUniversidadIncorporado").val(),
      'tituloTesis': $("#tituloTesis").val(),
      'telefonoContactoEmergencia': $("#telefonoContactoEmergencia").val(),
      'nombreContactoEmergencia': $("#nombreContactoEmergencia").val(), 
      'ca': carrera_afin
      };
      $("#colegiadosForm").validate;
      $('.loader').fadeIn();

      $.ajax({
          type: "POST",
          headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
          dataType:'JSON',
          url: "/Aspirante/setdatosaspirante",
          data: datos,
          success: function(data){
                  var idusuario = $("#idusuario").val();
                  $("#cleanButton").click();
          $("#mensajes").html("");
                  if(data.error==1){
            var html = "<ul>";
            $.each(data.infoError, function (index, item) {
              html += "<li>";
              $.each(item, function (index1, item1) {
                html += item1;
              });
              html += "</li>";
            });
            
            html += "</ul>";
                $("#mensajes").html(data.mensaje + html);
                $("#mensajes").css({'color':'red'});
            } else {
                $('.loader').fadeOut(225);
                window.location = "/aspirantes";
                alertify.set('notifier','position', 'top-center');
                alertify.success('Aspirante creado con Éxito!!');
                $("#mensajes").html("Datos guardados correctamente.");
          }
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
  
  
$("#valUniversidadGraduado").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listauniversidades", { valUniversidad: $('#valUniversidadGraduado').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idUniversidadGraduado").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idUniversidadGraduado").val(ui.item.value);
	}
});

$("#valUniversidadIncorporado").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listauniversidades", { valUniversidad: $('#valUniversidadIncorporado').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idUniversidadIncorporado").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idUniversidadIncorporado").val(ui.item.value);
	}
});

$("#valMunicipio").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listamunicipios", { valMunicipio: $('#valMunicipio').val(), idDepartamento: $('#idDepartamento').val(), idPais: $('#idPais').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idMunicipio").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idMunicipio").val(ui.item.value);
		setDepartamentoPais();
	}
});

$("#valDepartamento").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listadepartamentos", { valDepartamento: $('#valDepartamento').val(), idPais: $('#idPais').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idDepartamento").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idDepartamento").val(ui.item.value);
		$("#valMunicipio").val("");
		$("#idMunicipio").val("");
	}
});

$("#valPais").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPais').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPais").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idPais").val(ui.item.value);
	}
});

$("#valNacionalidad").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPais').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPais").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idNacionalidad").val(ui.item.value);
	}
});

function setDepartamentoPais() {
	var idMunicipio = $("#idMunicipio").val();
	var invitacion = {
		'idMunicipio': idMunicipio
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/General/departamentopais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valDepartamento").val(data.departamento);
						$("#idDepartamento").val(data.codigodepartamento);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function setPaisDelMunicipio() {
	var idDepartamento = $("#idDepartamento").val();
	var invitacion = {
		'idDepartamento': idDepartamento
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/General/pais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valMunicipio").val("");
						$("#idMunicipio").val("");
						$("#valPais").val(data.pais);
						$("#idPais").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}



$("#valMunicipioTrabajo").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listamunicipios", { valMunicipio: $('#valMunicipioTrabajo').val(), idDepartamento: $('#idDepartamentoTrabajo').val(), idPais: $('#idPaisTrabajo').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idMunicipioTrabajo").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idMunicipioTrabajo").val(ui.item.value);
		setDepartamentoPaisTrabajo();
	}
});

$("#valDepartamentoTrabajo").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listadepartamentos", { valDepartamento: $('#valDepartamentoTrabajo').val(), idPais: $('#idPaisTrabajo').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idDepartamentoTrabajo").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idDepartamentoTrabajo").val(ui.item.value);
		$("#valMunicipioTrabajo").val("");
		$("#idMunicipioTrabajo").val("");
	}
});

$("#valPaisTrabajo").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPaisTrabajo').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPaisTrabajo").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idPaisTrabajo").val(ui.item.value);
	}
});

function setDepartamentoPaisTrabajo() {
	var idMunicipio = $("#idMunicipioTrabajo").val();
	var invitacion = {
		'idMunicipio': idMunicipio
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/General/departamentopais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valDepartamentoTrabajo").val(data.departamento);
						$("#idDepartamentoTrabajo").val(data.codigodepartamento);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function setPaisDelMunicipioTrabajo() {
	var idDepartamento = $("#idDepartamentoTrabajo").val();
	var invitacion = {
		'idDepartamento': idDepartamento
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/General/pais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valMunicipioTrabajo").val("");
						$("#idMunicipioTrabajo").val("");
						$("#valPaisTrabajo").val(data.pais);
						$("#idPaisTrabajo").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}


$("#valMunicipioOtro").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listamunicipios", { valMunicipio: $('#valMunicipioOtro').val(), idDepartamento: $('#idDepartamentoOtro').val(), idPais: $('#idPaisOtro').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idMunicipioOtro").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idMunicipioOtro").val(ui.item.value);
		setDepartamentoPaisOtro();
	}
});

$("#valDepartamentoOtro").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listadepartamentos", { valDepartamento: $('#valDepartamentoOtro').val(), idPais: $('#idPaisOtro').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idDepartamentoOtro").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idDepartamentoOtro").val(ui.item.value);
		$("#valMunicipioOtro").val("");
		$("#idMunicipioOtro").val("");
	}
});

$("#valPaisOtro").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPaisOtro').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPaisOtro").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idPaisOtro").val(ui.item.value);
	}
});

function setDepartamentoPaisOtro() {
	var idMunicipio = $("#idMunicipioOtro").val();
	var invitacion = {
		'idMunicipio': idMunicipio
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/General/departamentopais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valDepartamentoOtro").val(data.departamento);
						$("#idDepartamentoOtro").val(data.codigodepartamento);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function setPaisDelMunicipioOtro() {
	var idDepartamento = $("#idDepartamentoOtro").val();
	var invitacion = {
		'idDepartamento': idDepartamento
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/General/pais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valMunicipioOtro").val("");
						$("#idMunicipioOtro").val("");
						$("#valPaisOtro").val(data.pais);
						$("#idPaisOtro").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

$("#valMunicipioNacimiento").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listamunicipios", { valMunicipio: $('#valMunicipioNacimiento').val(), idDepartamento: $('#idDepartamentoNacimiento').val(), idPais: $('#idPaisNacimiento').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idMunicipioNacimiento").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idMunicipioNacimiento").val(ui.item.value);
		setDepartamentoPaisNacimiento();
	}
});

$("#valDepartamentoNacimiento").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listadepartamentos", { valDepartamento: $('#valDepartamentoNacimiento').val(), idPais: $('#idPaisNacimiento').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idDepartamentoOtro").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idDepartamentoNacimiento").val(ui.item.value);
		$("#valMunicipioNacimiento").val("");
		$("#idMunicipioNacimiento").val("");
	}
});

$("#valPaisNacimiento").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPaisNacimiento').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPaisNacimiento").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idPaisNacimiento").val(ui.item.value);
	}
});

function setDepartamentoPaisNacimiento() {
	var idMunicipio = $("#idMunicipioNacimiento").val();
	var invitacion = {
		'idMunicipio': idMunicipio
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/General/departamentopais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valDepartamentoNacimiento").val(data.departamento);
						$("#idDepartamentoNacimiento").val(data.codigodepartamento);
            $("#valPais").val(data.pais);
						$("#idPais").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function setPaisDelMunicipioNacimiento() {
	var idDepartamento = $("#idDepartamentoNacimiento").val();
	var invitacion = {
		'idDepartamento': idDepartamento
	};
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "/General/pais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valMunicipioNacimiento").val("");
						$("#idMunicipioNacimiento").val("");
						$("#valPaisNacimiento").val(data.pais);
						$("#idPaisNacimiento").val(data.codigopais);
				}
		},
		error: function(response) {
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}