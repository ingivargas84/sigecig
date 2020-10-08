
$(document).ready(function(){
    $("input[name='numeroColegiado']").keypress(function(e) {
      if(e.which == 13) {
        obtenerDatosColegiado();
      }
    });
});

function obtenerDatosColegiado()
{
  var valor = $("input[name='numeroColegiado']").val();

  $.ajax({
    type: 'GET',
    url:  '/colegiado/' + valor,
    success: function(response){
        if(response[0] != ""){
            var D = response[0].f_ult_timbre;
            var nuevaT=D.split(" ")[0].split("-").reverse().join("/");
            // response[0].f_ult_timbre = nueva;

            var D = response[0].f_ult_pago;
            var nuevaC=D.split(" ")[0].split("-").reverse().join("/");
            // response[0].f_ult_pago = nueva;

            var D = new Date(response[0].f_ult_pago);
            var d = D.getDate();
            var m = D.getMonth()+1;
            var y = D.getFullYear();
            if(d<10){d='0'+d;}
            if(m<10){m='0'+m;}
            response[0].f_ult_pago = y + '/' + m + '/' + d;

            if (response[0].fallecido == 'N'){
            } else if(response[0].fallecido == 'S'){
                response[0].estado = 'Fallecido'
            }

            var monto_timbre = parseFloat(response[0].monto_timbre);

            $("input[name='n_cliente']").val(response[0].n_cliente);
            $("input[name='estado']").val(response[0].estado);
            $("input[name='f_ult_timbre']").val(nuevaT);
            $("input[name='fechaTimbre']").val(response[0].f_ult_timbre);
            $("input[name='f_ult_pago']").val(nuevaC);
            $("input[name='fechaColegio']").val(response[0].f_ult_pago);
            $("input[name='emailC']").val(response[0].e_mail);
            $("input[name='monto_timbre']").val('Q.'+monto_timbre.toFixed(2));

            if ($('#estado').val()== 'Inactivo' || $('#estado').val()== 'Fallecido'){
                $('#estado').css({'color':'red'});
            }else{
                $('#estado').css({'color':'green'});
            }

            var estado = $("#estado").val();
            if (estado == 'Inactivo'){
                var date = new Date();
                var ultdia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                var d = ultdia.getDate();
                var m = ultdia.getMonth()+1;
                var y = ultdia.getFullYear();
                fecha_pago = d + '-' + m + '-' + y;
                if(d<10){d='0'+d;}
                if(m<10){m='0'+m;}
                document.getElementById('fecha_pago').value=y+"-"+m+"-"+d;


            }

        }else {
            alertify.warning('Numero de colegiado no exite');
            $("#ReciboForm")[0].reset();
        }
    }
  });
    $('select[name="codigo"]').val('');
    $('input[type="text"]').val('');
    $('input[type="date"]').val('');
    $('input[name="efectivo"]').val('');
    $('input[name="cheque"]').val('');
    $('input[name="montoCheque"]').val('');
    $('input[name="tarjeta"]').val('');
    $('input[name="montoTarjeta"]').val('');
    $("tbody").children().remove();
    $('input[name="tipoDePago"]').prop('checked', false);
    comprobarCheckEfectivo();
    comprobarCheckCheque();
    comprobarCheckTarjeta();
    comprobarCheckDeposito();
    limpiarTimbres();
}

function limpiarPantallaColegiado()
{
    $('select[name="codigo"]').val('');
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');
    $('input[name="efectivo"]').val('');
    $('input[name="cheque"]').val('');
    $('input[name="montoCheque"]').val('');
    $('input[name="tarjeta"]').val('');
    $('input[name="montoTarjeta"]').val('');
    $('input[name="emailC"]').val('');
    $("tbody").children().remove();
    $('input[name="tipoDePago"]').prop('checked', false);
    document.getElementById('existencia').style.display = "none";$('#existencia').val('');
    document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
    document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
    comprobarCheckEfectivo();
    comprobarCheckCheque();
    comprobarCheckTarjeta();
    comprobarCheckDeposito();
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
            $("input[name='emailP']").val(response.e_mail);
        }else {
            alertify.warning('NIT no existe');
            $('input[type="text"]').val('');
            $('input[type="number"]').val('');
        }

    }
  });
  $('select[name="codigoE"]').val('');
    $('input[type="number"]').val('');
    $('input[name="efectivoE"]').val('');
    $('input[name="chequeE"]').val('');
    $('input[name="montoChequeE"]').val('');
    $('input[name="tarjetaE"]').val('');
    $('input[name="montoTarjetaE"]').val('');
    $("tbody").children().remove()
}

$(document).ready(function () {
    $("input[name$='serieRecibo']").click(function() {
        limpiarFilaDetalle();
        limpiarFilaDetalleE();
        limpiarFilaDetalleP();
        limpiarTimbres();
    });
});

function todoNuevo() {
    window.location.href = window.location.href;
}



function getTimbres(selected, cantidad){
    var indicador = selected.split(" ", 1);
    indicador = indicador[0];
    var user = $('#rol_user').val();
    if (indicador.substring(0,2) == 'TC' || indicador.substring(0,2) == 'TE' || indicador.substring(0,3) == 'TIM'){
        $.ajax({
            type: "POST",
            url: "/consultaTimbres",
            data: {indicador, user, cantidad},
            dataType: 'json',
            success: function(response){
                if (indicador == 'TIM1' || indicador == 'TE01'){
                    document.getElementById('datoTc01').style.display = "";document.getElementById('datoTc01E').style.display = "";document.getElementById('datoTc01P').style.display = "";
                    $('#tc01').val(response);$('#tc01E').val(response);$('#tc01P').val(response);
                }
                if (indicador == 'TIM5' || indicador == 'TE05'){
                    document.getElementById('datoTc05').style.display = "";document.getElementById('datoTc05E').style.display = "";document.getElementById('datoTc05P').style.display = "";
                    $('#tc05').val(response);$('#tc05E').val(response);$('#tc05P').val(response);
                }
                if (indicador == 'TIM10' || indicador == 'TE10'){
                    document.getElementById('datoTc10').style.display = "";document.getElementById('datoTc10E').style.display = "";document.getElementById('datoTc10P').style.display = "";
                    $('#tc10').val(response);$('#tc10E').val(response);$('#tc10P').val(response);
                }
                if (indicador == 'TIM20' || indicador == 'TE20'){
                    document.getElementById('datoTc20').style.display = "";document.getElementById('datoTc20E').style.display = "";document.getElementById('datoTc20P').style.display = "";
                    $('#tc20').val(response);$('#tc20E').val(response);$('#tc20P').val(response);
                }
                if (indicador == 'TIM50' || indicador == 'TE50'){
                    document.getElementById('datoTc50').style.display = "";document.getElementById('datoTc50E').style.display = "";document.getElementById('datoTc50P').style.display = "";
                    $('#tc50').val(response);$('#tc50E').val(response);$('#tc50P').val(response);
                }
                if (indicador == 'TIM100' || indicador == 'TE100'){
                    document.getElementById('datoTc100').style.display = "";document.getElementById('datoTc100E').style.display = "";document.getElementById('datoTc100P').style.display = "";
                    $('#tc100').val(response);$('#tc100E').val(response);$('#tc100P').val(response);
                }
                if (indicador == 'TIM200' || indicador == 'TE200'){
                    document.getElementById('datoTc200').style.display = "";document.getElementById('datoTc200E').style.display = "";document.getElementById('datoTc200P').style.display = "";
                    $('#tc200').val(response);$('#tc200E').val(response);$('#tc200P').val(response);
                }
                if (indicador == 'TIM500' || indicador == 'TE500'){
                    document.getElementById('datoTc500').style.display = "";document.getElementById('datoTc500E').style.display = "";document.getElementById('datoTc500P').style.display = "";
                    $('#tc500').val(response);$('#tc500E').val(response);$('#tc500P').val(response);
                }
            },
            error: function(response){
                var mensaje = response.responseJSON["mensaje"];
                var timbre = response.responseJSON["timbre"];
                alertify.set('notifier','position', 'top-center');
                alertify.warning(mensaje);

                if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
                if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
                if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}

                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == timbre)){
                                $(celdas).closest('tr').remove();
                            }
                        }

                getTotal(); getTotalE(); getTotalP();
                if (timbre == 'TIM1' || timbre == 'TE01'){
                    document.getElementById('datoTc01').style.display = "none";document.getElementById('datoTc01E').style.display = "none";document.getElementById('datoTc01P').style.display = "none";
                    $('#tc01').val('');$('#tc01E').val('');$('#tc01P').val('');
                }
                if (timbre == 'TIM5' || timbre == 'TE05'){
                    document.getElementById('datoTc05').style.display = "none";document.getElementById('datoTc05E').style.display = "none";document.getElementById('datoTc05P').style.display = "none";
                    $('#tc05').val('');$('#tc05E').val('');$('#tc05P').val('');
                }
                if (timbre == 'TIM10' || timbre == 'TE10'){
                    document.getElementById('datoTc10').style.display = "none";document.getElementById('datoTc10E').style.display = "none";document.getElementById('datoTc10P').style.display = "none";
                    $('#tc10').val('');$('#tc10E').val('');$('#tc10P').val('');
                }
                if (timbre == 'TIM20' || timbre == 'TE20'){
                    document.getElementById('datoTc20').style.display = "none";document.getElementById('datoTc20E').style.display = "none";document.getElementById('datoTc20P').style.display = "none";
                    $('#tc20').val('');$('#tc20E').val('');$('#tc20P').val('');
                }
                if (timbre == 'TIM50' || timbre == 'TE50'){
                    document.getElementById('datoTc50').style.display = "none";document.getElementById('datoTc50E').style.display = "none";document.getElementById('datoTc50P').style.display = "none";
                    $('#tc50').val('');$('#tc50E').val('');$('#tc50P').val('');
                }
                if (timbre == 'TIM100' || timbre == 'TE100'){
                    document.getElementById('datoTc100').style.display = "none";document.getElementById('datoTc100E').style.display = "none";document.getElementById('datoTc100P').style.display = "none";
                    $('#tc100').val('');$('#tc100E').val('');$('#tc100P').val('');
                }
                if (timbre == 'TIM200' || timbre == 'TE200'){
                    document.getElementById('datoTc200').style.display = "none";document.getElementById('datoTc200E').style.display = "none";document.getElementById('datoTc200P').style.display = "none";
                    $('#tc200').val('');$('#tc200E').val('');$('#tc200P').val('');
                }
                if (timbre == 'TIM500' || timbre == 'TE500'){
                    document.getElementById('datoTc500').style.display = "none";document.getElementById('datoTc500E').style.display = "none";document.getElementById('datoTc500P').style.display = "none";
                    $('#tc500').val('');$('#tc500E').val('');$('#tc500P').val('');
                }

            }
        });
    }
}

// inicia datos colegiado

$(document).ready(function(){
    $("input[name$='serieRecibo']").change(function() {
        cambioSerie();
    });
});

$(document).ready(function(){
    $("input[name$='tipoCliente']").change(function() {
        cambioSerie();
    });
});

function cambioSerie () {
    $("select[name='codigo']").empty();
    $("select[name='codigoE']").empty();
    $("select[name='codigoP']").empty();
        $("tbody").children().remove();
        getTotal();
        var stateID = $("input[name$='serieRecibo']").val();
        var datoSelected = $('input[name=tipoCliente]:checked').val();
        if(document.getElementById("serieReciboA").checked) {
            if ($('#aspirante').prop('checked') != true) {
                $.ajax({
                    type: "GET",
                    url: '/tipo/ajax/A',
                    data: {stateID, datoSelected},
                    dataType: "json",
                    success:function(data) {
                        // $("#codigo").empty();
                        if ($('input[name=tipoCliente]:checked').val() == 'c') {
                            $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                            $('#codigo').append( '<option value="">-- Escoja --</option>' );
                            $("#codigo").selectpicker('refresh');
                            for (i = 0; i < data.length; i++)
                            {
                                $('#codigo').selectpicker('refresh').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["tipo_de_pago"]+'</option>' ).selectpicker('refresh').trigger('change');
                            }
                        }else if ($('input[name=tipoCliente]:checked').val() == 'e') {
                            $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                            $('#codigoE').append( '<option value="">-- Escoja --</option>' );
                            $("#codigoE").selectpicker('refresh');
                            for (i = 0; i < data.length; i++)
                            {
                                $('#codigoE').selectpicker('refresh').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["tipo_de_pago"]+'</option>' ).selectpicker('refresh').trigger('change');
                            }
                        }else if ($('input[name=tipoCliente]:checked').val() == 'p') {
                            $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                            $('#codigoP').append( '<option value="">-- Escoja --</option>' );
                            $("#codigoP").selectpicker('refresh');
                            for (i = 0; i < data.length; i++)
                            {
                                $('#codigoP').selectpicker('refresh').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["tipo_de_pago"]+'</option>' ).selectpicker('refresh').trigger('change');
                            }
                        }
                    }
                });
            } else {
                var stateID = 'a';
                $.ajax({
                    type: "GET",
                    url: '/tipo/ajax/aspirante',
                    data: {stateID, datoSelected},
                    dataType: "json",
                    success:function(data) {
                        $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                        $('#codigoP').append( '<option value="">-- Escoja --</option>' );
                        $("#codigoP").selectpicker('refresh');
                        for (i = 0; i < data.length; i++)
                        {
                            $('#codigoP').selectpicker('refresh').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["tipo_de_pago"]+'</option>' ).selectpicker('refresh').trigger('change');
                        }
                    }
                });
            }
        }else if(document.getElementById("serieReciboB").checked) {
            if ($('#aspirante').prop('checked') != true) {
                $.ajax({
                    type: "GET",
                    url: '/tipo/ajax/B',
                    data: {stateID, datoSelected},
                    dataType: "json",
                    success:function(data) {
                        // $("#codigo").empty();
                        if ($('input[name=tipoCliente]:checked').val() == 'c') {
                            $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                            $('#codigo').append( '<option value="">-- Escoja --</option>' );
                            $("#codigo").selectpicker('refresh');
                            for (i = 0; i < data.length; i++)
                            {
                                $('#codigo').selectpicker('refresh').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["tipo_de_pago"]+'</option>' ).selectpicker('refresh').trigger('change');
                            }
                        }else if ($('input[name=tipoCliente]:checked').val() == 'e') {
                            $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                            $('#codigoE').append( '<option value="">-- Escoja --</option>' );
                            $("#codigoE").selectpicker('refresh');
                            for (i = 0; i < data.length; i++)
                            {
                                $('#codigoE').selectpicker('refresh').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["tipo_de_pago"]+'</option>' ).selectpicker('refresh').trigger('change');
                            }
                        }else if ($('input[name=tipoCliente]:checked').val() == 'p') {
                            $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                            $('#codigoP').append( '<option value="">-- Escoja --</option>' );
                            $("#codigoP").selectpicker('refresh');
                            for (i = 0; i < data.length; i++)
                            {
                                $('#codigoP').selectpicker('refresh').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["tipo_de_pago"]+'</option>' ).selectpicker('refresh').trigger('change');
                            }
                        }
                    }
                });
            } else {
                var stateID = 'b';
                $.ajax({
                    type: "GET",
                    url: '/tipo/ajax/aspirante',
                    data: {stateID, datoSelected},
                    dataType: "json",
                    success:function(data) {
                        $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                        $('#codigoP').append( '<option value="">-- Escoja --</option>' );
                        $("#codigoP").selectpicker('refresh');
                        for (i = 0; i < data.length; i++)
                        {
                            $('#codigoP').selectpicker('refresh').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["tipo_de_pago"]+'</option>' ).selectpicker('refresh').trigger('change');
                        }
                    }
                });
            }
        }
}

