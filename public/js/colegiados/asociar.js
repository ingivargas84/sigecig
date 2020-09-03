var validator = $("#AsociarForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
	    	colegiado:{
            required: true,
            colegiadounico: true
        },
        fechaColegiado:{
            required: true
      },
        fechaUltimoPagoColegio:{
            required: true
      },
        fechaUltimoPagoTimbre:{
            required: true
      },
	},
	messages: {
        colegiado: {
            required: "Por favor, ingrese el número de colegiado"
        },
        fechaColegiado: {
            required: "Por favor, ingrese la fecha"
        },
        fechaUltimoPagoColegio: {
          required: "Campo requerido"
         },
        fechaUltimoPagoTimbre: {
          required: "Campo requerido"
          }
	}
});

$("#ButtonAsociar").click(function(event) {
  event.preventDefault();
	if ($("#AsociarForm").valid()) {
		asociarColegiado();
	} else {
		validator.focusInvalid();
	}
  }); 

$.validator.addMethod("colegiadounico", function(value, element){
  var valid = false;
  var urlActual = $("input[name='urlActual']").val();
  $.ajax({
      type: "GET",
      async: false,
      url: "/Aspirante/colDisponible/",
      data:"colegiado=" + value,
      dataType: "json",
      success: function (msg) {
          valid=!msg;
      }
  });
  return valid;
  }, "El número ya está registrado en el sistema");


$('#ingresoModal4').on('shown.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var dpi2 = button.data('dpi2');
    var nombre2 = button.data('nombre2');
      
    var modal = $(this);
    modal.find(".modal-body input[name='dpi2']").val(dpi2);
    modal.find(".modal-body input[name='nombre2']").val(nombre2);

   });
  
   function cambiarEndDate2(){
    var inicio=document.getElementById("fechaColegiado").value;
    
    var start=new Date(inicio);
    start.setMonth(start.getMonth()+3);
    var startf = start.toISOString().slice(0,10).replace(/-/g,"/");
    document.getElementById("fechaUltimoPagoColegio").value= startf;
    document.getElementById("fechaUltimoPagoTimbre").value= startf;
    }
  
if(window.location.hash === '#add')
{
  $('#ingresoModal4').modal('show');
}

$('#ingresoModal4').on('hide.bs.modal', function(){
  $("#AsociarForm").validate();
  document.getElementById("AsociarForm");
  window.location.hash = '#';
});

$('#ingresoModal4').on('shown.bs.modal', function(){
  window.location.hash = '#add';
});

   function asociarColegiado() {
    var invitacion = {
        'idusuario': $("#dpi2").val(),
        'colegiado': $("#colegiado").val(),
        'fechaColegiado': $("#fechaColegiado").val(),
        'fechaUltimoPagoColegio': $("#fechaUltimoPagoColegio").val(),
        'fechaUltimoPagoTimbre': $("#fechaUltimoPagoTimbre").val(),
    };
   // $("#password").val('');
    $.ajax({
      type: "POST",
      headers: {'X-CSRF-TOKEN': $('#tokenAs').val()},
      dataType:'JSON',
      url: "Aspirante/asociarColegiado",
      data: invitacion,
      success: function(data){
        if(data.error==0){
         /*  $("#mensajes").html("Colegiado asociado correctamente.");
          $("#mensajes").css({'color':'green'}); */
          $('#ingresoModal4').modal("hide");
          aspirantes_table.ajax.reload();
          alertify.set('notifier','position', 'top-center');
          alertify.success('Colegiado asociado correctamente');
          $('.loader').fadeOut(225);
          window.location.replace("/colegiados");

        } else if(data.error==2){
          $("#mensajes").html("Error de autenticación.");
          $("#mensajes").css({'color':'red'});
  
        } else if(data.error==3){
          $("#mensajes").html("Colegiado ya existente.");
          $("#mensajes").css({'color':'blue'});
  
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