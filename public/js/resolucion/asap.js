function mostrarMensajeRechazo(mensaje) {
    $("#divmsg").empty();
    $("#divmsg").append("<p>"+mensaje+"</p>");
    $("#divmsg").show(500);
    $("#divmsg").hide(2000);
  }

  function mostrarMensajeAutorizacion(mensaje) {
    $("#divmsga").empty();
    $("#divmsga").append("<p>"+mensaje+"</p>");
    $("#divmsga").show(500);
    $("#divmsga").hide(2000);
  }


  function limpiarCampos() { 
      $('#mensaje').val('');
   }

$.ajaxSetup({
    headers:  {
        'X-CSRF-TOKEN': $("input[name=_token]").val()
}
});


$('#enviar').click(function (e) { 
    e.preventDefault();

    var texto = $("textarea[name=mensaje]").val();
    var solicitud = $("input[name=no_solicitud]").val();
    
   

    $.ajax({

        type: "POST",
        url: "/resolucion/rczdocumentosap",
        data: {texto:texto, solicitud:solicitud},
        
        success: function (data) {
            mostrarMensajeRechazo(data.mensaje);
           limpiarCampos();
    
        },
        error: function (jqXHR, estado, error){
            console.log(estado)
            console.log(error)
        }
    });
    
});

$('#ButtonAutorizar').click(function (e) { 
    e.preventDefault();

    var solicitud = $("input[name=no_solicitud]").val();
    
    $.ajax({

        type: "POST",
        url: "/resolucion/aprdocumentosap",
        data: { solicitud:solicitud},
        beforeSend: function(){
            $('fa').css('display','inline');
        },
        
        success: function (data) {
            mostrarMensajeAutorizacion(data.mensaje);
           limpiarCampos();
    
        },
        error: function (jqXHR, estado, error){
            console.log(estado)
            console.log(error)
        }
    });
    
});