$(document).ready(function () {
    $("#codigo").change (function () {
        $("input[name='precioU']").prop('disabled', true);
        var valor = $("#codigo").val();
        if(document.getElementById("serieReciboA").checked == true){
            //limpiarFilaDetalle();
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoA/' + valor,
                success: function(response){
                    if($("#codigo").val() != ""){
                        if ($("#codigo").val() == 57){ //el 57 representa el id de tipo de pago que realiza el calculo de colegiatura
                            if ($('#estado').val() == 'Activo' || $('#estado').val() == 'Fallecido'){
                                $("input[name='precioU']").val('Q.'+response.precio_colegiado.toFixed(2));
                                $("input[name='descTipoPago']").val(response.tipo_de_pago);
                                $("input[name='subtotal']").val('Q.'+response.precio_colegiado.toFixed(2));
                                $("input[name='categoria_id']").val(response.categoria_id);

                                $("#cantidad").val(1);
                            }else if($('#estado').val() == 'Inactivo'){
                                alertify.success("calculo de Interes");

                                var invitacion = {
                                    'colegiado': $("input[name='numeroColegiado']").val(),
                                    'fecha_timbre': $("#f_ult_timbre").val(),
                                    'fecha_colegio': $("#fechaColegio").val(),
                                    'fecha_hasta_donde_paga': $("#fecha_pago").val(),
                                    'monto_timbre': $("#monto_timbre").val(),
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
                                            $("#codigo").val(47); //el 47 es el codigo de interes del colegiado
                                            $("#cantidad").val(1);
                                            $("#precioU").val('Q.'+data.interesColegio.toFixed(2));
                                            $("#descTipoPago").val('pago de Interés de Colegiatura');
                                            $("#subtotal").val('Q.'+data.interesColegio.toFixed(2));
                                            addnewrow();

                                            $("#codigo").val(11); //el 11 es el codigo de cuotas a pagar del colegiado
                                            $("#cantidad").val(data.cuotasColegio);
                                            $("#precioU").val('Q.115.75');
                                            $("#descTipoPago").val('pago de Capital de Colegiatura');
                                            $("#subtotal").val('Q.'+data.capitalColegio.toFixed(2));
                                            addnewrow();

                                            limpiarFilaDetalle();
                                        }
                                    },
                                    error: function(response) {
                                            $("#cleanButton").click();
                                            $("#status").css({'color':'red'});
                                            $("#mensajes").html("Error en el sistema.");
                                    }
                                });
                            }
                        }else {

                            if (response.precio_colegiado == 0){
                                $("input[name='precioU']").prop('disabled', false).val('');
                                $("input[name='descTipoPago']").val(response.tipo_de_pago);
                                $("input[name='subtotal']").val('Q.'+response.precio_colegiado.toFixed(2));
                                $("input[name='categoria_id']").val(response.categoria_id);

                                $("#cantidad").val(1);

                            }else {

                                $("input[name='precioU']").val('Q.'+response.precio_colegiado.toFixed(2));
                                $("input[name='descTipoPago']").val(response.tipo_de_pago);
                                $("input[name='subtotal']").val('Q.'+response.precio_colegiado.toFixed(2));
                                $("input[name='categoria_id']").val(response.categoria_id);

                                $("#cantidad").val(1);

                            }
                        }
                    }
                },
                error: function() {
                        $("input[name='cantidad']").val(1);
                        $("input[name='precioU']").val('');
                        $("input[name='descTipoPago']").val('');
                        $("input[name='subtotal']").val('');
                        $("input[name='categoria_id']").val('');
                }
            });
        }else if(document.getElementById("serieReciboB").checked == true){
            //limpiarFilaDetalle();
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoB/' + valor,
                success: function(response){
                    if($("#codigo").val() != ""){
                        if ($("#codigo").val() == 56){ //el 56 representa el id de tipo de pago que realiza el calculo de interes
                            if ($('#estado').val() == 'Activo' || $('#estado').val() == 'Fallecido'){
                                $("input[name='precioU']").val('Q.'+response.precio_colegiado.toFixed(2));
                                $("input[name='descTipoPago']").val(response.tipo_de_pago);
                                $("input[name='subtotal']").val('Q.'+response.precio_colegiado.toFixed(2));
                                $("input[name='categoria_id']").val(response.categoria_id);
                                consultaTimbre();

                                $("#cantidad").val(1);
                            }else if($('#estado').val() == 'Inactivo'){
                                alertify.success("calculo de Interes");

                                var invitacion = {
                                    'colegiado': $("input[name='numeroColegiado']").val(),
                                    'fecha_timbre': $("#f_ult_timbre").val(),
                                    'fecha_colegio': $("#f_ult_pago").val(),
                                    'fecha_hasta_donde_paga': $("#fecha_pago").val(),
                                    'monto_timbre': $("#monto_timbre").val(),
                                    //'exonerar_intereses_timbre': exonerarInteresesTimbre
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
                                            $("#codigo").val(47); //el 47 es el codigo de interes del timbre
                                            $("#cantidad").val(1);
                                            $("#precioU").val('Q.'+data.interesTimbre.toFixed(2));
                                            $("#descTipoPago").val('pago de Interés de Timbre');
                                            $("#subtotal").val('Q.'+data.interesTimbre.toFixed(2));
                                            addnewrow();

                                            $("#codigo").val(48); //el 48 es el codigo dla mora del timbre
                                            $("#cantidad").val(1);
                                            $("#precioU").val('Q.'+data.moraTimbre.toFixed(2));
                                            $("#descTipoPago").val('pago de Mora de Timbre');
                                            $("#subtotal").val('Q.'+data.moraTimbre.toFixed(2));
                                            addnewrow();

                                            $("#codigo").val(58); //el 58 es el codigo de cuotas a pagar del timbre
                                            $("#cantidad").val(data.cuotasTimbre);
                                            $("#precioU").val($('#monto_timbre').val());
                                            $("#descTipoPago").val('pago de Capital de Timbre');
                                            $("#subtotal").val('Q.'+data.capitalTimbre.toFixed(2));
                                            var indicador = data.capitalTimbre;
                                            mensualidadTimbre(indicador);
                                            addnewrow();

                                            limpiarFilaDetalle();
                                        }
                                    },
                                    error: function(response) {
                                            $("#cleanButton").click();
                                            $("#status").css({'color':'red'});
                                            $("#mensajes").html("Error en el sistema.");
                                    }
                                });
                            }
                        }else{

                            if ($("#codigo").val() == 62){
                                $("input[name='precioU']").val($('#monto_timbre').val());
                                $("input[name='descTipoPago']").val(response.tipo_de_pago);
                                $("input[name='subtotal']").val($('#monto_timbre').val());
                                $("input[name='categoria_id']").val(response.categoria_id);

                                $("#cantidad").val(1);
                                consultaTimbre();
                            }else {

                                if (response.precio_colegiado == 0){
                                    $("input[name='precioU']").prop('disabled', false).val('');
                                    $("input[name='descTipoPago']").val(response.tipo_de_pago);
                                    $("input[name='subtotal']").val('Q.'+response.precio_colegiado.toFixed(2));
                                    $("input[name='categoria_id']").val(response.categoria_id);

                                    $("#cantidad").val(1);
                                    consultaTimbre();
                                }else {

                                    $("input[name='precioU']").val('Q.'+response.precio_colegiado.toFixed(2));
                                    $("input[name='descTipoPago']").val(response.tipo_de_pago);
                                    $("input[name='subtotal']").val('Q.'+response.precio_colegiado.toFixed(2));
                                    $("input[name='categoria_id']").val(response.categoria_id);

                                    $("#cantidad").val(1);
                                    consultaTimbre();
                                }
                            }
                        }
                    }
                },
                error: function() {
                        $("input[name='cantidad']").val(1);
                        $("input[name='precioU']").val('');
                        $("input[name='descTipoPago']").val('');
                        $("input[name='subtotal']").val('');
                        $("input[name='categoria_id']").val('');
                }
            });
        }
        if (valor == ''){
            document.getElementById('existencia').style.display = "none";$('#existencia').val('');
            document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
            document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
        }
    });
});

function consultaTimbre(){
    // var combo = document.getElementById("codigo");
    // var selected = combo.options[combo.selectedIndex].text;
    var selected = $("#codigo option:selected").text();
    if (selected == '') { selected = $("#codigoE option:selected").text(); }
    if (selected == '') { selected = $("#codigoP option:selected").text(); }
    // if (selected == '-- Escoja --'){var combo = document.getElementById("codigoE");var selected = combo.options[combo.selectedIndex].text;}
    // if (selected == '-- Escoja --'){var combo = document.getElementById("codigoP");var selected = combo.options[combo.selectedIndex].text;}
    if (selected.substring(0,2) == 'TC' || selected.substring(0,2) == 'TE' || selected.substring(0,3) == 'TIM'){
        var user = $('#rol_user').val();
        var codigo = $('#codigo').val();
        if (codigo == null){codigo = $('#codigoE').val();}
        if (codigo == null){codigo = $('#codigoP').val();}
        var nombre = selected.split(" ", 1);
        nombre = nombre[0];
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: "existenciaBodega",
            data: {user, codigo, nombre},
            success: function(data){
                if(selected != ''){
                    document.getElementById('existencia').style.display = "";
                    $('#existencia').val(data+' timbres disponibles');
                    document.getElementById('existenciaE').style.display = "";
                    $('#existenciaE').val(data+' timbres disponibles');
                    document.getElementById('existenciaP').style.display = "";
                    $('#existenciaP').val(data+' timbres disponibles');
                }
            }
        });
    } else {
        document.getElementById('existencia').style.display = "none";
        $('#existencia').val('');
        document.getElementById('existenciaE').style.display = "none";
        $('#existenciaE').val('');
        document.getElementById('existenciaP').style.display = "none";
        $('#existenciaP').val('');
    }
}


$(document).ready(function(){
    $("#cantidad").change(function() {

        if ($("input[name='precioU']").prop('disabled') == true){
            var subTotal = 0;

            var precioU = $("#precioU").val().substring(2); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidad").val();

                subTotal = cantidad * precioU;

                $("#subtotal").val('Q.'+subTotal.toFixed(2));
        }else {
            var subTotal = 0;

            var precioU = $("#precioU").val(); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidad").val();

                subTotal = cantidad * precioU;

                $("#subtotal").val('Q.'+subTotal.toFixed(2));
        }
    });
    $("#precioU").change(function() {

            var subTotal = 0;

            var precioU = $("#precioU").val(); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidad").val();

                subTotal = cantidad * precioU;

                $("#subtotal").val('Q.'+subTotal.toFixed(2));
    });
});

