
$(document).ready(function(){
    $("#c_cliente").keypress(function(e) {
      if(e.which == 13) {
        obtenerDatosColegiado();
      }
    });
});

function obtenerDatosColegiado()
{
  var valor = $("#c_cliente").val();

  $.ajax({
    type: 'GET',
    url:  '/colegiado/' + valor,
    success: function(response){
        if(response != ""){
            var D = new Date(response.f_ult_timbre);
            var d = D.getDate();
            var m = D.getMonth();
            var y = D.getFullYear();
            response.f_ult_timbre = d + '/' + m + '/' + y;

            var D = new Date(response.f_ult_pago);
            var d = D.getDate();
            var m = D.getMonth();
            var y = D.getFullYear();
            response.f_ult_pago = d + '/' + m + '/' + y;

            $("input[name='n_cliente']").val(response.n_cliente);
            $("input[name='estado']").val(response.estado);
            $("input[name='f_ult_timbre']").val(response.f_ult_timbre);
            $("input[name='f_ult_pago']").val(response.f_ult_pago);
        }else {
            alertify.error('Numero de colegiado no exite');
            $("#ReciboForm")[0].reset();
        }
    }
  });
}

$(document).ready(function(){
    $("#nit").keypress(function(e) {
      if(e.which == 13) {
        obtenerDatosEmpresa();
      }else {
        validator.focusInvalid();
      }
    });
});

function obtenerDatosEmpresa()
{
  var valor = $("#nit").val();

  $.ajax({
    type: 'GET',
    url:  '/empresa/' + valor,
    success: function(response){
        if(response != ""){
            $("input[name='empresa']").val(response.empresa);
        }else {
            alertify.error('NIT no existe');
            //$(".input").val('');
            $("#ReciboForm")[0].reset();
        }

    }
  });
}

