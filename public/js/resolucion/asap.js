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
    var solicitud = $("input[name=id_solicitud]").val();
    


    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $("input[name=_token]").val()},
        url: "/resolucion/rczdocumentosap",
        data: {texto:texto, solicitud:solicitud},
        beforeSend:function () {
            $('.loader').show();
            $('#ventana1').modal("hide");
          },
        success: function (data) {
            alertify.set('notifier','position', 'top-center');
            alertify.success('Resgistrado Correctamente');
            window.location.href = "/resolucion";
        },
        error: function (jqXHR, estado, error){
            console.log(estado)
            console.log(error)
        }
    }).always(function () {
        $('.loader').hide();

    });
    
});

$('#ButtonAutorizar').click(function (e) { 
    e.preventDefault();

    var solicitud = $("input[name=id_solicitud]").val();
    
    $.ajax({

        type: "POST",
        url: "/resolucion/aprdocumentosap",
        data: { solicitud:solicitud},
        beforeSend: function(){
            $('fa').css('display','inline');
            $('.loader').show();
            $('#modalAprobacionJunta').modal("hide");
        },
        
        success: function (data) {
           limpiarCampos();
           alertify.set('notifier','position', 'top-center');
           alertify.success('Resgistrado Correctamente');
           window.location.href = "/resolucion";
        },
        error: function (jqXHR, estado, error){
            console.log(estado)
            console.log(error)
        }
    }).always(function (data) {
        $('.loader').hide();       
    });
    
});



  $('#solicitud_pdf').click(function (e) { 
      e.preventDefault();
      $('#solicitudpdf').toggle();
      $('.fn1').toggleClass('fondo1');
      
  });

  
  $('#dpi_pdf').click(function (e) { 
    e.preventDefault();
    $('#dpipdf').toggle();
    $('.fn2').toggleClass('fondo1');
});