function mensualidadTimbre(indicador) {
    // limpiarTimbres();
    document.getElementById('datoTc01').style.display = "none";document.getElementById('datoTc05').style.display = "none";document.getElementById('datoTc10').style.display = "none";
    document.getElementById('datoTc20').style.display = "none";document.getElementById('datoTc50').style.display = "none";document.getElementById('datoTc100').style.display = "none";
    document.getElementById('datoTc200').style.display = "none";document.getElementById('datoTc500').style.display = "none";
    document.getElementById('datoTc01P').style.display = "none";document.getElementById('datoTc05P').style.display = "none";document.getElementById('datoTc10P').style.display = "none";
    document.getElementById('datoTc20P').style.display = "none";document.getElementById('datoTc50P').style.display = "none";document.getElementById('datoTc100P').style.display = "none";
    document.getElementById('datoTc200P').style.display = "none";document.getElementById('datoTc500P').style.display = "none";
    $('#tc01').val('');$('#tc05').val('');$('#tc10').val('');$('#tc20').val('');$('#tc50').val('');$('#tc100').val('');$('#tc200').val('');$('#tc500').val('');
    $('#tc01P').val('');$('#tc05P').val('');$('#tc10P').val('');$('#tc20P').val('');$('#tc50P').val('');$('#tc100P').val('');$('#tc200P').val('');$('#tc500P').val('');
    $('#cantidadDatosTc01').val('');$('#cantidadDatosTc05').val('');$('#cantidadDatosTc10').val('');$('#cantidadDatosTc20').val('');
    $('#cantidadDatosTc50').val('');$('#cantidadDatosTc100').val('');$('#cantidadDatosTc200').val('');$('#cantidadDatosTc500').val('');
    $('#tc01inicio').val('');$('#tc01fin').val('');$('#tc01inicio2').val('');$('#tc01fin2').val('');$('#tc01inicio3').val('');$('#tc01fin3').val('');
    $('#tc05inicio').val('');$('#tc05fin').val('');$('#tc05inicio2').val('');$('#tc05fin2').val('');$('#tc05inicio3').val('');$('#tc05fin3').val('');
    $('#tc10inicio').val('');$('#tc10fin').val('');$('#tc10inicio2').val('');$('#tc10fin2').val('');$('#tc10inicio3').val('');$('#tc10fin3').val('');
    $('#tc20inicio').val('');$('#tc20fin').val('');$('#tc20inicio2').val('');$('#tc20fin2').val('');$('#tc20inicio3').val('');$('#tc20fin3').val('');
    $('#tc50inicio').val('');$('#tc50fin').val('');$('#tc50inicio2').val('');$('#tc50fin2').val('');$('#tc50inicio3').val('');$('#tc50fin3').val('');
    $('#tc100inicio').val('');$('#tc100fin').val('');$('#tc100inicio2').val('');$('#tc100fin2').val('');$('#tc100inicio3').val('');$('#tc100fin3').val('');
    $('#tc200inicio').val('');$('#tc200fin').val('');$('#tc200inicio2').val('');$('#tc200fin2').val('');$('#tc200inicio3').val('');$('#tc200fin3').val('');
    $('#tc500inicio').val('');$('#tc500fin').val('');$('#tc500inicio2').val('');$('#tc500fin2').val('');$('#tc500inicio3').val('');$('#tc500fin3').val('');
    var subtotal = indicador;
    var user = $('#rol_user').val();
    $.ajax({
        type: "POST",
        dataType:'JSON',
        url: "getTimbresDePago",
        data: {subtotal, user},
        success: function(data){
            if (data[0].haydatos != 'no'){
                for(var i=0; i < data.length; i++){
                    if (data[i]["codigo"] == "TC01"){
                                if ($('#cantidadDatosTc01').val() == ''){
                                    var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                        document.getElementById('datoTc01').style.display = "";document.getElementById('datoTc01P').style.display = "";$('#tmCantTc01').val(data[i]["cantidad"]);
                                        $('#tc01').val(mensaje);$('#tc01P').val(mensaje);$('#cantidadDatosTc01').val('1');$('#tc01inicio').val(data[i]["numeracion_inicial"]);$('#tc01fin').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                        document.getElementById('datoTc01').style.display = "";document.getElementById('datoTc01P').style.display = "";$('#tmCantTc01').val(data[i]["cantidad"]);
                                        $('#tc01').val(mensaje);$('#tc01P').val(mensaje);$('#cantidadDatosTc01').val('1');$('#tc01inicio').val(data[i]["numeracion_inicial"]);$('#tc01fin').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc01').val() == '1'){
                                    var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                        document.getElementById('datoTc01').style.display = "";document.getElementById('datoTc01P').style.display = "";$('#tmCantTc01_2').val(data[i]["cantidad"]);
                                        $('#tc01').val(mensaje);$('#tc01P').val(mensaje);$('#cantidadDatosTc01').val('2');$('#tc01inicio2').val(data[i]["numeracion_inicial"]);$('#tc01fin2').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                        document.getElementById('datoTc01').style.display = "";document.getElementById('datoTc01P').style.display = "";$('#tmCantTc01_2').val(data[i]["cantidad"]);
                                        $('#tc01').val(mensaje);$('#tc01P').val(mensaje);$('#cantidadDatosTc01').val('2');$('#tc01inicio2').val(data[i]["numeracion_inicial"]);$('#tc01fin2').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc01').val() == '2'){
                                    var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                        document.getElementById('datoTc01').style.display = "";document.getElementById('datoTc01P').style.display = "";$('#tmCantTc01_3').val(data[i]["cantidad"]);
                                        $('#tc01').val(mensaje);$('#tc01P').val(mensaje);$('#cantidadDatosTc01').val('3');$('#tc01inicio3').val(data[i]["numeracion_inicial"]);$('#tc01fin3').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                        document.getElementById('datoTc01').style.display = "";document.getElementById('datoTc01P').style.display = "";$('#tmCantTc01_3').val(data[i]["cantidad"]);
                                        $('#tc01').val(mensaje);$('#tc01P').val(mensaje);$('#cantidadDatosTc01').val('3');$('#tc01inicio3').val(data[i]["numeracion_inicial"]);$('#tc01fin3').val(data[i]["numeracion_final"]);
                                    }
                                }
                    }
                    if (data[i]["codigo"] == "TC05"){
                                if ($('#cantidadDatosTc05').val() == ''){
                                    var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                        document.getElementById('datoTc05').style.display = "";document.getElementById('datoTc05P').style.display = "";$('#tmCantTc05').val(data[i]["cantidad"]);
                                        $('#tc05').val(mensaje);$('#tc05P').val(mensaje);$('#cantidadDatosTc05').val('1');$('#tc05inicio').val(data[i]["numeracion_inicial"]);$('#tc05fin').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                        document.getElementById('datoTc05').style.display = "";document.getElementById('datoTc05P').style.display = "";$('#tmCantTc05').val(data[i]["cantidad"]);
                                        $('#tc05').val(mensaje);$('#tc05P').val(mensaje);$('#cantidadDatosTc05').val('1');$('#tc05inicio').val(data[i]["numeracion_inicial"]);$('#tc05fin').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc05').val() == '1'){
                                    var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                        document.getElementById('datoTc05').style.display = "";document.getElementById('datoTc05P').style.display = "";$('#tmCantTc05_2').val(data[i]["cantidad"]);
                                        $('#tc05').val(mensaje);$('#tc05P').val(mensaje);$('#cantidadDatosTc05').val('2');$('#tc05inicio2').val(data[i]["numeracion_inicial"]);$('#tc05fin2').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                        document.getElementById('datoTc05').style.display = "";document.getElementById('datoTc05P').style.display = "";$('#tmCantTc05_2').val(data[i]["cantidad"]);
                                        $('#tc05').val(mensaje);$('#tc05P').val(mensaje);$('#cantidadDatosTc05').val('2');$('#tc05inicio2').val(data[i]["numeracion_inicial"]);$('#tc05fin2').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc05').val() == '2'){
                                    var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                        document.getElementById('datoTc05').style.display = "";document.getElementById('datoTc05P').style.display = "";$('#tmCantTc05_3').val(data[i]["cantidad"]);
                                        $('#tc05').val(mensaje);$('#tc05P').val(mensaje);$('#cantidadDatosTc05').val('3');$('#tc05inicio3').val(data[i]["numeracion_inicial"]);$('#tc05fin3').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                        document.getElementById('datoTc05').style.display = "";document.getElementById('datoTc05P').style.display = "";$('#tmCantTc05_3').val(data[i]["cantidad"]);
                                        $('#tc05').val(mensaje);$('#tc05P').val(mensaje);$('#cantidadDatosTc05').val('3');$('#tc05inicio3').val(data[i]["numeracion_inicial"]);$('#tc05fin3').val(data[i]["numeracion_final"]);
                                    }
                                }
                    }
                    if (data[i]["codigo"] == "TC10"){
                                if ($('#cantidadDatosTc10').val() == ''){
                                    var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                        document.getElementById('datoTc10').style.display = "";document.getElementById('datoTc10P').style.display = "";$('#tmCantTc10').val(data[i]["cantidad"]);
                                        $('#tc10').val(mensaje);$('#tc10P').val(mensaje);$('#cantidadDatosTc10').val('1');$('#tc10inicio').val(data[i]["numeracion_inicial"]);$('#tc10fin').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                        document.getElementById('datoTc10').style.display = "";document.getElementById('datoTc10P').style.display = "";$('#tmCantTc10').val(data[i]["cantidad"]);
                                        $('#tc10').val(mensaje);$('#tc10P').val(mensaje);$('#cantidadDatosTc10').val('1');$('#tc10inicio').val(data[i]["numeracion_inicial"]);$('#tc10fin').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc10').val() == '1'){
                                    var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                        document.getElementById('datoTc10').style.display = "";document.getElementById('datoTc10P').style.display = "";$('#tmCantTc10_2').val(data[i]["cantidad"]);
                                        $('#tc10').val(mensaje);$('#tc10P').val(mensaje);$('#cantidadDatosTc10').val('2');$('#tc10inicio2').val(data[i]["numeracion_inicial"]);$('#tc10fin2').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                        document.getElementById('datoTc10').style.display = "";document.getElementById('datoTc10P').style.display = "";$('#tmCantTc10_2').val(data[i]["cantidad"]);
                                        $('#tc10').val(mensaje);$('#tc10P').val(mensaje);$('#cantidadDatosTc10').val('2');$('#tc10inicio2').val(data[i]["numeracion_inicial"]);$('#tc10fin2').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc10').val() == '2'){
                                    var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                        document.getElementById('datoTc10').style.display = "";document.getElementById('datoTc10P').style.display = "";$('#tmCantTc10_3').val(data[i]["cantidad"]);
                                        $('#tc10').val(mensaje);$('#tc10P').val(mensaje);$('#cantidadDatosTc10').val('3');$('#tc10inicio3').val(data[i]["numeracion_inicial"]);$('#tc10fin3').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                        document.getElementById('datoTc10').style.display = "";document.getElementById('datoTc10P').style.display = "";$('#tmCantTc10_3').val(data[i]["cantidad"]);
                                        $('#tc10').val(mensaje);$('#tc10P').val(mensaje);$('#cantidadDatosTc10').val('3');$('#tc10inicio3').val(data[i]["numeracion_inicial"]);$('#tc10fin3').val(data[i]["numeracion_final"]);
                                    }
                                }
                    }
                    if (data[i]["codigo"] == "TC20"){
                                if ($('#cantidadDatosTc20').val() == ''){
                                    var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                        document.getElementById('datoTc20').style.display = "";document.getElementById('datoTc20P').style.display = "";$('#tmCantTc20').val(data[i]["cantidad"]);
                                        $('#tc20').val(mensaje);$('#tc20P').val(mensaje);$('#cantidadDatosTc20').val('1');$('#tc20inicio').val(data[i]["numeracion_inicial"]);$('#tc20fin').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                        document.getElementById('datoTc20').style.display = "";document.getElementById('datoTc20P').style.display = "";$('#tmCantTc20').val(data[i]["cantidad"]);
                                        $('#tc20').val(mensaje);$('#tc20P').val(mensaje);$('#cantidadDatosTc20').val('1');$('#tc20inicio').val(data[i]["numeracion_inicial"]);$('#tc20fin').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc20').val() == '1'){
                                    var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                        document.getElementById('datoTc20').style.display = "";document.getElementById('datoTc20P').style.display = "";$('#tmCantTc20_2').val(data[i]["cantidad"]);
                                        $('#tc20').val(mensaje);$('#tc20P').val(mensaje);$('#cantidadDatosTc20').val('2');$('#tc20inicio2').val(data[i]["numeracion_inicial"]);$('#tc20fin2').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                        document.getElementById('datoTc20').style.display = "";document.getElementById('datoTc20P').style.display = "";$('#tmCantTc20_2').val(data[i]["cantidad"]);
                                        $('#tc20').val(mensaje);$('#tc20P').val(mensaje);$('#cantidadDatosTc20').val('2');$('#tc20inicio2').val(data[i]["numeracion_inicial"]);$('#tc20fin2').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc20').val() == '2'){
                                    var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                        document.getElementById('datoTc20').style.display = "";document.getElementById('datoTc20P').style.display = "";$('#tmCantTc20_3').val(data[i]["cantidad"]);
                                        $('#tc20').val(mensaje);$('#tc20P').val(mensaje);$('#cantidadDatosTc20').val('3');$('#tc20inicio3').val(data[i]["numeracion_inicial"]);$('#tc20fin3').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                        document.getElementById('datoTc20').style.display = "";document.getElementById('datoTc20P').style.display = "";$('#tmCantTc20_3').val(data[i]["cantidad"]);
                                        $('#tc20').val(mensaje);$('#tc20P').val(mensaje);$('#cantidadDatosTc20').val('3');$('#tc20inicio3').val(data[i]["numeracion_inicial"]);$('#tc20fin3').val(data[i]["numeracion_final"]);
                                    }
                                }
                    }
                    if (data[i]["codigo"] == "TC50"){
                                if ($('#cantidadDatosTc50').val() == ''){
                                    var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                        document.getElementById('datoTc50').style.display = "";document.getElementById('datoTc50P').style.display = "";$('#tmCantTc50').val(data[i]["cantidad"]);
                                        $('#tc50').val(mensaje);$('#tc50P').val(mensaje);$('#cantidadDatosTc50').val('1');$('#tc50inicio').val(data[i]["numeracion_inicial"]);$('#tc50fin').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                        document.getElementById('datoTc50').style.display = "";document.getElementById('datoTc50P').style.display = "";$('#tmCantTc50').val(data[i]["cantidad"]);
                                        $('#tc50').val(mensaje);$('#tc50P').val(mensaje);$('#cantidadDatosTc50').val('1');$('#tc50inicio').val(data[i]["numeracion_inicial"]);$('#tc50fin').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc50').val() == '1'){
                                    var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                        document.getElementById('datoTc50').style.display = "";document.getElementById('datoTc50P').style.display = "";$('#tmCantTc50_2').val(data[i]["cantidad"]);
                                        $('#tc50').val(mensaje);$('#tc50P').val(mensaje);$('#cantidadDatosTc50').val('2');$('#tc50inicio2').val(data[i]["numeracion_inicial"]);$('#tc50fin2').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                        document.getElementById('datoTc50').style.display = "";document.getElementById('datoTc50P').style.display = "";$('#tmCantTc50_2').val(data[i]["cantidad"]);
                                        $('#tc50').val(mensaje);$('#tc50P').val(mensaje);$('#cantidadDatosTc50').val('2');$('#tc50inicio2').val(data[i]["numeracion_inicial"]);$('#tc50fin2').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc50').val() == '2'){
                                    var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                        document.getElementById('datoTc50').style.display = "";document.getElementById('datoTc50P').style.display = "";$('#tmCantTc50_3').val(data[i]["cantidad"]);
                                        $('#tc50').val(mensaje);$('#tc50P').val(mensaje);$('#cantidadDatosTc50').val('3');$('#tc50inicio3').val(data[i]["numeracion_inicial"]);$('#tc50fin3').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                        document.getElementById('datoTc50').style.display = "";document.getElementById('datoTc50P').style.display = "";$('#tmCantTc50_3').val(data[i]["cantidad"]);
                                        $('#tc50').val(mensaje);$('#tc50P').val(mensaje);$('#cantidadDatosTc50').val('3');$('#tc50inicio3').val(data[i]["numeracion_inicial"]);$('#tc50fin3').val(data[i]["numeracion_final"]);
                                    }
                                }
                    }
                    if (data[i]["codigo"] == "TC100"){
                                if ($('#cantidadDatosTc100').val() == ''){
                                    var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                        document.getElementById('datoTc100').style.display = "";document.getElementById('datoTc100P').style.display = "";$('#tmCantTc100').val(data[i]["cantidad"]);
                                        $('#tc100').val(mensaje);$('#tc100P').val(mensaje);$('#cantidadDatosTc100').val('1');$('#tc100inicio').val(data[i]["numeracion_inicial"]);$('#tc100fin').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                        document.getElementById('datoTc100').style.display = "";document.getElementById('datoTc100P').style.display = "";$('#tmCantTc100').val(data[i]["cantidad"]);
                                        $('#tc100').val(mensaje);$('#tc100P').val(mensaje);$('#cantidadDatosTc100').val('1');$('#tc100inicio').val(data[i]["numeracion_inicial"]);$('#tc100fin').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc100').val() == '1'){
                                    var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                        document.getElementById('datoTc100').style.display = "";document.getElementById('datoTc100P').style.display = "";$('#tmCantTc100_2').val(data[i]["cantidad"]);
                                        $('#tc100').val(mensaje);$('#tc100P').val(mensaje);$('#cantidadDatosTc100').val('2');$('#tc100inicio2').val(data[i]["numeracion_inicial"]);$('#tc100fin2').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                        document.getElementById('datoTc100').style.display = "";document.getElementById('datoTc100P').style.display = "";$('#tmCantTc100_2').val(data[i]["cantidad"]);
                                        $('#tc100').val(mensaje);$('#tc100P').val(mensaje);$('#cantidadDatosTc100').val('2');$('#tc100inicio2').val(data[i]["numeracion_inicial"]);$('#tc100fin2').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc100').val() == '2'){
                                    var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                        document.getElementById('datoTc100').style.display = "";document.getElementById('datoTc100P').style.display = "";$('#tmCantTc100_3').val(data[i]["cantidad"]);
                                        $('#tc100').val(mensaje);$('#tc100P').val(mensaje);$('#cantidadDatosTc100').val('3');$('#tc100inicio3').val(data[i]["numeracion_inicial"]);$('#tc100fin3').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                        document.getElementById('datoTc100').style.display = "";document.getElementById('datoTc100P').style.display = "";$('#tmCantTc100_3').val(data[i]["cantidad"]);
                                        $('#tc100').val(mensaje);$('#tc100P').val(mensaje);$('#cantidadDatosTc100').val('3');$('#tc100inicio3').val(data[i]["numeracion_inicial"]);$('#tc100fin3').val(data[i]["numeracion_final"]);
                                    }
                                }
                    }
                    if (data[i]["codigo"] == "TC200"){
                                if ($('#cantidadDatosTc200').val() == ''){
                                    var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                        document.getElementById('datoTc200').style.display = "";document.getElementById('datoTc200P').style.display = "";$('#tmCantTc200').val(data[i]["cantidad"]);
                                        $('#tc200').val(mensaje);$('#tc200P').val(mensaje);$('#cantidadDatosTc200').val('1');$('#tc200inicio').val(data[i]["numeracion_inicial"]);$('#tc200fin').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                        document.getElementById('datoTc200').style.display = "";document.getElementById('datoTc200P').style.display = "";$('#tmCantTc200').val(data[i]["cantidad"]);
                                        $('#tc200').val(mensaje);$('#tc200P').val(mensaje);$('#cantidadDatosTc200').val('1');$('#tc200inicio').val(data[i]["numeracion_inicial"]);$('#tc200fin').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc200').val() == '1'){
                                    var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                        document.getElementById('datoTc200').style.display = "";document.getElementById('datoTc200P').style.display = "";$('#tmCantTc200_2').val(data[i]["cantidad"]);
                                        $('#tc200').val(mensaje);$('#tc200P').val(mensaje);$('#cantidadDatosTc200').val('2');$('#tc200inicio2').val(data[i]["numeracion_inicial"]);$('#tc200fin2').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                        document.getElementById('datoTc200').style.display = "";document.getElementById('datoTc200P').style.display = "";$('#tmCantTc200_2').val(data[i]["cantidad"]);
                                        $('#tc200').val(mensaje);$('#tc200P').val(mensaje);$('#cantidadDatosTc200').val('2');$('#tc200inicio2').val(data[i]["numeracion_inicial"]);$('#tc200fin2').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc200').val() == '2'){
                                    var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                        document.getElementById('datoTc200').style.display = "";document.getElementById('datoTc200P').style.display = "";$('#tmCantTc200_3').val(data[i]["cantidad"]);
                                        $('#tc200').val(mensaje);$('#tc200P').val(mensaje);$('#cantidadDatosTc200').val('3');$('#tc200inicio3').val(data[i]["numeracion_inicial"]);$('#tc200fin3').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                        document.getElementById('datoTc200').style.display = "";document.getElementById('datoTc200P').style.display = "";$('#tmCantTc200_3').val(data[i]["cantidad"]);
                                        $('#tc200').val(mensaje);$('#tc200P').val(mensaje);$('#cantidadDatosTc200').val('3');$('#tc200inicio3').val(data[i]["numeracion_inicial"]);$('#tc200fin3').val(data[i]["numeracion_final"]);
                                    }
                                }
                    }
                    if (data[i]["codigo"] == "TC500"){
                                if ($('#cantidadDatosTc500').val() == ''){
                                    var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                        document.getElementById('datoTc500').style.display = "";document.getElementById('datoTc500P').style.display = "";$('#tmCantTc500').val(data[i]["cantidad"]);
                                        $('#tc500').val(mensaje);$('#tc500P').val(mensaje);$('#cantidadDatosTc500').val('1');$('#tc500inicio').val(data[i]["numeracion_inicial"]);$('#tc500fin').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                        document.getElementById('datoTc500').style.display = "";document.getElementById('datoTc500P').style.display = "";$('#tmCantTc500').val(data[i]["cantidad"]);
                                        $('#tc500').val(mensaje);$('#tc500P').val(mensaje);$('#cantidadDatosTc500').val('1');$('#tc500inicio').val(data[i]["numeracion_inicial"]);$('#tc500fin').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc500').val() == '1'){
                                    var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                        document.getElementById('datoTc500').style.display = "";document.getElementById('datoTc500P').style.display = "";$('#tmCantTc500_2').val(data[i]["cantidad"]);
                                        $('#tc500').val(mensaje);$('#tc500P').val(mensaje);$('#cantidadDatosTc500').val('2');$('#tc500inicio2').val(data[i]["numeracion_inicial"]);$('#tc500fin2').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                        document.getElementById('datoTc500').style.display = "";document.getElementById('datoTc500P').style.display = "";$('#tmCantTc500_2').val(data[i]["cantidad"]);
                                        $('#tc500').val(mensaje);$('#tc500P').val(mensaje);$('#cantidadDatosTc500').val('2');$('#tc500inicio2').val(data[i]["numeracion_inicial"]);$('#tc500fin2').val(data[i]["numeracion_final"]);
                                    }
                                }
                                else if ($('#cantidadDatosTc500').val() == '2'){
                                    var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                    if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                        document.getElementById('datoTc500').style.display = "";document.getElementById('datoTc500P').style.display = "";$('#tmCantTc500_3').val(data[i]["cantidad"]);
                                        $('#tc500').val(mensaje);$('#tc500P').val(mensaje);$('#cantidadDatosTc500').val('3');$('#tc500inicio3').val(data[i]["numeracion_inicial"]);$('#tc500fin3').val(data[i]["numeracion_final"]);
                                    } else {
                                        var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                        document.getElementById('datoTc500').style.display = "";document.getElementById('datoTc500P').style.display = "";$('#tmCantTc500_3').val(data[i]["cantidad"]);
                                        $('#tc500').val(mensaje);$('#tc500P').val(mensaje);$('#cantidadDatosTc500').val('3');$('#tc500inicio3').val(data[i]["numeracion_inicial"]);$('#tc500fin3').val(data[i]["numeracion_final"]);
                                    }
                                }
                    }
                }
            } else {

                if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
                if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
                if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}

                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'timbre-mensual')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    alertify.error('No hay suficientes timbres para realizar la venta');
                    alertify.set('notifier','position', 'top-center');
            }
            getTotal();
            getTotalP();
            getTotalE();
        }
    });
}

