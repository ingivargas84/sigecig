 /* var validator = $("#ProfesionColForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		idprofesion:{
      profesionExist: true
        }
  },
	messages: {
    idprofesion: {
        required: "Profesion ya ingresadaa"
    }
  }
});


$.validator.addMethod("profesionExist", function(value, element){
  var valid = false;
  var urlActual = $("input[name='urlActual']").val();
  $.ajax({
      type: "GET",
      async: false,
      url: "/Aspirante/profExist/",
      data:"profesion=" + value,
      dataType: "json",
      success: function (msg) {
          valid=!msg;
      }
  });
  return valid;
  }, "Profesion ya ingresada"); */
 

  $('#ingresoModalColProf').on('shown.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var c_cliente = button.data('c_cliente');
    var nombre = button.data('nombre');
      
    var modal = $(this);
    modal.find(".modal-body input[name='colegiado']").val(c_cliente);
    modal.find(".modal-body input[name='nombre']").val(nombre);
   });

if(window.location.hash === '#add')
{
  $('#ingresoModalColProf').modal('show');
}

$('#ingresoModalColProf').on('hide.bs.modal', function(){
  $("#ProfesionColForm").validate().resetForm();
  document.getElementById("ProfesionColForm").reset();
  window.location.hash = '#';
});

$('#ingresoModalColProf').on('shown.bs.modal', function(){
  window.location.hash = '#add';
});

$("#ButtonAgregarProfesionCol").click(function(event) {
	if ($('#ProfesionColForm').valid()) {
    agregarProfesionColF();
	} else {
		validator.focusInvalid();
	}
}); 

function agregarProfesionColF() {
	var invitacion = {
		
    'idusuario': $("input[name='colegiado']").val(),
    'idprofesion': $("#idprofesion").val(),
	};
  $("#mensajes").html("");
  $('.loader').fadeIn();

	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "colegiado/setDatosProfesionalesColegiado",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
      if(data.retorno==0) {
        $("#mensajes").html("Profesión guardada correctamenteeee.");
        $("#mensajes").css({'color':'green'});
        getDatosProfesionales("P");
      } else if(data.retorno==1) {
        $("#mensajes").html("Profesión ya presente.");
        $("#mensajes").css({'color':'red'});
      } else {
        var a = "Error en el sistema.";
        if(data.hasOwnProperty("mensaje")) {
          a += " " + data.mensaje;
        }
        $("#mensajes").html(a);
        $("#mensajes").css({'color':'red'});
      }
        $('.loader').fadeOut(225);
        $('#ingresoModalColProf').modal("hide");
        alertify.set('notifier','position', 'top-center');
        alertify.success('Profesión agregada con Éxito!!');
        //colegiados_table.ajax.reload();
		},
		error: function(response) {
				$("#mensajes").html("Error en el sistema.");
        $("#mensajes").css({'color':'red'});
		}
	});
}
  

$("#ButtonAgregarEspecialidadCol").click(function(event) {
	if ($('#ProfesionColForm').valid()) {
    agregarEspecialidadColF();
	} else {
		validator.focusInvalid();
	}
}); 

function agregarEspecialidadColF() {
	var invitacion = {
		'idespecialidad': $("#idespecialidad").val(),
    'idusuario': $("input[name='colegiado']").val(),
	};
  $("#mensajes").html("");
  $('.loader').fadeIn();
	$.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
		dataType:'JSON',
		url: "colegiado/setDatosEspecialidadesColegiado",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
      if(data.retorno==0) {
        $("#mensajes").html("Especialidad guardada correctamente.");
        $("#mensajes").css({'color':'green'});
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
      $('.loader').fadeOut(225);
      $('#ingresoModalColProf').modal("hide");
      alertify.set('notifier','position', 'top-center');
      alertify.success('Especialidad agregada con Éxito!!');
    //  colegiados_table.ajax.reload();
      
		},
		error: function(response) {
				$("#mensajes").html("Error en el sistema.");
        $("#mensajes").css({'color':'red'});
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
          'idusuario': $("#c_cliente").val(),
      'tipo': tipo
      };
      $.ajax({
          type: "POST",
          headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
          dataType:'JSON',
          url: "colegiado/getDatosProfesionalesColegiado",
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
