function mostrarMensajeRechazo(mensaje) {
    alertify.set('notifier','position', 'bottom-center');
    alertify.success(mensaje);
    
  }

  function mostrarMensajeAutorizacion(mensaje) {
    alertify.set('notifier','position', 'bottom-center');
    alertify.success(mensaje);
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
    }).always(function (data) {
        $('#ventana1').modal("hide");
        resolucion_table.ajax.reload();
       
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
    }).always(function (data) {
        $('#modalAprobacionJunta').modal("hide");
        resolucion_table.ajax.reload();
       
    });
    
});