function agregarproductof() {
    $("#codigo").change();

    // $("#cantidad").change();
    if($.isNumeric($("#cantidad").val()) && $("#subtotal").val().substring(2) != 0) {

        validateRow();
      limpiarFilaDetalle();
    }
  }

function validateRow(){
    $('#tablaDetalle').each(function(index, tr) {
        var cantTim = $('#cantidad').val();
        var combo = document.getElementById("codigo");
        var selected = combo.options[combo.selectedIndex].text;
        var nFilas = $("#tablaDetalle tr").length;
        if((nFilas == 1) && ($('#codigo').val() != "")){
            if ($('#codigo').val() == 62){
                var indicador = $('#subtotal').val().substring(2);
                mensualidadTimbre(indicador);
                addnewrow();
            }else {
                addnewrow();
                getTimbres(selected, cantTim);
            }
        }else if (nFilas > 1){
            var filas = $("#tablaDetalle").find("tr");

            for(var i= 0; i < filas.length; i++){
                if(($('#categoria_id').val() == 1) || ($('#categoria_id').val() == 3)){
                    for(var i= 0; i < filas.length; i++){

                        var celdas = $(filas[i]).find("td");

                        var nuevoSubTotal = 0;
                        var subTotalColeNue = $('#subtotal').val().substring(2);
                        var subTotalColeAnt = $($(celdas[5])).text().substring(2);

                        var codigoAnt = $($(celdas[0])).text();

                        var totalCant = 0;
                        var cantidadA = $($(celdas[2])).text();
                        var cantidadN = $('#cantidad').val();
                        var totalCant = Number(cantidadA) + Number(cantidadN);

                        if(codigoAnt == $('#codigo').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = 'Q.'+nuevoSubTotal.toFixed(2);

                            if (codigoAnt == 62) {

                                var indicador = nuevoSubTotal;
                                mensualidadTimbre(indicador);
                                getTotal();
                                limpiarFilaDetalle();
                                document.getElementById('existencia').style.display = "none";$('#existencia').val('');
                                document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
                                document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
                                finish();

                            } else {

                                getTotal();
                                getTimbres(selected, totalCant);
                                limpiarFilaDetalle();
                                document.getElementById('existencia').style.display = "none";$('#existencia').val('');
                                document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
                                document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
                                finish();
                            }

                        }
                    }
                addnewrow();
                getTimbres(selected, cantTim);
                }else{
                    var arrayColCatId = new Array();
                    $('#tablaDetalle tbody tr td:nth-child(7)').each(function () {
                        arrayColCatId.push($(this).text());
                    });

                    var arrayColCodigo = new Array();
                    $('#tablaDetalle tbody tr td:nth-child(1)').each(function () {
                        arrayColCodigo.push($(this).text());
                    });

                        if (arrayColCatId.includes($('#categoria_id').val()) && arrayColCodigo.includes($('#codigo').val())){
                            alertify.warning('/.tipo de pago ya ha sido ingresado./');
                            finish();
                        }else if(($('#codigo').val() != "")){
                            addnewrow();
                            getTimbres(selected, cantTim);
                            limpiarFilaDetalle();
                            finish();
                        }
                }
            }
        }
    });
}

  function addnewrow() {
    if ($("#precioU").val().substring(-1,2) == 'Q.'){
        var precioU = $("#precioU").val();
    }else {
        var precioU = 'Q.'+($("#precioU").val());
    }

	if(!$('#tablaDetalle').length) {
		var resultado = '<table class="table table-striped table-hover" id="tablaDetalle"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th style:"display: none;">categoria_id</th><th>Eliminar</th></tr></thead><tbody>';
		resultado += '</tbody></table>';
		$("#detalle").html(resultado);
	}
	var resultado = "";
	resultado += '<tr class="filaDetalleVal">';


	resultado += '<td class="codigo" id="codigo" style="display: none;">';
	resultado += $("#codigo").val();
	resultado += '</td>';

    resultado += '<td class="nombreCodigo" id="nombreCodigo">';
	resultado += $('#codigo option:selected').text().split(" ", 1);
	resultado += '</td>';

	resultado += '<td class="cantidad" id="cantidad">';
	resultado += $("#cantidad").val();
	resultado += '</td>';

	resultado += '<td class="precioU" id="precioU">';
	resultado += precioU;
	resultado += '</td>';

	resultado += '<td class="descTipoPago">';
	resultado += $("#descTipoPago").val();
	resultado += '</td>';

	resultado += '<td align="center" class="subtotal">';
	resultado += $("#subtotal").val();
	resultado += '</td>';

    resultado += '<td align="center" class="categoria_id" style="display: none;">';
	resultado += $("#categoria_id").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += '<button class="form-button btn btn-danger" onclick="eliminardetalle(this)" type="button">X</button>';
	resultado += '</td>';
	resultado += '</tr>';

	$(resultado).prependTo("#tablaDetalle > tbody");
   getTotal();
    document.getElementById('existencia').style.display = "none";$('#existencia').val('');
    document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
    document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
}



function getTotal() {
    var total = 0;
    $("#tablaDetalle .subtotal").each(function (index, element) {
      total += parseFloat($(this).html().substring(2));
    });

    $("#total").val('Q.'+total.toFixed(2));
}

  function limpiarFilaDetalle() {
    $("select[name='codigo']").selectpicker('refresh').val('').selectpicker('refresh').trigger('change');
    $("input[name='cantidad']").val(1);
    $("input[name='precioU']").val('').prop('disabled', true);;
    $("input[name='descTipoPago']").val('');
    $("input[name='subtotal']").val('');
    $("#codigo").focus();
  }

  function limpiarTimbres(){
    document.getElementById('datoTc01').style.display = "none";$("input[name='tc01']").val('');$('#tc01inicio').val('');$('#tc01fin').val('');$('#cantidadDatosTc01').val('');
    document.getElementById('datoTc01E').style.display = "none";$("input[name='tc01E']").val('');$('#tc01inicioE').val('');$('#tc01finE').val('');
    document.getElementById('datoTc01P').style.display = "none";$("input[name='tc01P']").val('');$('#tc01inicioP').val('');$('#tc01finP').val('');
    document.getElementById('datoTc05').style.display = "none";$("input[name='tc05']").val('');$('#tc05inicio').val('');$('#tc05fin').val('');$('#cantidadDatosTc05').val('');
    document.getElementById('datoTc05E').style.display = "none";$("input[name='tc05E']").val('');$('#tc05inicioE').val('');$('#tc05finE').val('');
    document.getElementById('datoTc05P').style.display = "none";$("input[name='tc05P']").val('');$('#tc05inicioP').val('');$('#tc05finP').val('');
    document.getElementById('datoTc10').style.display = "none";$("input[name='tc10']").val('');$('#tc10inicio').val('');$('#tc10fin').val('');$('#cantidadDatosTc10').val('');
    document.getElementById('datoTc10E').style.display = "none";$("input[name='tc10E']").val('');$('#tc10inicioE').val('');$('#tc10finE').val('');
    document.getElementById('datoTc10P').style.display = "none";$("input[name='tc10P']").val('');$('#tc10inicioP').val('');$('#tc10finP').val('');
    document.getElementById('datoTc20').style.display = "none";$("input[name='tc20']").val('');$('#tc20inicio').val('');$('#tc20fin').val('');$('#cantidadDatosTc20').val('');
    document.getElementById('datoTc20E').style.display = "none";$("input[name='tc20E']").val('');$('#tc20inicioE').val('');$('#tc20finE').val('');
    document.getElementById('datoTc20P').style.display = "none";$("input[name='tc20P']").val('');$('#tc20inicioP').val('');$('#tc20finP').val('');
    document.getElementById('datoTc50').style.display = "none";$("input[name='tc50']").val('');$('#tc50inicio').val('');$('#tc50fin').val('');$('#cantidadDatosTc50').val('');
    document.getElementById('datoTc50E').style.display = "none";$("input[name='tc50E']").val('');$('#tc50inicioE').val('');$('#tc50finE').val('');
    document.getElementById('datoTc50P').style.display = "none";$("input[name='tc50P']").val('');$('#tc50inicioP').val('');$('#tc50finP').val('');
    document.getElementById('datoTc100').style.display = "none";$("input[name='tc100']").val('');$('#tc100inicio').val('');$('#tc100fin').val('');$('#cantidadDatosTc100').val('');
    document.getElementById('datoTc100E').style.display = "none";$("input[name='tc100E']").val('');$('#tc100inicioE').val('');$('#tc100finE').val('');
    document.getElementById('datoTc100P').style.display = "none";$("input[name='tc100P']").val('');$('#tc100inicioP').val('');$('#tc100finP').val('');
    document.getElementById('datoTc200').style.display = "none";$("input[name='tc200']").val('');$('#tc200inicio').val('');$('#tc200fin').val('');$('#cantidadDatosTc200').val('');
    document.getElementById('datoTc200E').style.display = "none";$("input[name='tc200E']").val('');$('#tc200inicioE').val('');$('#tc200finE').val('');
    document.getElementById('datoTc200P').style.display = "none";$("input[name='tc200P']").val('');$('#tc200inicioP').val('');$('#tc200finP').val('');
    document.getElementById('datoTc500').style.display = "none";$("input[name='tc500']").val('');$('#tc500inicio').val('');$('#tc500fin').val('');$('#cantidadDatosTc500').val('');
    document.getElementById('datoTc500E').style.display = "none";$("input[name='tc500E']").val('');$('#tc500inicioE').val('');$('#tc500finE').val('');
    document.getElementById('datoTc500P').style.display = "none";$("input[name='tc500P']").val('');$('#tc500inicioP').val('');$('#tc500finP').val('');
}

  function eliminardetalle(e) {
	if (confirm("Confirma que desea eliminar este producto") == false) {
		return;
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC01" || $(e).closest('tr').find("td")[1].innerHTML == "TIM1" || $(e).closest('tr').find("td")[1].innerHTML == "TE01"){
        document.getElementById('datoTc01').style.display = "none";
        $("input[name='tc01']").val('');
        $('#tc01inicio').val('');
        $('#tc01fin').val('');
        document.getElementById('datoTc01E').style.display = "none";
        $("input[name='tc01E']").val('');
        $('#tc01inicioE').val('');
        $('#tc01finE').val('');
        document.getElementById('datoTc01P').style.display = "none";
        $("input[name='tc01P']").val('');
        $('#tc01inicioP').val('');
        $('#tc01finP').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC05" || $(e).closest('tr').find("td")[1].innerHTML == "TIM5" || $(e).closest('tr').find("td")[1].innerHTML == "TE05"){
        document.getElementById('datoTc05').style.display = "none";
        $("input[name='tc05']").val('');
        $('#tc05inicio').val('');
        $('#tc05fin').val('');
        document.getElementById('datoTc05E').style.display = "none";
        $("input[name='tc05E']").val('');
        $('#tc05inicioE').val('');
        $('#tc05finE').val('');
        document.getElementById('datoTc05P').style.display = "none";
        $("input[name='tc05P']").val('');
        $('#tc05inicioP').val('');
        $('#tc05finP').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC10" || $(e).closest('tr').find("td")[1].innerHTML == "TIM10" || $(e).closest('tr').find("td")[1].innerHTML == "TE10"){
        document.getElementById('datoTc10').style.display = "none";
        $("input[name='tc10']").val('');
        $('#tc10inicio').val('');
        $('#tc10fin').val('');
        document.getElementById('datoTc10E').style.display = "none";
        $("input[name='tc10E']").val('');
        $('#tc10inicioE').val('');
        $('#tc10finE').val('');
        document.getElementById('datoTc10P').style.display = "none";
        $("input[name='tc10P']").val('');
        $('#tc10inicioP').val('');
        $('#tc10finP').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC20" || $(e).closest('tr').find("td")[1].innerHTML == "TIM20" || $(e).closest('tr').find("td")[1].innerHTML == "TE20"){
        document.getElementById('datoTc20').style.display = "none";
        $("input[name='tc20']").val('');
        $('#tc20inicio').val('');
        $('#tc20fin').val('');
        document.getElementById('datoTc20E').style.display = "none";
        $("input[name='tc20E']").val('');
        $('#tc20inicioE').val('');
        $('#tc20finE').val('');
        document.getElementById('datoTc20P').style.display = "none";
        $("input[name='tc20P']").val('');
        $('#tc20inicioP').val('');
        $('#tc20finP').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC50" || $(e).closest('tr').find("td")[1].innerHTML == "TIM50" || $(e).closest('tr').find("td")[1].innerHTML == "TE50"){
        document.getElementById('datoTc50').style.display = "none";
        $("input[name='tc50']").val('');
        $('#tc50inicio').val('');
        $('#tc50fin').val('');
        document.getElementById('datoTc50E').style.display = "none";
        $("input[name='tc50E']").val('');
        $('#tc50inicioE').val('');
        $('#tc50finE').val('');
        document.getElementById('datoTc50P').style.display = "none";
        $("input[name='tc50P']").val('');
        $('#tc50inicioP').val('');
        $('#tc50finP').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC100" || $(e).closest('tr').find("td")[1].innerHTML == "TIM100" || $(e).closest('tr').find("td")[1].innerHTML == "TE100"){
        document.getElementById('datoTc100').style.display = "none";
        $("input[name='tc100']").val('');
        $('#tc100inicio').val('');
        $('#tc100fin').val('');
        document.getElementById('datoTc100E').style.display = "none";
        $("input[name='tc100E']").val('');
        $('#tc100inicioE').val('');
        $('#tc100finE').val('');
        document.getElementById('datoTc100P').style.display = "none";
        $("input[name='tc100P']").val('');
        $('#tc100inicioP').val('');
        $('#tc100finP').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC200" || $(e).closest('tr').find("td")[1].innerHTML == "TIM200" || $(e).closest('tr').find("td")[1].innerHTML == "TE200"){
        document.getElementById('datoTc200').style.display = "none";
        $("input[name='tc200']").val('');
        $('#tc200inicio').val('');
        $('#tc200fin').val('');
        document.getElementById('datoTc200E').style.display = "none";
        $("input[name='tc200E']").val('');
        $('#tc200inicioE').val('');
        $('#tc200finE').val('');
        document.getElementById('datoTc200P').style.display = "none";
        $("input[name='tc200P']").val('');
        $('#tc200inicioP').val('');
        $('#tc200finP').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC500" || $(e).closest('tr').find("td")[1].innerHTML == "TIM500" || $(e).closest('tr').find("td")[1].innerHTML == "TE500"){
        document.getElementById('datoTc500').style.display = "none";
        $("input[name='tc500']").val('');
        $('#tc500inicio').val('');
        $('#tc500fin').val('');
        document.getElementById('datoTc500E').style.display = "none";
        $("input[name='tc500E']").val('');
        $('#tc500inicioE').val('');
        $('#tc500finE').val('');
        document.getElementById('datoTc500P').style.display = "none";
        $("input[name='tc500P']").val('');
        $('#tc500inicioP').val('');
        $('#tc500finP').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "timbre-mensual"){
        limpiarTimbres();
    }

	$(e).closest('tr').remove();
  getTotal();
  limpiarFilaDetalle();
}

