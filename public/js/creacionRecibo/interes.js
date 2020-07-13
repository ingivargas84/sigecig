
// $(document).ready(function(){
//     $("#c_cliente").keypress(function(e) {
//       if(e.which == 13) {
//         obtenerDatosColegiado();
//       }
//     });
// });

function obtenerDatosColegiado()
{
  var valor = $("#c_cliente").val();

  $.ajax({
    type: 'GET',
    url:  '/colegiado/' + valor,
    success: function(response){
        if(response[0] != ""){
            var D = new Date(response[0].f_ult_timbre);
            var d = D.getDate();
            var m = D.getMonth()+1;
            var y = D.getFullYear();
            if(d<10){d='0'+d;}
            if(m<10){m='0'+m;}
            response[0].f_ult_timbre = d + '/' + m + '/' + y;
            // document.getElementById('f_ult_timbre').value=y+"-"+m+"-"+d;

            var D = new Date(response[0].f_ult_pago);
            var d = D.getDate();
            var m = D.getMonth()+1;
            var y = D.getFullYear();
            if(d<10){d='0'+d;}
            if(m<10){m='0'+m;}
            response[0].f_ult_pago = d + '/' + m + '/' + y;
             document.getElementById('f_ult_pago').value=y+"/"+m+"/"+d;


            if (response[0].fallecido == 'N'){
            } else if(response[0].fallecido == 'S'){
                response[0].estado = 'Fallecido'
            }

            var monto_timbre = parseFloat(response[0].monto_timbre);

            $("input[name='n_cliente']").val(response[0].n_cliente);
            $("input[name='estado']").val(response[0].estado);
            //$("input[name='f_ult_timbre']").val(response[0].f_ult_timbre);
            //$("input[name='f_ult_pago']").val(response[0].f_ult_pago);
            $("input[name='monto_timbre']").val(monto_timbre.toFixed(2));

            var date = new Date();
            var ultdia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            var d = ultdia.getDate();
            var m = ultdia.getMonth()+1;
            var y = ultdia.getFullYear();
            fecha_pago = d + '-' + m + '-' + y;
            if(d<10){d='0'+d;}
            if(m<10){m='0'+m;}
            document.getElementById('fecha_pago').value=y+"-"+m+"-"+d;

            if ($('#estado').val()== 'Inactivo' || $('#estado').val()== 'Fallecido'){
                $('#estado').css({'color':'red'});
            }else{
                $('#estado').css({'color':'green'});
            }

        }else {
            alertify.warning('Numero de colegiado no exite');
            $("#ReciboForm")[0].reset();
        }
    }
  });
}

// $( "#c_cliente" ).change(function() {
function get_monto_atrasado_timbre() {
    //var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
    var exonerarInteresesTimbre = 0;
    if($('#exonerarInteresesTimbre').is(":checked")) {
        exonerarInteresesTimbre = 1;
    }
    var invitacion = {
        //'_token': tok._token,
        'colegiado': $("#c_cliente").val(),
        'fecha_timbre': $("#f_ult_timbre").val(),
        'fecha_colegio': $("#f_ult_pago").val(),
        'fecha_hasta_donde_paga': $("#fecha_pago").val(),
        'monto_timbre': $("#monto_timbre").val(),
        'exonerar_intereses_timbre': exonerarInteresesTimbre
    };
    $.ajax({
        type: "POST",
        dataType:'JSON',
        url: "getMontoReactivacion",
        data: invitacion,
        success: function(data){
            if(data.error==1){
                $("#mensajes").html("Ningún dato encontrado.");
                $("#mensajes").css({'color':'red'});
            } else {
                $("#capitalColegio").val(data.capitalColegio);
                $("#capitalTimbre").val(data.capitalTimbre);
                $("#numeroCuotasTimbre").val(data.cuotasTimbre);
                $("#numeroCuotasColegio").val(data.cuotasColegio);
                $("#moraTimbre").val(data.moraTimbre);
                $("#interesTimbre").val(data.interesTimbre);
                $("#interesColegio").val(data.interesColegio);
                $("#total").val((data.total).toFixed(2));
            }
        },
        error: function(response) {
                $("#mensajes").html("Error en el sistema.");
        }
    });
}