function borrarDatosTimbres() {
    document.getElementById('datoTc01').style.display = "none";$("input[name='tc01']").val('');$('#tc01inicio').val('');$('#tc01fin').val('');
    document.getElementById('datoTc05').style.display = "none";$("input[name='tc05']").val('');$('#tc05inicio').val('');$('#tc05fin').val('');
    document.getElementById('datoTc10').style.display = "none";$("input[name='tc10']").val('');$('#tc10inicio').val('');$('#tc10fin').val('');
    document.getElementById('datoTc20').style.display = "none";$("input[name='tc20']").val('');$('#tc20inicio').val('');$('#tc20fin').val('');
    document.getElementById('datoTc50').style.display = "none";$("input[name='tc50']").val('');$('#tc50inicio').val('');$('#tc50fin').val('');
    document.getElementById('datoTc100').style.display = "none";$("input[name='tc100']").val('');$('#tc100inicio').val('');$('#tc100fin').val('');
    document.getElementById('datoTc200').style.display = "none";$("input[name='tc200']").val('');$('#tc200inicio').val('');$('#tc200fin').val('');
    document.getElementById('datoTc500').style.display = "none";$("input[name='tc500']").val('');$('#tc500inicio').val('');$('#tc500fin').val('');
}

function comprobarCheckEfectivo()
{
    if (document.getElementById("tipoDePagoEfectivo").checked){
        document.getElementById('montoefectivo').readOnly = false;
    }
    else{
        document.getElementById('montoefectivo').readOnly = true;
        $('input[name="montoefectivo"]').val('');
    }
}

function comprobarCheckCheque()
{
    if (document.getElementById("tipoDePagoCheque").checked){
        document.getElementById('montoCheque').readOnly = false;
        document.getElementById('cheque').style.display = "";
        document.getElementById('banco').style.display = "";
    }
    else{
        document.getElementById('montoCheque').readOnly = true;
        document.getElementById('cheque').style.display = "none";
        document.getElementById('banco').style.display = "none";
        $('input[name="cheque"]').val('');
        $('input[name="montoCheque"]').val('');
        $('select[name="banco"]').val('');
    }
}

function comprobarCheckTarjeta()
{
    if (document.getElementById("tipoDePagoTarjeta").checked){
        document.getElementById('montoTarjeta').readOnly = false;
        document.getElementById('tarjeta').style.display = "";
        document.getElementById('pos').style.display = "";
    }
    else{
        document.getElementById('montoTarjeta').readOnly = true;
        document.getElementById('tarjeta').style.display = "none";
        document.getElementById('pos').style.display = "none";
        $('input[name="tarjeta"]').val('');
        $('input[name="montoTarjeta"]').val('');
        $('select[name="pos"]').val('');
    }
}

function comprobarCheckDeposito()
{
    if (document.getElementById("tipoDePagoDeposito").checked){
        document.getElementById('montoDeposito').readOnly = false;
        document.getElementById('deposito').style.display = "";
        document.getElementById('fechaDeposito').style.display = "";
        document.getElementById('bancoDeposito').style.display = "";
    }
    else{
        document.getElementById('montoDeposito').readOnly = true;
        document.getElementById('deposito').style.display = "none";
        document.getElementById('fechaDeposito').style.display = "none";
        document.getElementById('bancoDeposito').style.display = "none";
        $('input[name="deposito"]').val('');
        $('input[name="montoDeposito"]').val('');
        $('input[name="fechaDeposito"]').val('');
        $('select[name="bancoDeposito"]').val('');
    }
}

$(document).ready(function(){
    var validator = $('#colegiadoForm').validate({
        ignore: [],
        onkeyup:false,
        rules: {
            c_cliente:{
                required: true
            }
        },
        messages: {
            c_cliente: {
                required: "ingrese el colegiado"
            }
        }
    });
});

$("#guardarRecibo").click(function(e){

    if ($('#colegiadoForm').valid()) {

        $('#emisionDeRecibo').val('colegiado');
        $('#tipoDeCliente').val('c');
        var efectivoCorrecto = 0; //el 0 indica que no aplica y devuelve error
        var chequeCorrecto = 0;
        var tarjetaCorrecta = 0;
        var depositoCorrecto = 0;

        if (document.getElementById("tipoDePagoEfectivo").checked){
            if ($('#montoefectivo').val() == 0){
                alertify.warning('el monto de efectivo no puede ser 0...');
            } else {efectivoCorrecto = 1; $('#pagoEfectivo').val("si");}
        } else {efectivoCorrecto = 1; $('#pagoEfectivo').val("no");}
        if (document.getElementById("tipoDePagoCheque").checked){
            if ($('#cheque').val() == 0){
                alertify.warning('los datos de cheque no pueden ir vacios...');
            } else {chequeCorrecto = 1;}
            if ($('#montoCheque').val() == 0){
                alertify.warning('el monto del cheque no puede ser 0...');
                chequeCorrecto = 0;
            } else {chequeCorrecto = 1;}
            if ($('#banco').val() == 0){
                alertify.warning('opción de banco no puede estar vacio...');
                chequeCorrecto = 0;
            } else {chequeCorrecto = 1; $('#pagoCheque').val("si");}
        } else {chequeCorrecto = 1; $('#pagoCheque').val("no");}
        if (document.getElementById("tipoDePagoTarjeta").checked){
            if ($('#tarjeta').val() == 0){
                alertify.warning('los datos de tarjeta no pueden ir vacios...');
            } else {tarjetaCorrecta = 1;}
            if ($('#montoTarjeta').val() == 0){
                alertify.warning('el monto de tarjeta no puede ser 0...');
                tarjetaCorrecta = 0;
            } else {tarjetaCorrecta = 1;}
            if ($('#pos').val() == 0){
                alertify.warning('Selector de POS no puede ser vacio...');
                tarjetaCorrecta = 0;
            } else {tarjetaCorrecta = 1; $('#pagoTarjeta').val("si");}
        } else {tarjetaCorrecta = 1; $('#pagoTarjeta').val("no");}//FIN TARJETA
        if (document.getElementById("tipoDePagoDeposito").checked){
            if ($('#deposito').val() == 0){
                alertify.warning('los datos de depósito no pueden ir vacios...');
            } else {depositoCorrecto = 1;}
            if ($('#montoDeposito').val() == 0){
                alertify.warning('el monto de depósito no puede ser 0...');
                depositoCorrecto = 0;
            } else {depositoCorrecto = 1;}
            if ($('#bancoDeposito').val() == 0){
                alertify.warning('opción de banco no puede estar vacio...');
                depositoCorrecto = 0;
            } else {depositoCorrecto = 1; $('#pagoDeposito').val("si");}
        } else {depositoCorrecto = 1; $('#pagoDeposito').val("no");}

        if ((document.getElementById("tipoDePagoEfectivo").checked != true)  && (document.getElementById("tipoDePagoCheque").checked != true) && (document.getElementById("tipoDePagoTarjeta").checked != true) && (document.getElementById("tipoDePagoDeposito").checked != true)){
            alertify.warning('Seleccione un tipo de pago');
        }else if (efectivoCorrecto == 1 && chequeCorrecto == 1 && tarjetaCorrecta == 1 && depositoCorrecto == 1){
            var totalEfectivo = $('#montoefectivo').val();
            var totalCheque = $('#montoCheque').val();
            var totalTarjeta = $('#montoTarjeta').val();
            var totalDeposito = $('#montoDeposito').val();
            var totalPago = Number(totalEfectivo) + Number(totalCheque) + Number(totalTarjeta) + Number(totalDeposito);
            if(totalPago == $("#total").val().substring(2)){

                    if(document.getElementById("serieReciboA").checked == true){
                        $('#tipoSerieRecibo').val('a');
                    }else if(document.getElementById("serieReciboB").checked == true){
                        $('#tipoSerieRecibo').val('b');
                    }

                    var fechaColegio = new Date($('#fechaColegio').val());
                    fechaColegio = fechaColegio.getFullYear() + "/" + Number(fechaColegio.getMonth())+Number(1);

                    var nuevaFechaColegio = 0;
                    var filas = $("#tablaDetalle").find("tr");
                    for(var i= 0; i < filas.length; i++){
                        var celdas = $(filas[i]).find("td");
                        if($($(celdas[1])).text() == "COL092"){
                            nuevaFechaColegio += parseFloat($($(celdas[5])).html().substring(2));
                            break;
                        }
                    }

                    var totalPrecioTimbre = 0;
                    var filas = $("#tablaDetalle").find("tr");
                    for(var i= 0; i < filas.length; i++){
                        var celdas = $(filas[i]).find("td");
                        if($($(celdas[1])).text().substring(0,2) == "TC" || $($(celdas[1])).text() == "TIM-CUOTA" || $($(celdas[1])).text() == "timbre-mensual"){
                            totalPrecioTimbre += parseFloat($($(celdas[5])).html().substring(2));
                        }
                    }

                    var pos = $('#pos').val();
                    var banco = $('#banco').val();
                    var bancoDeposito = $('#bancoDeposito').val();

                    var config = {};
                    $('input').each(function () {
                    config[this.name] = this.value;
                    });

                    let datos = [].map.call(document.getElementById('tablaDetalle').rows,
                    tr => [tr.cells[0].textContent, tr.cells[1].textContent, tr.cells[2].textContent, tr.cells[3].textContent, tr.cells[4].textContent, tr.cells[5].textContent, tr.cells[6].textContent]);

                $('.loader').fadeIn();
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
                    url: "/creacionRecibo/save",
                    data: {config, datos, pos, banco, bancoDeposito, nuevaFechaColegio, totalPrecioTimbre},
                    datatype: "json",
                    success: function() {
                        $('.loader').fadeOut(1000);
                        limpiarPantallaColegiado();
                        limpiarTimbres();
                        alertify.set('notifier','position', 'top-center');
                        alertify.success('Recibo almacenado con Éxito!!');
                    },
                    error: function(){
                        $('.loader').fadeOut(1000);
                    }
                });
            }else if(totalPago > $("#total").val().substring(2)){
                alertify.warning('monto de pago es mayor al total');
            }
            else if(totalPago < $("#total").val().substring(2)){
                alertify.warning('monto de pago es menor al total');
            }
        }

    } else {
        validator.focusInvalid();
    }
})

function limpiarTimbres()
{
    document.getElementById('datoTc01').style.display = "none";document.getElementById('datoTc05').style.display = "none";document.getElementById('datoTc10').style.display = "none";
    document.getElementById('datoTc20').style.display = "none";document.getElementById('datoTc50').style.display = "none";document.getElementById('datoTc100').style.display = "none";
    document.getElementById('datoTc200').style.display = "none";document.getElementById('datoTc500').style.display = "none";
    document.getElementById('datoTc01E').style.display = "none";document.getElementById('datoTc05E').style.display = "none";document.getElementById('datoTc10E').style.display = "none";
    document.getElementById('datoTc20E').style.display = "none";document.getElementById('datoTc50E').style.display = "none";document.getElementById('datoTc100E').style.display = "none";
    document.getElementById('datoTc200E').style.display = "none";document.getElementById('datoTc500E').style.display = "none";
    document.getElementById('datoTc01P').style.display = "none";document.getElementById('datoTc05P').style.display = "none";document.getElementById('datoTc10P').style.display = "none";
    document.getElementById('datoTc20P').style.display = "none";document.getElementById('datoTc50P').style.display = "none";document.getElementById('datoTc100P').style.display = "none";
    document.getElementById('datoTc200P').style.display = "none";document.getElementById('datoTc500P').style.display = "none";
}


//Funcionamiento sobre EMPRESA

$(document).ready(function () {
    $("#codigoE").change (function () {
        $("input[name='precioUE']").prop('disabled', true);
        var valor = $("#codigoE").val();
        if(document.getElementById("serieReciboA").checked == true){
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoA/' + valor,
                success: function(response){
                    if($("#codigoE").val() != ""){
                        if (response.precio_particular == 0){
                            $("input[name='precioUE']").prop('disabled', false).val('');
                            $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                            $("input[name='subtotalE']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='categoria_idE']").val(response.categoria_id);

                            $("#cantidadE").val(1);

                        } else {
                            $("input[name='precioUE']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                            $("input[name='subtotalE']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='categoria_idE']").val(response.categoria_id);

                            $("#cantidadE").val(1);
                        }
                    }
                },
                error: function() {
                        $("input[name='cantidadE']").val(1);
                        $("input[name='precioUE']").val('');
                        $("input[name='descTipoPagoE']").val('');
                        $("input[name='subtotalE']").val('');
                        $("input[name='categoria_idE']").val('');
                }
            });
        }else if(document.getElementById("serieReciboB").checked == true){
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoB/' + valor,
                success: function(response){
                    if($("#codigoE").val() != ""){
                        if (response.precio_particular == 0){
                            $("input[name='precioUE']").prop('disabled', false).val('');
                            $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                            $("input[name='subtotalE']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='categoria_idE']").val(response.categoria_id);

                            $("#cantidadE").val(1);

                        } else {
                            $("input[name='precioUE']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                            $("input[name='subtotalE']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='categoria_idE']").val(response.categoria_id);
                            consultaTimbre();

                            $("#cantidadE").val(1);
                        }
                    }
                },
                error: function() {
                        $("input[name='cantidadE']").val(1);
                        $("input[name='precioUE']").val('');
                        $("input[name='descTipoPagoE']").val('');
                        $("input[name='subtotalE']").val('');
                        $("input[name='categoria_idE']").val('');
                }
            });
        }
        if (valor == ''){
            document.getElementById('existencia').style.display = "none";$('#existencia').val('');
            document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
            document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
        }
    });
});

$(document).ready(function(){
    $("#cantidadE").change(function() {

        if ($("input[name='precioUE']").prop('disabled') == true){
            var subTotal = 0;

            var precioU = $("#precioUE").val().substring(2); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidadE").val();

                subTotal = cantidad * precioU;

                $("#subtotalE").val('Q.'+subTotal.toFixed(2));
        }else {
            var subTotal = 0;

            var precioU = $("#precioUE").val(); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidadE").val();

                subTotal = cantidad * precioU;

                $("#subtotalE").val('Q.'+subTotal.toFixed(2));
        }
    });
    $("#precioUE").change(function() {

            var subTotal = 0;

            var precioU = $("#precioUE").val(); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidadE").val();

                subTotal = cantidad * precioU;

                $("#subtotalE").val('Q.'+subTotal.toFixed(2));
    });
});

  function agregarproductofE() {
    $("#codigoE").change();

    // $("#cantidadE").change();
    if($.isNumeric($("#cantidadE").val()) && $("#subtotalE").val().substring(2) != 0) {

        validateRowE();
      limpiarFilaDetalleE();
    }
  }

  function validateRowE(){
    $('#tablaDetalleE').each(function(index, tr) {
        var cantTim = $('#cantidadE').val();
        var combo = document.getElementById("codigoE");
        var selected = combo.options[combo.selectedIndex].text;
        var nFilas = $("#tablaDetalleE tr").length;
        if((nFilas == 1) && ($('#codigoE').val() != "")){
            addnewrowE();
            getTimbres(selected, cantTim);
        }else if (nFilas > 1){
            var filas = $("#tablaDetalleE").find("tr");

            for(var i= 0; i < filas.length; i++){
                if(($('#categoria_idE').val() == 1) || ($('#categoria_idE').val() == 3)){
                    for(var i= 0; i < filas.length; i++){

                        var celdas = $(filas[i]).find("td");

                        var nuevoSubTotal = 0;
                        var subTotalColeNue = $('#subtotalE').val().substring(2);
                        var subTotalColeAnt = $($(celdas[5])).text().substring(2);

                        var codigoAnt = $($(celdas[0])).text();

                        var totalCant = 0;
                        var cantidadA = $($(celdas[2])).text();
                        var cantidadN = $('#cantidadE').val();
                        totalCant = Number(cantidadA) + Number(cantidadN);

                        if(codigoAnt == $('#codigoE').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = 'Q.'+nuevoSubTotal.toFixed(2);

                            getTotalE();
                            getTimbres(selected, totalCant);
                            limpiarFilaDetalleE();
                            document.getElementById('existencia').style.display = "none";$('#existencia').val('');
                            document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
                            document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
                            finish();
                        }
                    }
                addnewrowE();
                getTimbres(selected, cantTim);
                }else{
                    var arrayColCatId = new Array();
                    $('#tablaDetalleE tbody tr td:nth-child(7)').each(function () {
                        arrayColCatId.push($(this).text());
                    });

                    var arrayColCodigo = new Array();
                    $('#tablaDetalleE tbody tr td:nth-child(1)').each(function () {
                        arrayColCodigo.push($(this).text());
                    });

                        if (arrayColCatId.includes($('#categoria_idE').val()) && arrayColCodigo.includes($('#codigoE').val())){
                            alertify.warning('/.tipo de pago ya ha sido ingresado./');
                            finish();
                        }else if(($('#codigoE').val() != "")){
                            addnewrowE();
                            getTimbres(selected, cantTim);
                            limpiarFilaDetalleE();
                            finish();
                        }
                }
            }
        }
    });
}

  function addnewrowE() {
    if ($("#precioUE").val().substring(-1,2) == 'Q.'){
        var precioUE = $("#precioUE").val();
    }else {
        var precioUE = 'Q.'+($("#precioUE").val());
    }

	if(!$('#tablaDetalleE').length) {
		var resultado = '<table class="table table-striped table-hover" id="tablaDetalle"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th style:"display: none;">categoria_id</th><th>Eliminar</th></tr></thead><tbody>';
		resultado += '</tbody></table>';
		$("#detalleE").html(resultado);
	}
	var resultado = "";
	resultado += '<tr class="filaDetalleVal">';


	resultado += '<td class="codigoE" id="codigoE" style="display: none;">';
	resultado += $("#codigoE").val();
    resultado += '</td>';

    resultado += '<td class="nombreCodigoE" id="nombreCodigoE">';
	resultado += $('#codigoE option:selected').text().split(" ", 1);
	resultado += '</td>';

	resultado += '<td class="cantidadE" id="cantidadE">';
	resultado += $("#cantidadE").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += precioUE;
	resultado += '</td>';

	resultado += '<td class="descTipoPagoE">';
	resultado += $("#descTipoPagoE").val();
	resultado += '</td>';

	resultado += '<td align="right" class="subtotalE">';
	resultado += $("#subtotalE").val();
	resultado += '</td>';

    resultado += '<td align="center" class="categoria_idE" style="display: none;">';
	resultado += $("#categoria_idE").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += '<button class="form-button btn btn-danger" onclick="eliminardetalleE(this)" type="button">X</button>';
	resultado += '</td>';
	resultado += '</tr>';



	$(resultado).prependTo("#tablaDetalleE > tbody");
   getTotalE();
    document.getElementById('existencia').style.display = "none";$('#existencia').val('');
    document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
    document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
}

function getTotalE() {
    var totalE = 0;
    $("#tablaDetalleE .subtotalE").each(function (index, element) {
      totalE += parseInt($(this).html().substring(2));
    });

    $("#totalE").val('Q.'+totalE.toFixed(2));
}

  function limpiarFilaDetalleE() {
    $("select[name='codigoE']").selectpicker('refresh').val('').selectpicker('refresh').trigger('change');
    $("input[name='cantidadE']").val(1);
    $("input[name='precioUE']").val('').prop('disabled', true);
    $("input[name='descTipoPagoE']").val('');
    $("input[name='subtotalE']").val('');
    $("#codigoE").focus();
  }

  function eliminardetalleE(e) {
	if (confirm("Confirma que desea eliminar este producto") == false) {
		return;
	}
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC01" || $(e).closest('tr').find("td")[1].innerHTML == "TIM1" || $(e).closest('tr').find("td")[1].innerHTML == "TE01"){
        document.getElementById('datoTc01E').style.display = "none";
        $("input[name='tc01E']").val('');
        $('#tc01inicioE').val('');
        $('#tc01finE').val('');
        document.getElementById('datoTc01').style.display = "none";
        $("input[name='tc01']").val('');
        $('#tc01inicio').val('');
        $('#tc01fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC05" || $(e).closest('tr').find("td")[1].innerHTML == "TIM5" || $(e).closest('tr').find("td")[1].innerHTML == "TE05"){
        document.getElementById('datoTc05E').style.display = "none";
        $("input[name='tc05E']").val('');
        $('#tc05inicioE').val('');
        $('#tc05finE').val('');
        document.getElementById('datoTc05').style.display = "none";
        $("input[name='tc05']").val('');
        $('#tc05inicio').val('');
        $('#tc05fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC10" || $(e).closest('tr').find("td")[1].innerHTML == "TIM10" || $(e).closest('tr').find("td")[1].innerHTML == "TE10"){
        document.getElementById('datoTc10E').style.display = "none";
        $("input[name='tc10E']").val('');
        $('#tc10inicioE').val('');
        $('#tc10finE').val('');
        document.getElementById('datoTc10').style.display = "none";
        $("input[name='tc10']").val('');
        $('#tc10inicio').val('');
        $('#tc10fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC20" || $(e).closest('tr').find("td")[1].innerHTML == "TIM20" || $(e).closest('tr').find("td")[1].innerHTML == "TE20"){
        document.getElementById('datoTc20E').style.display = "none";
        $("input[name='tc20E']").val('');
        $('#tc20inicioE').val('');
        $('#tc20finE').val('');
        document.getElementById('datoTc20').style.display = "none";
        $("input[name='tc20']").val('');
        $('#tc20inicio').val('');
        $('#tc20fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC50" || $(e).closest('tr').find("td")[1].innerHTML == "TIM50" || $(e).closest('tr').find("td")[1].innerHTML == "TE50"){
        document.getElementById('datoTc50E').style.display = "none";
        $("input[name='tc50E']").val('');
        $('#tc50inicioE').val('');
        $('#tc50finE').val('');
        document.getElementById('datoTc50').style.display = "none";
        $("input[name='tc50']").val('');
        $('#tc50inicio').val('');
        $('#tc50fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC100" || $(e).closest('tr').find("td")[1].innerHTML == "TIM100" || $(e).closest('tr').find("td")[1].innerHTML == "TE100"){
        document.getElementById('datoTc100E').style.display = "none";
        $("input[name='tc100E']").val('');
        $('#tc100inicioE').val('');
        $('#tc100finE').val('');
        document.getElementById('datoTc100').style.display = "none";
        $("input[name='tc100']").val('');
        $('#tc100inicio').val('');
        $('#tc100fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC200" || $(e).closest('tr').find("td")[1].innerHTML == "TIM200" || $(e).closest('tr').find("td")[1].innerHTML == "TE200"){
        document.getElementById('datoTc200E').style.display = "none";
        $("input[name='tc200E']").val('');
        $('#tc200inicioE').val('');
        $('#tc200finE').val('');
        document.getElementById('datoTc200').style.display = "none";
        $("input[name='tc200']").val('');
        $('#tc200inicio').val('');
        $('#tc200fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC500" || $(e).closest('tr').find("td")[1].innerHTML == "TIM500" || $(e).closest('tr').find("td")[1].innerHTML == "TE500"){
        document.getElementById('datoTc500E').style.display = "none";
        $("input[name='tc500E']").val('');
        $('#tc500inicioE').val('');
        $('#tc500finE').val('');
        document.getElementById('datoTc500').style.display = "none";
        $("input[name='tc500']").val('');
        $('#tc500inicio').val('');
        $('#tc500fin').val('');
    }

	$(e).closest('tr').remove();
  getTotalE();
  limpiarFilaDetalleE();
}

function comprobarCheckEfectivoE()
{
    if (document.getElementById("tipoDePagoEfectivoE").checked){
        document.getElementById('montoefectivoE').readOnly = false;
    }
    else{
        document.getElementById('montoefectivoE').readOnly = true;
        $('input[name="montoefectivoE"]').val('');
    }
}

function comprobarCheckChequeE()
{
    if (document.getElementById("tipoDePagoChequeE").checked){
        document.getElementById('montoChequeE').readOnly = false;
        document.getElementById('chequeE').style.display = "";
        document.getElementById('bancoE').style.display = "";
    }
    else{
        document.getElementById('montoChequeE').readOnly = true;
        document.getElementById('chequeE').style.display = "none";
        document.getElementById('bancoE').style.display = "none";
        $('input[name="chequeE"]').val('');
        $('input[name="montoChequeE"]').val('');
        $('select[name="bancoE"]').val('');
    }
}

function comprobarCheckTarjetaE()
{
    if (document.getElementById("tipoDePagoTarjetaE").checked){
        document.getElementById('montoTarjetaE').readOnly = false;
        document.getElementById('tarjetaE').style.display = "";
        document.getElementById('posE').style.display = "";
    }
    else{
        document.getElementById('montoTarjetaE').readOnly = true;
        document.getElementById('tarjetaE').style.display = "none";
        document.getElementById('posE').style.display = "none";
        $('input[name="tarjetaE"]').val('');
        $('input[name="montoTarjetaE"]').val('');
        $('select[name="posE"]').val('');
    }
}

function comprobarCheckDepositoE()
{
    if (document.getElementById("tipoDePagoDepositoE").checked){
        document.getElementById('montoDepositoE').readOnly = false;
        document.getElementById('depositoE').style.display = "";
        document.getElementById('fechaDepositoE').style.display = "";
        document.getElementById('bancoDepositoE').style.display = "";
    }
    else{
        document.getElementById('montoDepositoE').readOnly = true;
        document.getElementById('depositoE').style.display = "none";
        document.getElementById('fechaDepositoE').style.display = "none";
        document.getElementById('bancoDepositoE').style.display = "none";
        $('input[name="depositoE"]').val('');
        $('input[name="montoDepositoE"]').val('');
        $('input[name="fechaDepositoE"]').val('');
        $('select[name="bancoDepositoE"]').val('');
    }
}

$(document).ready(function(){
    var validatorE = $('#empresaForm').validate({
        ignore: [],
        onkeyup:false,
        rules: {
            nit:{
                required: true
            }
        },
        messages: {
            nit: {
                required: "ingrese el NIT"
            }
        }
    });
});

$("#guardarReciboE").click(function(e){

    if ($('#empresaForm').valid()) {

    $('#emisionDeRecibo').val('empresa');
    $('#tipoDeCliente').val('e');
    var efectivoCorrecto = 0;
    var chequeCorrecto = 0;
    var tarjetaCorrecta = 0;
    var depositoCorrecto = 0;

    if (document.getElementById("tipoDePagoEfectivoE").checked){
        if ($('#montoefectivoE').val() == 0){
            alertify.warning('el monto de efectivo no puede ser 0...');
        } else {efectivoCorrecto = 1; $('#pagoEfectivoE').val("si");}
    } else {efectivoCorrecto = 1; $('#pagoEfectivoE').val("no");}
    if (document.getElementById("tipoDePagoChequeE").checked){
        if ($('#chequeE').val() == 0){
            alertify.warning('los datos de cheque no pueden ir vacios...');
        } else {chequeCorrecto = 1;}
        if ($('#montoChequeE').val() == 0){
            alertify.warning('el monto del cheque no puede ser 0...');
            chequeCorrecto = 0;
        } else {chequeCorrecto = 1;}
        if ($('#bancoE').val() == 0){
            alertify.warning('opción de banco no puede estar vacio...');
            chequeCorrecto = 0;
        } else {chequeCorrecto = 1; $('#pagoChequeE').val("si");}
    } else {chequeCorrecto = 1; $('#pagoChequeE').val("no");}
    if (document.getElementById("tipoDePagoTarjetaE").checked){
        if ($('#tarjetaE').val() == 0){
            alertify.warning('los datos de tarjeta no pueden ir vacios...');
        } else {tarjetaCorrecta = 1;}
        if ($('#montoTarjetaE').val() == 0){
            alertify.warning('el monto de tarjeta no puede ser 0...');
            tarjetaCorrecta = 0;
        } else{tarjetaCorrecta = 1;}
        if ($('#posE').val() == 0){
            alertify.warning('Selector de POS no puede ser vacio...');
            tarjetaCorrecta = 0;
        }else {tarjetaCorrecta = 1; $('#pagoTarjetaE').val("si");}
    } else {tarjetaCorrecta = 1; $('#pagoTarjetaE').val("no");} // FIN TARJETA
    if (document.getElementById("tipoDePagoDepositoE").checked){
        if ($('#depositoE').val() == 0){
            alertify.warning('los datos de depósito no pueden ir vacios...');
        } else {depositoCorrecto = 1;}
        if ($('#montoDepositoE').val() == 0){
            alertify.warning('el monto de depósito no puede ser 0...');
            depositoCorrecto = 0;
        } else {depositoCorrecto = 1;}
        if ($('#bancoDepositoE').val() == 0){
            alertify.warning('opción de banco no puede estar vacio...');
            depositoCorrecto = 0;
        } else {depositoCorrecto = 1; $('#pagoDepositoE').val("si");}
    } else {depositoCorrecto = 1; $('#pagoDepositoE').val("no");}

    if ((document.getElementById("tipoDePagoEfectivoE").checked != true)  && (document.getElementById("tipoDePagoChequeE").checked != true) && (document.getElementById("tipoDePagoTarjetaE").checked != true) && (document.getElementById("tipoDePagoDepositoE").checked != true)){
        alertify.warning('Seleccione un tipo de pago');
    }else if (efectivoCorrecto == 1 && chequeCorrecto == 1 && tarjetaCorrecta == 1 && depositoCorrecto == 1){
        var totalEfectivo = $('#montoefectivoE').val();
        var totalCheque = $('#montoChequeE').val();
        var totalTarjeta = $('#montoTarjetaE').val();
        var totalDeposito = $('#montoDepositoE').val();
        var totalPago = Number(totalEfectivo) + Number(totalCheque) + Number(totalTarjeta) + Number(totalDeposito);
        if(totalPago == $("#totalE").val().substring(2)){

                if(document.getElementById("serieReciboA").checked == true){
                    $('#tipoSerieReciboE').val('a');
                }else if(document.getElementById("serieReciboB").checked == true){
                    $('#tipoSerieReciboE').val('b');
                }

                var banco = $('#bancoE').val();
                var pos = $('#posE').val();
                var bancoDepositoE = $('#bancoDepositoE').val();

                var config = {};
                $('input').each(function () {
                config[this.name] = this.value;
                });

                let datos = [].map.call(document.getElementById('tablaDetalleE').rows,
                tr => [tr.cells[0].textContent, tr.cells[1].textContent, tr.cells[2].textContent, tr.cells[3].textContent, tr.cells[4].textContent, tr.cells[5].textContent, tr.cells[6].textContent]);

            $('.loader').fadeIn();
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
                url: "/creacionRecibo/save/empresa",
                data: {config, datos, pos, banco, bancoDepositoE},
                datatype: "json",
                success: function() {
                    $('.loader').fadeOut(1000);
                    limpiarPantallaE();
                    limpiarTimbres();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Recibo almacenado con Éxito!!');
                },
                error: function(){
                    $('.loader').fadeOut(1000);
                }
            });
        }else if(totalPago > $("#totalE").val().substring(2)){
            alertify.warning('monto de pago es mayor al total');
        }
        else if(totalPago < $("#totalE").val().substring(2)){
            alertify.warning('monto de pago es menor al total');
        }
    }

    } else {
        validatorE.focusInvalid();
    }
})

function limpiarPantallaE()
{
    $('select[name="codigoE"]').val('');
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[name="montoefectivoE"]').val('');
    $('input[name="chequeE"]').val('');
    $('input[name="montoChequeE"]').val('');
    $('input[name="tarjetaE"]').val('');
    $('input[name="montoTarjetaE"]').val('');
    $("tbody").children().remove();
    $('input[name="tipoDePagoE"]').prop('checked', false);
    comprobarCheckEfectivoE();
    comprobarCheckChequeE();
    comprobarCheckTarjetaE();
    comprobarCheckDepositoE();
}

//Funcionamiento sobre Particular

function getAspirante() {
    limpiarFilaDetalleP();
    if ($('#aspirante').prop('checked') == true) {
        var valid = $('#dpi').val();
        document.getElementById('montotimbreDiv').style.display = "";$('#monto_timbreP').val('');
        $.ajax({
            type: "GET",
            url: "/getAsporante/existenciaDpi/"+valid,
            dataType: "json",
            success: function (msg) {
                // valid=!msg;
                if(msg == false) {
                    alertify.error('DPI no pertenece a Aspirante');
                    alertify.set('notifier','position', 'top-center');
                    $('#dpi').val('');
                    $('#nombreP').val('');
                    $('#emailp').val('');
                    $('#monto_timbreP').val('');
                } else {
                    $('#nombreP').val(msg[0].nombre + ' ' + msg[0].apellidos);
                    $('#emailp').val(msg[0].correo);
                    $('#monto_timbreP').val('Q.'+parseInt(msg[0].montoTimbre).toFixed(2));
                }
            }
        });
        cambioSerieAspirante();
    } else {
        var esAspirante = 'no';
        document.getElementById('montotimbreDiv').style.display = "none";$('#monto_timbreP').val('');
        cambioSerie();
    }
}

function cambioSerieAspirante() {
    $("select[name='codigo']").empty();
    $("select[name='codigoE']").empty();
    $("select[name='codigoP']").empty();
        $("tbody").children().remove();
        getTotal();
        var datoSelected = $('input[name=tipoCliente]:checked').val();
        if(document.getElementById("serieReciboA").checked) {
            var stateID = 'a';
            $.ajax({
                type: "GET",
                url: '/tipo/ajax/aspirante',
                data: {stateID, datoSelected},
                dataType: "json",
                success:function(data) {
                    $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                    $('#codigoP').append( '<option value="">-- Escoja --</option>' );
                    for (i = 0; i < data.length; i++)
                    {
                        $('#codigoP').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+'</option>' );
                    }
                }
            });
        }else if(document.getElementById("serieReciboB").checked) {
            var stateID = 'b';
            $.ajax({
                type: "GET",
                url: '/tipo/ajax/aspirante',
                data: {stateID, datoSelected},
                dataType: "json",
                success:function(data) {
                    $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                    $('#codigoP').append( '<option value="">-- Escoja --</option>' );
                    for (i = 0; i < data.length; i++)
                    {
                        $('#codigoP').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+'</option>' );
                    }
            }
            });
        }
}

$(document).ready(function () {
    $("#codigoP").change (function () {
        $("input[name='precioUP']").prop('disabled', true);
        var valor = $("#codigoP").val();
        if(document.getElementById("serieReciboA").checked == true){
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoA/' + valor,
                success: function(response){
                    if($("#codigoP").val() != ""){
                        if (response.precio_particular == 0){
                            $("input[name='precioUP']").prop('disabled', false).val('');
                            $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                            $("input[name='subtotalP']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='categoria_idP']").val(response.categoria_id);

                            $("#cantidadE").val(1);
                        } else {

                            $("input[name='precioUP']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                            $("input[name='subtotalP']").val('Q.'+response.precio_particular.toFixed(2));
                            $("input[name='categoria_idP']").val(response.categoria_id);

                            $("#cantidadP").val(1);
                        }
                    }
                },
                error: function() {
                        $("input[name='cantidadP']").val(1);
                        $("input[name='precioUP']").val('');
                        $("input[name='descTipoPagoP']").val('');
                        $("input[name='subtotalP']").val('');
                        $("input[name='categoria_idP']").val('');
                }
            });
        }else if(document.getElementById("serieReciboB").checked == true){
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoB/' + valor,
                success: function(response){
                    if($("#codigoP").val() != ""){
                        if (response.precio_particular == 0){

                            if ($("#codigoP").val() == 62){
                                $("input[name='precioUP']").val($('#monto_timbreP').val());
                                $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                                $("input[name='subtotalP']").val($('#monto_timbreP').val());
                                $("input[name='categoria_idP']").val(response.categoria_id);

                                $("#cantidadP").val(1);
                                consultaTimbre();
                            }else {
                                $("input[name='precioUP']").prop('disabled', false).val('');
                                $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                                $("input[name='subtotalP']").val('Q.'+response.precio_particular.toFixed(2));
                                $("input[name='categoria_idP']").val(response.categoria_id);

                                $("#cantidadP").val(1);
                            }
                        } else {

                            if ($("#codigoP").val() == 62){
                                $("input[name='precioUP']").val($('#monto_timbreP').val());
                                $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                                $("input[name='subtotalP']").val($('#monto_timbreP').val());
                                $("input[name='categoria_idP']").val(response.categoria_id);

                                $("#cantidadP").val(1);
                                consultaTimbre();
                            }else {

                                $("input[name='precioUP']").val('Q.'+response.precio_particular.toFixed(2));
                                $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                                $("input[name='subtotalP']").val('Q.'+response.precio_particular.toFixed(2));
                                $("input[name='categoria_idP']").val(response.categoria_id);
                                consultaTimbre();

                                $("#cantidadP").val(1);
                            }
                        }
                    }
                },
                error: function() {
                        $("input[name='cantidadP']").val(1);
                        $("input[name='precioUP']").val('');
                        $("input[name='descTipoPagoP']").val('');
                        $("input[name='subtotalP']").val('');
                        $("input[name='categoria_idP']").val('');
                }
            });
        }
        if (valor == ''){
            document.getElementById('existencia').style.display = "none";$('#existencia').val('');
            document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
            document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
        }
    });
});

$(document).ready(function(){
    $("#cantidadP").change(function() {

        if ($("input[name='precioUP']").prop('disabled') == true){
            var subTotal = 0;

            var precioU = $("#precioUP").val().substring(2); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidadP").val();

                subTotal = cantidad * precioU;

                $("#subtotalP").val('Q.'+subTotal.toFixed(2));
        }else {
            var subTotal = 0;

            var precioU = $("#precioUP").val(); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidadP").val();

                subTotal = cantidad * precioU;

                $("#subtotalP").val('Q.'+subTotal.toFixed(2));
        }
    });
    $("#precioUP").change(function() {

            var subTotal = 0;

            var precioU = $("#precioUP").val(); // Convertir el valor a un entero (número).
            var cantidad = $("#cantidadP").val();

                subTotal = cantidad * precioU;

                $("#subtotalP").val('Q.'+subTotal.toFixed(2));
    });
});

function agregarproductofP() {
    $("#codigoP").change();

    // $("#cantidadP").change();
    if($.isNumeric($("#cantidadP").val()) && $("#subtotalP").val().substring(2) != 0) {

        validateRowP();
      limpiarFilaDetalleP();
    }
  }

  function validateRowP(){
    $('#tablaDetalleP').each(function(index, tr) {
        var cantTim = $('#cantidadP').val();
        var combo = document.getElementById("codigoP");
        var selected = combo.options[combo.selectedIndex].text;
        var nFilas = $("#tablaDetalleP tr").length;
        if((nFilas == 1) && ($('#codigoP').val() != "")){
            if ($('#codigoP').val() == 62){
                var indicador = $('#subtotalP').val().substring(2);
                mensualidadTimbre(indicador);
                addnewrowP();
            }else {
                addnewrowP();
                getTimbres(selected, cantTim);
            }
        }else if (nFilas > 1){
            var filas = $("#tablaDetalleP").find("tr");

            for(var i= 0; i < filas.length; i++){
                if(($('#categoria_idP').val() == 1) || ($('#categoria_idP').val() == 3)){
                    for(var i= 0; i < filas.length; i++){

                        var celdas = $(filas[i]).find("td");

                        var nuevoSubTotal = 0;
                        var subTotalColeNue = $('#subtotalP').val().substring(2);
                        var subTotalColeAnt = $($(celdas[5])).text().substring(2);

                        var codigoAnt = $($(celdas[0])).text();

                        var totalCant = 0;
                        var cantidadA = $($(celdas[2])).text();
                        var cantidadN = $('#cantidadP').val();
                        totalCant = Number(cantidadA) + Number(cantidadN);

                        if(codigoAnt == $('#codigoP').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = 'Q.'+nuevoSubTotal.toFixed(2);

                            if (codigoAnt == 62) {

                                var indicador = nuevoSubTotal;
                                mensualidadTimbre(indicador);
                                getTotalP();
                                limpiarFilaDetalleP();
                                document.getElementById('existencia').style.display = "none";$('#existencia').val('');
                                document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
                                document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
                                finish();

                            } else {

                                getTotalP();
                                getTimbres(selected, totalCant);
                                limpiarFilaDetalleP();
                                document.getElementById('existencia').style.display = "none";$('#existencia').val('');
                                document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
                                document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
                                finish();
                            }
                        }
                    }
                addnewrowP();
                getTimbres(selected, totalCant);
                }else{
                    var arrayColCatId = new Array();
                    $('#tablaDetalleP tbody tr td:nth-child(7)').each(function () {
                        arrayColCatId.push($(this).text());
                    });

                    var arrayColCodigo = new Array();
                    $('#tablaDetalleP tbody tr td:nth-child(1)').each(function () {
                        arrayColCodigo.push($(this).text());
                    });

                        if (arrayColCatId.includes($('#categoria_idP').val()) && arrayColCodigo.includes($('#codigoP').val())){
                            alertify.warning('/.tipo de pago ya ha sido ingresado./');
                            finish();
                        }else if(($('#codigoP').val() != "")){
                            addnewrowP();
                            getTimbres(selected,cantTim);
                            limpiarFilaDetalleP();
                            finish();
                        }
                }
            }
        }
    });
}

  function addnewrowP() {
    if ($("#precioUP").val().substring(-1,2) == 'Q.'){
        var precioUP = $("#precioUP").val();
    }else {
        var precioUP = 'Q.'+($("#precioUP").val());
    }

	if(!$('#tablaDetalleP').length) {
		var resultado = '<table class="table table-striped table-hover" id="tablaDetalle"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th style:"display: none;">categoria_id</th><th>Eliminar</th></tr></thead><tbody>';
		resultado += '</tbody></table>';
		$("#detalleP").html(resultado);
	}
	var resultado = "";
	resultado += '<tr class="filaDetalleVal">';


	resultado += '<td class="codigoP" id="codigoP" style="display: none;">';
	resultado += $("#codigoP").val();
    resultado += '</td>';

    resultado += '<td class="nombreCodigoP" id="nombreCodigoP">';
	resultado += $('#codigoP option:selected').text().split(" ", 1);
	resultado += '</td>';

	resultado += '<td class="cantidadP" id="cantidadP">';
	resultado += $("#cantidadP").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += precioUP;
	resultado += '</td>';

	resultado += '<td class="descTipoPagoP">';
	resultado += $("#descTipoPagoP").val();
	resultado += '</td>';

	resultado += '<td align="center" class="subtotalP">';
	resultado += $("#subtotalP").val();
	resultado += '</td>';

    resultado += '<td align="center" class="categoria_idP" style="display: none;">';
	resultado += $("#categoria_idP").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += '<button class="form-button btn btn-danger" onclick="eliminardetalleP(this)" type="button">X</button>';
	resultado += '</td>';
	resultado += '</tr>';

	$(resultado).prependTo("#tablaDetalleP > tbody");
   getTotalP();
    document.getElementById('existencia').style.display = "none";$('#existencia').val('');
    document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
    document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
}



function getTotalP() {
    var total = 0;
    $("#tablaDetalleP .subtotalP").each(function (index, element) {
      total += parseInt($(this).html().substring(2));
    });

    $("#totalP").val('Q.'+total.toFixed(2));
}

function limpiarFilaDetalleP() {
$("select[name='codigoP']").selectpicker('refresh').val('').selectpicker('refresh').trigger('change');
$("input[name='cantidadP']").val(1);
$("input[name='precioUP']").val('').prop('disabled', true);;
$("input[name='descTipoPagoP']").val('');
$("input[name='subtotalP']").val('');
$("#codigoP").focus();
}

function eliminardetalleP(e) {
	if (confirm("Confirma que desea eliminar este producto") == false) {
		return;
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC01" || $(e).closest('tr').find("td")[1].innerHTML == "TIM1" || $(e).closest('tr').find("td")[1].innerHTML == "TE01"){
        document.getElementById('datoTc01E').style.display = "none";
        $("input[name='tc01E']").val('');
        $('#tc01inicioE').val('');
        $('#tc01finE').val('');
        document.getElementById('datoTc01').style.display = "none";
        $("input[name='tc01']").val('');
        $('#tc01inicio').val('');
        $('#tc01fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC05" || $(e).closest('tr').find("td")[1].innerHTML == "TIM5" || $(e).closest('tr').find("td")[1].innerHTML == "TE05"){
        document.getElementById('datoTc05E').style.display = "none";
        $("input[name='tc05E']").val('');
        $('#tc05inicioE').val('');
        $('#tc05finE').val('');
        document.getElementById('datoTc05').style.display = "none";
        $("input[name='tc05']").val('');
        $('#tc05inicio').val('');
        $('#tc05fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC10" || $(e).closest('tr').find("td")[1].innerHTML == "TIM10" || $(e).closest('tr').find("td")[1].innerHTML == "TE10"){
        document.getElementById('datoTc10E').style.display = "none";
        $("input[name='tc10E']").val('');
        $('#tc10inicioE').val('');
        $('#tc10finE').val('');
        document.getElementById('datoTc10').style.display = "none";
        $("input[name='tc10']").val('');
        $('#tc10inicio').val('');
        $('#tc10fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC20" || $(e).closest('tr').find("td")[1].innerHTML == "TIM20" || $(e).closest('tr').find("td")[1].innerHTML == "TE20"){
        document.getElementById('datoTc20E').style.display = "none";
        $("input[name='tc20E']").val('');
        $('#tc20inicioE').val('');
        $('#tc20finE').val('');
        document.getElementById('datoTc20').style.display = "none";
        $("input[name='tc20']").val('');
        $('#tc20inicio').val('');
        $('#tc20fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC50" || $(e).closest('tr').find("td")[1].innerHTML == "TIM50" || $(e).closest('tr').find("td")[1].innerHTML == "TE50"){
        document.getElementById('datoTc50E').style.display = "none";
        $("input[name='tc50E']").val('');
        $('#tc50inicioE').val('');
        $('#tc50finE').val('');
        document.getElementById('datoTc50').style.display = "none";
        $("input[name='tc50']").val('');
        $('#tc50inicio').val('');
        $('#tc50fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC100" || $(e).closest('tr').find("td")[1].innerHTML == "TIM100" || $(e).closest('tr').find("td")[1].innerHTML == "TE100"){
        document.getElementById('datoTc100E').style.display = "none";
        $("input[name='tc100E']").val('');
        $('#tc100inicioE').val('');
        $('#tc100finE').val('');
        document.getElementById('datoTc100').style.display = "none";
        $("input[name='tc100']").val('');
        $('#tc100inicio').val('');
        $('#tc100fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC200" || $(e).closest('tr').find("td")[1].innerHTML == "TIM200" || $(e).closest('tr').find("td")[1].innerHTML == "TE200"){
        document.getElementById('datoTc200E').style.display = "none";
        $("input[name='tc200E']").val('');
        $('#tc200inicioE').val('');
        $('#tc200finE').val('');
        document.getElementById('datoTc200').style.display = "none";
        $("input[name='tc200']").val('');
        $('#tc200inicio').val('');
        $('#tc200fin').val('');
    }
    if ($(e).closest('tr').find("td")[1].innerHTML == "TC500" || $(e).closest('tr').find("td")[1].innerHTML == "TIM500" || $(e).closest('tr').find("td")[1].innerHTML == "TE500"){
        document.getElementById('datoTc500E').style.display = "none";
        $("input[name='tc500E']").val('');
        $('#tc500inicioE').val('');
        $('#tc500finE').val('');
        document.getElementById('datoTc500').style.display = "none";
        $("input[name='tc500']").val('');
        $('#tc500inicio').val('');
        $('#tc500fin').val('');
    }

	$(e).closest('tr').remove();
  getTotalP();
  limpiarFilaDetalleP();
}

function comprobarCheckEfectivoP()
{
    if (document.getElementById("tipoDePagoEfectivoP").checked){
        document.getElementById('montoefectivoP').readOnly = false;
    }
    else{
        document.getElementById('montoefectivoP').readOnly = true;
        $('input[name="montoefectivoP"]').val('');
    }
}

function comprobarCheckChequeP()
{
    if (document.getElementById("tipoDePagoChequeP").checked){
        document.getElementById('montoChequeP').readOnly = false;
        document.getElementById('chequeP').style.display = "";
        document.getElementById('bancoP').style.display = "";
    }
    else{
        document.getElementById('montoChequeP').readOnly = true;
        document.getElementById('chequeP').style.display = "none";
        document.getElementById('bancoP').style.display = "none";
        $('input[name="chequeP"]').val('');
        $('input[name="montoChequeP"]').val('');
        $('select[name="bancoP"]').val('');
    }
}

function comprobarCheckTarjetaP()
{
    if (document.getElementById("tipoDePagoTarjetaP").checked){
        document.getElementById('montoTarjetaP').readOnly = false;
        document.getElementById('tarjetaP').style.display = "";
        document.getElementById('posP').style.display = "";
    }
    else{
        document.getElementById('montoTarjetaP').readOnly = true;
        document.getElementById('tarjetaP').style.display = "none";
        document.getElementById('posP').style.display = "none";
        $('input[name="tarjetaP"]').val('');
        $('input[name="montoTarjetaP"]').val('');
        $('select[name="posP"]').val('');
    }
}

function comprobarCheckDepositoP()
{
    if (document.getElementById("tipoDePagoDepositoP").checked){
        document.getElementById('montoDepositoP').readOnly = false;
        document.getElementById('depositoP').style.display = "";
        document.getElementById('fechaDepositoP').style.display = "";
        document.getElementById('bancoDepositoP').style.display = "";
    }
    else{
        document.getElementById('montoDepositoP').readOnly = true;
        document.getElementById('depositoP').style.display = "none";
        document.getElementById('fechaDepositoP').style.display = "none";
        document.getElementById('bancoDepositoP').style.display = "none";
        $('input[name="depositoP"]').val('');
        $('input[name="montoDepositoP"]').val('');
        $('input[name="fechaDepositoP"]').val('');
        $('select[name="bancoDepositoP"]').val('');
    }
}

$(document).ready(function(){
    var validatorP = $('#particularForm').validate({
        ignore: [],
        onkeyup:false,
        rules: {
            dpi:{
                required: true
            },
            nombreP:{
                required: true
            },
            emailP:{
                required: true
            }
        },
        messages: {
            dpi:{
                required: "ingrese el DPI"
            },
            nombreP:{
                required: "ingrese el Nombre"
            },
            emailP:{
                required: "ingrese el Email"
            }
        }
    });
});

$("#guardarReciboP").click(function(e){

    if ($('#particularForm').valid()) {

    $('#emisionDeRecibo').val('particular');
    $('#tipoDeCliente').val('p');
    var efectivoCorrecto = 0;
    var chequeCorrecto = 0;
    var tarjetaCorrecta = 0;
    var depositoCorrecto = 0;

    if (document.getElementById("tipoDePagoEfectivoP").checked){
        if ($('#montoefectivoP').val() == 0){
            alertify.warning('el monto de efectivo no puede ser 0...');
        } else {efectivoCorrecto = 1; $('#pagoEfectivoP').val("si");}
    } else {efectivoCorrecto = 1; $('#pagoEfectivoP').val("no");}
    if (document.getElementById("tipoDePagoChequeP").checked){
        if ($('#chequeP').val() == 0){
            alertify.warning('los datos de cheque no pueden ir vacios...');
        } else {chequeCorrecto = 1;}
        if ($('#montoChequeP').val() == 0){
            alertify.warning('el monto del cheque no puede ser 0...');
            chequeCorrecto = 0;
        } else {chequeCorrecto = 1}
        if ($('#bancoP').val() == 0){
            alertify.warning('opción de banco no puede estar vacio...');
            chequeCorrecto = 0;
        } else {chequeCorrecto = 1; $('#pagoChequeP').val("si");}
    } else {chequeCorrecto = 1; $('#pagoChequeP').val("no");}
    if (document.getElementById("tipoDePagoTarjetaP").checked){
        if ($('#tarjetaP').val() == 0){
            alertify.warning('los datos de tarjeta no pueden ir vacios...');
        } else {tarjetaCorrecta = 1;}
        if ($('#montoTarjetaP').val() == 0){
            alertify.warning('el monto de tarjeta no puede ser 0...');
            tarjetaCorrecta = 0;
        } else {tarjetaCorrecta = 1}
        if ($('#posP').val() == 0){
            alertify.warning('Selector de POS no puede ser vacio...');
            tarjetaCorrecta = 0;
        }else {tarjetaCorrecta = 1; $('#pagoTarjetaP').val("si");}
    } else {tarjetaCorrecta = 1; $('#pagoTarjetaP').val("no");} // FIN TARJETA
    if (document.getElementById("tipoDePagoDepositoP").checked){
        if ($('#depositoP').val() == 0){
            alertify.warning('los datos de depósito no pueden ir vacios...');
        } else {depositoCorrecto = 1;}
        if ($('#montoDepositoP').val() == 0){
            alertify.warning('el monto de depósito no puede ser 0...');
            depositoCorrecto = 0;
        } else {depositoCorrecto = 1;}
        if ($('#bancoDepositoP').val() == 0){
            alertify.warning('opción de banco no puede estar vacio...');
            depositoCorrecto = 0;
        } else {depositoCorrecto = 1; $('#pagoDepositoP').val("si");}
    } else {depositoCorrecto = 1; $('#pagoDepositoP').val("no");}

    if ((document.getElementById("tipoDePagoEfectivoP").checked != true)  && (document.getElementById("tipoDePagoChequeP").checked != true) && (document.getElementById("tipoDePagoTarjetaP").checked != true) && (document.getElementById("tipoDePagoDepositoP").checked != true)){
        alertify.warning('Seleccione un tipo de pago');
    }else if (efectivoCorrecto == 1 && chequeCorrecto == 1 && tarjetaCorrecta == 1 && depositoCorrecto == 1){
        var totalEfectivo = $('#montoefectivoP').val();
        var totalCheque = $('#montoChequeP').val();
        var totalTarjeta = $('#montoTarjetaP').val();
        var totalDeposito = $('#montoDepositoP').val();
        var totalPago = Number(totalEfectivo) + Number(totalCheque) + Number(totalTarjeta) + Number(totalDeposito);
        if(totalPago == $("#totalP").val().substring(2)){

                if(document.getElementById("serieReciboA").checked == true){
                    $('#tipoSerieReciboP').val('a');
                }else if(document.getElementById("serieReciboB").checked == true){
                    $('#tipoSerieReciboP').val('b');
                }

                var banco = $('#bancoP').val();
                var pos = $('#posP').val();
                var bancoDepositoP = $('#bancoDepositoP').val();

                var config = {};
                $('input').each(function () {
                config[this.name] = this.value;
                });

                if ($('#aspirante').prop('checked') == true) {var esAspirante = 'si';} else { var esAspirante = 'no';}

                let datos = [].map.call(document.getElementById('tablaDetalleP').rows,
                tr => [tr.cells[0].textContent, tr.cells[1].textContent, tr.cells[2].textContent, tr.cells[3].textContent, tr.cells[4].textContent, tr.cells[5].textContent, tr.cells[6].textContent]);

            $('.loader').fadeIn();
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
                url: "/creacionRecibo/save/particular",
                data: {config, datos, pos, banco, bancoDepositoP, esAspirante},
                datatype: "json",
                success: function() {
                    $('.loader').fadeOut(1000);
                    limpiarPantallaP();
                    limpiarTimbres();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Recibo almacenado con Éxito!!');
                },
                error: function(){
                    $('.loader').fadeOut(1000);
                }
            });
        }else if(totalPago > $("#totalP").val().substring(2)){
            alertify.warning('monto de pago es mayor al total');
        }
        else if(totalPago < $("#totalP").val().substring(2)){
            alertify.warning('monto de pago es menor al total');
        }
    }

    } else {
        validatorP.focusInvalid();
    }
})

function limpiarPantallaP()
{
    $('select[name="codigoP"]').val('');
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[name="montoefectivoP"]').val('');
    $('input[name="chequeP"]').val('');
    $('input[name="montoChequeP"]').val('');
    $('input[name="tarjetaP"]').val('');
    $('input[name="montoTarjetaP"]').val('');
    $("tbody").children().remove();
    $('input[name="tipoDePagoP"]').prop('checked', false);
    comprobarCheckEfectivoP();
    comprobarCheckChequeP();
    comprobarCheckTarjetaP();
    comprobarCheckDepositoP();
}
