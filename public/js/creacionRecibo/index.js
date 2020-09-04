
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
    $("tbody").children().remove();
    $('input[name="tipoDePago"]').prop('checked', false);
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

// FUNCION DE TIMBRES buttonAgregar

function getTc01(){
    if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
    if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
    if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}
    for(var i= 0; i < filas.length; i++){
        var celdas = $(filas[i]).find("td");
        if($($(celdas[1])).text() == "TC01" || $($(celdas[1])).text() == "TIM1" || $($(celdas[1])).text() == "TE01"){
            document.getElementById('datoTc01').style.display = "";
            document.getElementById('datoTc01E').style.display = "";
            document.getElementById('datoTc01P').style.display = "";
            var user = $('#rol_user').val();
            var codigo = $($(celdas[0])).text();
            var nombre = $($(celdas[1])).text();
            var cantidad = $($(celdas[2])).text();
            // if (codigo == 22 || codigo == 38){codigo = 30; nombre = 'TC01';}
            $.ajax({
                type: "POST",
                url: "/consultaTimbres",
                data: {user, codigo, nombre, cantidad},
                dataType: 'json',
                success: function(response){
                    if (Number(response.numeroInicio1) == Number(response.numeroFinal1)){
                        var mensaje = ('Timbre entregado: ' + response.numeroInicio1);
                        $('#tc01').val(mensaje);
                        $('#cantidadDatosTc01').val(response.cantidadDatos);
                        $('#tc01inicio').val(response.numeroInicio1);
                        $('#tc01fin').val(response.numeroFinal1);
                        $('#tc01E').val(mensaje);
                        $('#tc01inicioE').val(response.numeroInicio1);
                        $('#tc01finE').val(response.numeroFinal1);
                        $('#tc01P').val(mensaje);
                        $('#tc01inicioP').val(response.numeroInicio1);
                        $('#tc01finP').val(response.numeroFinal1);
                    } else {
                        var inicio1 = response.numeroInicio1;
                        var fin1 = response.numeroFinal1;
                        var inicio2 = response.numeroInicio2;
                        var fin2 = response.numeroFinal2;
                        var inicio3 = response.numeroInicio3;
                        var fin3 = response.numeroFinal3;
                        if (response.cantidadDatos == '1') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1);
                            $('#tc01').val(mensaje);
                            $('#cantidadDatosTc01').val(response.cantidadDatos);
                            $('#tc01inicio').val(response.numeroInicio1);$('#tc01fin').val(response.numeroFinal1);
                            $('#tc01E').val(mensaje);
                            $('#tc01inicioE').val(response.numeroInicio1);$('#tc01finE').val(response.numeroFinal1);
                            $('#tc01P').val(mensaje);
                            $('#tc01inicioP').val(response.numeroInicio1);$('#tc01finP').val(response.numeroFinal1);
                        }
                        if (response.cantidadDatos == '2') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1 + ' y ' + inicio2 + ' al ' + fin2);
                            $('#tc01').val(mensaje);
                            $('#cantidadDatosTc01').val(response.cantidadDatos);
                            $('#tc01inicio').val(response.numeroInicio1);$('#tc01fin').val(response.numeroFinal1);
                            $('#tc01inicio2').val(response.numeroInicio2);$('#tc01fin2').val(response.numeroFinal2);
                            $('#tc01E').val(mensaje);
                            $('#tc01inicioE').val(response.numeroInicio1);$('#tc01finE').val(response.numeroFinal1);
                            $('#tc01inicioE2').val(response.numeroInicio2);$('#tc01finE2').val(response.numeroFinal2);
                            $('#tc01P').val(mensaje);
                            $('#tc01inicioP').val(response.numeroInicio1);$('#tc01finP').val(response.numeroFinal1);
                            $('#tc01inicioP2').val(response.numeroInicio2);$('#tc01finP2').val(response.numeroFinal2);
                        }
                        if (response.cantidadDatos == '3') {
                            var mensaje = ('Timbres de: ' + inicio1 + ' al ' + fin1 + ', ' + inicio2 + ' al ' + fin2 + ' y ' + inicio3 + ' al ' + fin3);
                            $('#tc01').val(mensaje);
                            $('#cantidadDatosTc01').val(response.cantidadDatos);
                            $('#tc01inicio').val(response.numeroInicio1);$('#tc01fin').val(response.numeroFinal1);
                            $('#tc01inicio2').val(response.numeroInicio2);$('#tc01fin2').val(response.numeroFinal2);
                            $('#tc01inicio3').val(response.numeroInicio3);$('#tc01fin3').val(response.numeroFinal3);
                            $('#tc01E').val(mensaje);
                            $('#tc01inicioE').val(response.numeroInicio1);$('#tc01finE').val(response.numeroFinal1);
                            $('#tc01inicioE2').val(response.numeroInicio2);$('#tc01finE2').val(response.numeroFinal2);
                            $('#tc01inicioE3').val(response.numeroInicio3);$('#tc01finE3').val(response.numeroFinal3);
                            $('#tc01P').val(mensaje);
                            $('#tc01inicioP').val(response.numeroInicio1);$('#tc01finP').val(response.numeroFinal1);
                            $('#tc01inicioP2').val(response.numeroInicio2);$('#tc01finP2').val(response.numeroFinal2);
                            $('#tc01inicioP3').val(response.numeroInicio3);$('#tc01finP3').val(response.numeroFinal3);
                        }
                    }
                },
                error: function(response){
                    var mensaje = response.responseJSON;
                    alertify.set('notifier','position', 'top-center');
                    alertify.warning(mensaje);

                    // $(celdas).closest('tr').remove();
                    var filas = $("#tablaDetalle").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM1') || ($($(celdas[1])).text() == 'TC01') || ($($(celdas[1])).text() == 'TE01')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleE").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM1') || ($($(celdas[1])).text() == 'TC01') || ($($(celdas[1])).text() == 'TE01')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleP").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM1') || ($($(celdas[1])).text() == 'TC01') || ($($(celdas[1])).text() == 'TE01')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }

                    getTotal(); getTotalE(); getTotalP();
                    document.getElementById('datoTc01').style.display = "none";$("input[name='tc01']").val('');$('#tc01inicio').val('');$('#tc01fin').val('');$('#tc01inicio2').val('');$('#tc01fin2').val('');$('#tc01inicio3').val('');$('#tc01fin3').val('');
                    document.getElementById('datoTc01E').style.display = "none";$("input[name='tc01E']").val('');$('#tc01inicioE').val('');$('#tc01finE').val('');$('#tc01inicioE2').val('');$('#tc01finE2').val('');$('#tc01inicioE3').val('');$('#tc01finE3').val('');
                    document.getElementById('datoTc01P').style.display = "none";$("input[name='tc01P']").val('');$('#tc01inicioP').val('');$('#tc01finP').val('');$('#tc01inicioP2').val('');$('#tc01finP2').val('');$('#tc01inicioP3').val('');$('#tc01finP3').val('');
                }
            });
        }
    }
}

function getTc05(){
    if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
    if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
    if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}
    for(var i= 0; i < filas.length; i++){
        var celdas = $(filas[i]).find("td");
        if($($(celdas[1])).text() == "TC05" || $($(celdas[1])).text() == "TIM5" || $($(celdas[1])).text() == "TE05"){
            document.getElementById('datoTc05').style.display = "";
            document.getElementById('datoTc05E').style.display = "";
            document.getElementById('datoTc05P').style.display = "";
            var user = $('#rol_user').val();
            var codigo = $($(celdas[0])).text();
            var nombre = $($(celdas[1])).text();
            var cantidad = $($(celdas[2])).text();
            // if (codigo == 27 || codigo == 39){codigo = 31; nombre = 'TC05';}
            $.ajax({
                type: "POST",
                url: "/consultaTimbres",
                data: {user, codigo, nombre, cantidad},
                dataType: 'json',
                success: function(response){
                    if (Number(response.numeroInicio1) == Number(response.numeroFinal1)){
                        var mensaje = ('Timbre entregado: ' + response.numeroInicio1);
                        $('#tc05').val(mensaje);
                        $('#cantidadDatosTc05').val(response.cantidadDatos);
                        $('#tc05inicio').val(response.numeroInicio1);
                        $('#tc05fin').val(response.numeroFinal1);
                        $('#tc05E').val(mensaje);
                        $('#tc05inicioE').val(response.numeroInicio1);
                        $('#tc05finE').val(response.numeroFinal1);
                        $('#tc05P').val(mensaje);
                        $('#tc05inicioP').val(response.numeroInicio1);
                        $('#tc05finP').val(response.numeroFinal1);
                    } else {
                        var inicio1 = response.numeroInicio1;
                        var fin1 = response.numeroFinal1;
                        var inicio2 = response.numeroInicio2;
                        var fin2 = response.numeroFinal2;
                        var inicio3 = response.numeroInicio3;
                        var fin3 = response.numeroFinal3;
                        if (response.cantidadDatos == '1') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1);
                            $('#tc05').val(mensaje);
                            $('#cantidadDatosTc05').val(response.cantidadDatos);
                            $('#tc05inicio').val(response.numeroInicio1);$('#tc05fin').val(response.numeroFinal1);
                            $('#tc05E').val(mensaje);
                            $('#tc05inicioE').val(response.numeroInicio1);$('#tc05finE').val(response.numeroFinal1);
                            $('#tc05P').val(mensaje);
                            $('#tc05inicioP').val(response.numeroInicio1);$('#tc05finP').val(response.numeroFinal1);
                        }
                        if (response.cantidadDatos == '2') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1 + ' y ' + inicio2 + ' al ' + fin2);
                            $('#tc05').val(mensaje);
                            $('#cantidadDatosTc05').val(response.cantidadDatos);
                            $('#tc05inicio').val(response.numeroInicio1);$('#tc05fin').val(response.numeroFinal1);
                            $('#tc05inicio2').val(response.numeroInicio2);$('#tc05fin2').val(response.numeroFinal2);
                            $('#tc05E').val(mensaje);
                            $('#tc05inicioE').val(response.numeroInicio1);$('#tc05finE').val(response.numeroFinal1);
                            $('#tc05inicioE2').val(response.numeroInicio2);$('#tc05finE2').val(response.numeroFinal2);
                            $('#tc05P').val(mensaje);
                            $('#tc05inicioP').val(response.numeroInicio1);$('#tc05finP').val(response.numeroFinal1);
                            $('#tc05inicioP2').val(response.numeroInicio2);$('#tc05finP2').val(response.numeroFinal2);
                        }
                        if (response.cantidadDatos == '3') {
                            var mensaje = ('Timbres de: ' + inicio1 + ' al ' + fin1 + ', ' + inicio2 + ' al ' + fin2 + ' y ' + inicio3 + ' al ' + fin3);
                            $('#tc05').val(mensaje);
                            $('#cantidadDatosTc05').val(response.cantidadDatos);
                            $('#tc05inicio').val(response.numeroInicio1);$('#tc05fin').val(response.numeroFinal1);
                            $('#tc05inicio2').val(response.numeroInicio2);$('#tc05fin2').val(response.numeroFinal2);
                            $('#tc05inicio3').val(response.numeroInicio3);$('#tc05fin3').val(response.numeroFinal3);
                            $('#tc05E').val(mensaje);
                            $('#tc05inicioE').val(response.numeroInicio1);$('#tc05finE').val(response.numeroFinal1);
                            $('#tc05inicioE2').val(response.numeroInicio2);$('#tc05finE2').val(response.numeroFinal2);
                            $('#tc05inicioE3').val(response.numeroInicio3);$('#tc05finE3').val(response.numeroFinal3);
                            $('#tc05P').val(mensaje);
                            $('#tc05inicioP').val(response.numeroInicio1);$('#tc05finP').val(response.numeroFinal1);
                            $('#tc05inicioP2').val(response.numeroInicio2);$('#tc05finP2').val(response.numeroFinal2);
                            $('#tc05inicioP3').val(response.numeroInicio3);$('#tc05finP3').val(response.numeroFinal3);
                        }
                    }
                },
                error: function(response){
                    var mensaje = response.responseJSON;
                    alertify.set('notifier','position', 'top-center');
                    alertify.warning(mensaje);

                    var filas = $("#tablaDetalle").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM5') || ($($(celdas[1])).text() == 'TC05') || ($($(celdas[1])).text() == 'TE05')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleE").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM5') || ($($(celdas[1])).text() == 'TC05') || ($($(celdas[1])).text() == 'TE05')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleP").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM5') || ($($(celdas[1])).text() == 'TC05') || ($($(celdas[1])).text() == 'TE05')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }

                    getTotal(); getTotalE(); getTotalP();
                    document.getElementById('datoTc05').style.display = "none";$("input[name='tc05']").val('');$('#tc05inicio').val('');$('#tc05fin').val('');$('#tc05inicio2').val('');$('#tc05fin2').val('');$('#tc05inicio3').val('');$('#tc05fin3').val('');
                    document.getElementById('datoTc05E').style.display = "none";$("input[name='tc05E']").val('');$('#tc05inicioE').val('');$('#tc05finE').val('');$('#tc05inicioE2').val('');$('#tc05finE2').val('');$('#tc05inicioE3').val('');$('#tc05finE3').val('');
                    document.getElementById('datoTc05P').style.display = "none";$("input[name='tc05P']").val('');$('#tc05inicioP').val('');$('#tc05finP').val('');$('#tc05inicioP2').val('');$('#tc05finP2').val('');$('#tc05inicioP3').val('');$('#tc05finP3').val('');
                }
            });
        }
    }
}

function getTc10(){
    if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
    if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
    if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}
    for(var i= 0; i < filas.length; i++){
        var celdas = $(filas[i]).find("td");
        if($($(celdas[1])).text() == "TC10" || $($(celdas[1])).text() == "TIM10" || $($(celdas[1])).text() == "TE10"){
            document.getElementById('datoTc10').style.display = "";
            document.getElementById('datoTc10E').style.display = "";
            document.getElementById('datoTc10P').style.display = "";
            var user = $('#rol_user').val();
            var codigo = $($(celdas[0])).text();
            var nombre = $($(celdas[1])).text();
            var cantidad = $($(celdas[2])).text();
            // if (codigo == 23 || codigo == 40){codigo = 32; nombre = 'TC10';}
            $.ajax({
                type: "POST",
                url: "/consultaTimbres",
                data: {user, codigo, nombre, cantidad},
                dataType: 'json',
                success: function(response){
                    if (Number(response.numeroInicio1) == Number(response.numeroFinal1)){
                        var mensaje = ('Timbre entregado: ' + response.numeroInicio1);
                        $('#tc10').val(mensaje);
                        $('#cantidadDatosTc10').val(response.cantidadDatos);
                        $('#tc10inicio').val(response.numeroInicio1);
                        $('#tc10fin').val(response.numeroFinal1);
                        $('#tc10E').val(mensaje);
                        $('#tc10inicioE').val(response.numeroInicio1);
                        $('#tc10finE').val(response.numeroFinal1);
                        $('#tc10P').val(mensaje);
                        $('#tc10inicioP').val(response.numeroInicio1);
                        $('#tc10finP').val(response.numeroFinal1);
                    } else {
                        var inicio1 = response.numeroInicio1;
                        var fin1 = response.numeroFinal1;
                        var inicio2 = response.numeroInicio2;
                        var fin2 = response.numeroFinal2;
                        var inicio3 = response.numeroInicio3;
                        var fin3 = response.numeroFinal3;
                        if (response.cantidadDatos == '1') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1);
                            $('#tc10').val(mensaje);
                            $('#cantidadDatosTc10').val(response.cantidadDatos);
                            $('#tc10inicio').val(response.numeroInicio1);
                            $('#tc10fin').val(response.numeroFinal1);
                            $('#tc10E').val(mensaje);
                            $('#tc10inicioE').val(response.numeroInicio1);
                            $('#tc10finE').val(response.numeroFinal1);
                            $('#tc10P').val(mensaje);
                            $('#tc10inicioP').val(response.numeroInicio1);
                            $('#tc10finP').val(response.numeroFinal1);
                        }
                        if (response.cantidadDatos == '2') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1 + ' y ' + inicio2 + ' al ' + fin2);
                            $('#tc10').val(mensaje);
                            $('#cantidadDatosTc10').val(response.cantidadDatos);
                            $('#tc10inicio').val(response.numeroInicio1);$('#tc10fin').val(response.numeroFinal1);
                            $('#tc10inicio2').val(response.numeroInicio2);$('#tc10fin2').val(response.numeroFinal2);
                            $('#tc10E').val(mensaje);
                            $('#tc10inicioE').val(response.numeroInicio1);$('#tc10finE').val(response.numeroFinal1);
                            $('#tc10inicioE2').val(response.numeroInicio2);$('#tc10finE2').val(response.numeroFinal2);
                            $('#tc10P').val(mensaje);
                            $('#tc10inicioP').val(response.numeroInicio1);$('#tc10finP').val(response.numeroFinal1);
                            $('#tc10inicioP2').val(response.numeroInicio2);$('#tc10finP2').val(response.numeroFinal2);
                        }
                        if (response.cantidadDatos == '3') {
                            var mensaje = ('Timbres de: ' + inicio1 + ' al ' + fin1 + ', ' + inicio2 + ' al ' + fin2 + ' y ' + inicio3 + ' al ' + fin3);
                            $('#tc10').val(mensaje);
                            $('#cantidadDatosTc10').val(response.cantidadDatos);
                            $('#tc10inicio').val(response.numeroInicio1);$('#tc10fin').val(response.numeroFinal1);
                            $('#tc10inicio2').val(response.numeroInicio2);$('#tc10fin2').val(response.numeroFinal2);
                            $('#tc10inicio3').val(response.numeroInicio3);$('#tc10fin3').val(response.numeroFinal3);
                            $('#tc10E').val(mensaje);
                            $('#tc10inicioE').val(response.numeroInicio1);$('#tc10finE').val(response.numeroFinal1);
                            $('#tc10inicioE2').val(response.numeroInicio2);$('#tc10finE2').val(response.numeroFinal2);
                            $('#tc10inicioE3').val(response.numeroInicio3);$('#tc10finE3').val(response.numeroFinal3);
                            $('#tc10P').val(mensaje);
                            $('#tc10inicioP').val(response.numeroInicio1);$('#tc10finP').val(response.numeroFinal1);
                            $('#tc10inicioP2').val(response.numeroInicio2);$('#tc10finP2').val(response.numeroFinal2);
                            $('#tc10inicioP3').val(response.numeroInicio3);$('#tc10finP3').val(response.numeroFinal3);
                        }
                    }
                },
                error: function(response){
                    var mensaje = response.responseJSON;
                    alertify.set('notifier','position', 'top-center');
                    alertify.warning(mensaje);

                    var filas = $("#tablaDetalle").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM10') || ($($(celdas[1])).text() == 'TC10') || ($($(celdas[1])).text() == 'TE10')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleE").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM10') || ($($(celdas[1])).text() == 'TC10') || ($($(celdas[1])).text() == 'TE10')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleP").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM10') || ($($(celdas[1])).text() == 'TC10') || ($($(celdas[1])).text() == 'TE10')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }

                    getTotal(); getTotalE(); getTotalP();
                    document.getElementById('datoTc10').style.display = "none";$("input[name='tc10']").val('');$('#tc10inicio').val('');$('#tc10fin').val('');$('#tc10inicio2').val('');$('#tc10fin2').val('');$('#tc10inicio3').val('');$('#tc10fin3').val('');
                    document.getElementById('datoTc10E').style.display = "none";$("input[name='tc10E']").val('');$('#tc10inicioE').val('');$('#tc10finE').val('');$('#tc10inicioE2').val('');$('#tc10finE2').val('');$('#tc10inicioE3').val('');$('#tc10finE3').val('');
                    document.getElementById('datoTc10P').style.display = "none";$("input[name='tc10P']").val('');$('#tc10inicioP').val('');$('#tc10finP').val('');$('#tc10inicioP2').val('');$('#tc10finP2').val('');$('#tc10inicioP3').val('');$('#tc10finP3').val('');
                }
            });
        }
    }
}

function getTc20(){
    if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
    if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
    if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}
    for(var i= 0; i < filas.length; i++){
        var celdas = $(filas[i]).find("td");
        if($($(celdas[1])).text() == "TC20" || $($(celdas[1])).text() == "TIM20" || $($(celdas[1])).text() == "TE20"){
            document.getElementById('datoTc20').style.display = "";
            document.getElementById('datoTc20E').style.display = "";
            document.getElementById('datoTc20P').style.display = "";
            var user = $('#rol_user').val();
            var codigo = $($(celdas[0])).text();
            var nombre = $($(celdas[1])).text();
            var cantidad = $($(celdas[2])).text();
            // if (codigo == 25 || codigo == 41){codigo = 34; nombre = 'TC20';}
            $.ajax({
                type: "POST",
                url: "/consultaTimbres",
                data: {user, codigo, nombre, cantidad},
                dataType: 'json',
                success: function(response){
                    if (Number(response.numeroInicio1) == Number(response.numeroFinal1)){
                        var mensaje = ('Timbre entregado: ' + response.numeroInicio1);
                        $('#tc20').val(mensaje);
                        $('#cantidadDatosTc20').val(response.cantidadDatos);
                        $('#tc20inicio').val(response.numeroInicio1);
                        $('#tc20fin').val(response.numeroFinal1);
                        $('#tc20E').val(mensaje);
                        $('#tc20inicioE').val(response.numeroInicio1);
                        $('#tc20finE').val(response.numeroFinal1);
                        $('#tc20P').val(mensaje);
                        $('#tc20inicioP').val(response.numeroInicio1);
                        $('#tc20finP').val(response.numeroFinal1);
                    } else {
                        var inicio1 = response.numeroInicio1;
                        var fin1 = response.numeroFinal1;
                        var inicio2 = response.numeroInicio2;
                        var fin2 = response.numeroFinal2;
                        var inicio3 = response.numeroInicio3;
                        var fin3 = response.numeroFinal3;
                        if (response.cantidadDatos == '1') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1);
                            $('#tc20').val(mensaje);
                            $('#cantidadDatosTc20').val(response.cantidadDatos);
                            $('#tc20inicio').val(response.numeroInicio1);$('#tc20fin').val(response.numeroFinal1);
                            $('#tc20E').val(mensaje);
                            $('#tc20inicioE').val(response.numeroInicio1);$('#tc20finE').val(response.numeroFinal1);
                            $('#tc20P').val(mensaje);
                            $('#tc20inicioP').val(response.numeroInicio1);$('#tc20finP').val(response.numeroFinal1);
                        }
                        if (response.cantidadDatos == '2') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1 + ' y ' + inicio2 + ' al ' + fin2);
                            $('#tc20').val(mensaje);
                            $('#cantidadDatosTc20').val(response.cantidadDatos);
                            $('#tc20inicio').val(response.numeroInicio1);$('#tc20fin').val(response.numeroFinal1);
                            $('#tc20inicio2').val(response.numeroInicio2);$('#tc20fin2').val(response.numeroFinal2);
                            $('#tc20E').val(mensaje);
                            $('#tc20inicioE').val(response.numeroInicio1);$('#tc20finE').val(response.numeroFinal1);
                            $('#tc20inicioE2').val(response.numeroInicio2);$('#tc20finE2').val(response.numeroFinal2);
                            $('#tc20P').val(mensaje);
                            $('#tc20inicioP').val(response.numeroInicio1);$('#tc20finP').val(response.numeroFinal1);
                            $('#tc20inicioP2').val(response.numeroInicio2);$('#tc20finP2').val(response.numeroFinal2);
                        }
                        if (response.cantidadDatos == '3') {
                            var mensaje = ('Timbres de: ' + inicio1 + ' al ' + fin1 + ', ' + inicio2 + ' al ' + fin2 + ' y ' + inicio3 + ' al ' + fin3);
                            $('#tc20').val(mensaje);
                            $('#cantidadDatosTc20').val(response.cantidadDatos);
                            $('#tc20inicio').val(response.numeroInicio1);$('#tc20fin').val(response.numeroFinal1);
                            $('#tc20inicio2').val(response.numeroInicio2);$('#tc20fin2').val(response.numeroFinal2);
                            $('#tc20inicio3').val(response.numeroInicio3);$('#tc20fin3').val(response.numeroFinal3);
                            $('#tc20E').val(mensaje);
                            $('#tc20inicioE').val(response.numeroInicio1);$('#tc20finE').val(response.numeroFinal1);
                            $('#tc20inicioE2').val(response.numeroInicio2);$('#tc20finE2').val(response.numeroFinal2);
                            $('#tc20inicioE3').val(response.numeroInicio3);$('#tc20finE3').val(response.numeroFinal3);
                            $('#tc20P').val(mensaje);
                            $('#tc20inicioP').val(response.numeroInicio1);$('#tc20finP').val(response.numeroFinal1);
                            $('#tc20inicioP2').val(response.numeroInicio2);$('#tc20finP2').val(response.numeroFinal2);
                            $('#tc20inicioP3').val(response.numeroInicio3);$('#tc20finP3').val(response.numeroFinal3);
                        }
                    }
                },
                error: function(response){
                    var mensaje = response.responseJSON;
                    alertify.set('notifier','position', 'top-center');
                    alertify.warning(mensaje);

                    var filas = $("#tablaDetalle").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM20') || ($($(celdas[1])).text() == 'TC20') || ($($(celdas[1])).text() == 'TE20')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleE").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM20') || ($($(celdas[1])).text() == 'TC20') || ($($(celdas[1])).text() == 'TE20')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleP").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM20') || ($($(celdas[1])).text() == 'TC20') || ($($(celdas[1])).text() == 'TE20')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }

                    getTotal(); getTotalE(); getTotalP();
                    document.getElementById('datoTc20').style.display = "none";$("input[name='tc20']").val('');$('#tc20inicio').val('');$('#tc20fin').val('');$('#tc20inicio2').val('');$('#tc20fin2').val('');$('#tc20inicio3').val('');$('#tc20fin3').val('');
                    document.getElementById('datoTc20E').style.display = "none";$("input[name='tc20E']").val('');$('#tc20inicioE').val('');$('#tc20finE').val('');$('#tc20inicioE2').val('');$('#tc20finE2').val('');$('#tc20inicioE3').val('');$('#tc20finE3').val('');
                    document.getElementById('datoTc20P').style.display = "none";$("input[name='tc20P']").val('');$('#tc20inicioP').val('');$('#tc20finP').val('');$('#tc20inicioP2').val('');$('#tc20finP2').val('');$('#tc20inicioP3').val('');$('#tc20finP3').val('');
                }
            });
        }
    }
}

function getTc50(){
    if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
    if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
    if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}
    for(var i= 0; i < filas.length; i++){
        var celdas = $(filas[i]).find("td");
        if($($(celdas[1])).text() == "TC50" || $($(celdas[1])).text() == "TIM50" || $($(celdas[1])).text() == "TE50"){
            document.getElementById('datoTc50').style.display = "";
            document.getElementById('datoTc50E').style.display = "";
            document.getElementById('datoTc50P').style.display = "";
            var user = $('#rol_user').val();
            var codigo = $($(celdas[0])).text();
            var nombre = $($(celdas[1])).text();
            var cantidad = $($(celdas[2])).text();
            // if (codigo == 28 || codigo == 42){codigo = 36; nombre = 'TC50';}
            $.ajax({
                type: "POST",
                url: "/consultaTimbres",
                data: {user, codigo, nombre, cantidad},
                dataType: 'json',
                success: function(response){
                    if (Number(response.numeroInicio1) == Number(response.numeroFinal1)){
                        var mensaje = ('Timbre entregado: ' + response.numeroInicio1);
                        $('#tc50').val(mensaje);
                        $('#cantidadDatosTc50').val(response.cantidadDatos);
                        $('#tc50inicio').val(response.numeroInicio1);
                        $('#tc50fin').val(response.numeroFinal1);
                        $('#tc50E').val(mensaje);
                        $('#tc50inicioE').val(response.numeroInicio1);
                        $('#tc50finE').val(response.numeroFinal1);
                        $('#tc50P').val(mensaje);
                        $('#tc50inicioP').val(response.numeroInicio1);
                        $('#tc50finP').val(response.numeroFinal1);
                    } else {
                        var inicio1 = response.numeroInicio1;
                        var fin1 = response.numeroFinal1;
                        var inicio2 = response.numeroInicio2;
                        var fin2 = response.numeroFinal2;
                        var inicio3 = response.numeroInicio3;
                        var fin3 = response.numeroFinal3;
                        if (response.cantidadDatos == '1') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1);
                            $('#tc50').val(mensaje);
                            $('#cantidadDatosTc50').val(response.cantidadDatos);
                            $('#tc50inicio').val(response.numeroInicio1);$('#tc50fin').val(response.numeroFinal1);
                            $('#tc50E').val(mensaje);
                            $('#tc50inicioE').val(response.numeroInicio1);$('#tc50finE').val(response.numeroFinal1);
                            $('#tc50P').val(mensaje);
                            $('#tc50inicioP').val(response.numeroInicio1);$('#tc50finP').val(response.numeroFinal1);
                        }
                        if (response.cantidadDatos == '2') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1 + ' y ' + inicio2 + ' al ' + fin2);
                            $('#tc50').val(mensaje);
                            $('#cantidadDatosTc50').val(response.cantidadDatos);
                            $('#tc50inicio').val(response.numeroInicio1);$('#tc50fin').val(response.numeroFinal1);
                            $('#tc50inicio2').val(response.numeroInicio2);$('#tc50fin2').val(response.numeroFinal2);
                            $('#tc50E').val(mensaje);
                            $('#tc50inicioE').val(response.numeroInicio1);$('#tc50finE').val(response.numeroFinal1);
                            $('#tc50inicioE2').val(response.numeroInicio2);$('#tc50finE2').val(response.numeroFinal2);
                            $('#tc50P').val(mensaje);
                            $('#tc50inicioP').val(response.numeroInicio1);$('#tc50finP').val(response.numeroFinal1);
                            $('#tc50inicioP2').val(response.numeroInicio2);$('#tc50finP2').val(response.numeroFinal2);
                        }
                        if (response.cantidadDatos == '3') {
                            var mensaje = ('Timbres de: ' + inicio1 + ' al ' + fin1 + ', ' + inicio2 + ' al ' + fin2 + ' y ' + inicio3 + ' al ' + fin3);
                            $('#tc50').val(mensaje);
                            $('#cantidadDatosTc50').val(response.cantidadDatos);
                            $('#tc50inicio').val(response.numeroInicio1);$('#tc50fin').val(response.numeroFinal1);
                            $('#tc50inicio2').val(response.numeroInicio2);$('#tc50fin2').val(response.numeroFinal2);
                            $('#tc50inicio3').val(response.numeroInicio3);$('#tc50fin3').val(response.numeroFinal3);
                            $('#tc50E').val(mensaje);
                            $('#tc50inicioE').val(response.numeroInicio1);$('#tc50finE').val(response.numeroFinal1);
                            $('#tc50inicioE2').val(response.numeroInicio2);$('#tc50finE2').val(response.numeroFinal2);
                            $('#tc50inicioE3').val(response.numeroInicio3);$('#tc50finE3').val(response.numeroFinal3);
                            $('#tc50P').val(mensaje);
                            $('#tc50inicioP').val(response.numeroInicio1);$('#tc50finP').val(response.numeroFinal1);
                            $('#tc50inicioP2').val(response.numeroInicio2);$('#tc50finP2').val(response.numeroFinal2);
                            $('#tc50inicioP3').val(response.numeroInicio3);$('#tc50finP3').val(response.numeroFinal3);
                        }
                    }
                },
                error: function(response){
                    var mensaje = response.responseJSON;
                    alertify.set('notifier','position', 'top-center');
                    alertify.warning(mensaje);

                    var filas = $("#tablaDetalle").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM50') || ($($(celdas[1])).text() == 'TC50') || ($($(celdas[1])).text() == 'TE50')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleE").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM50') || ($($(celdas[1])).text() == 'TC50') || ($($(celdas[1])).text() == 'TE50')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleP").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM50') || ($($(celdas[1])).text() == 'TC50') || ($($(celdas[1])).text() == 'TE50')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }

                    getTotal(); getTotalE(); getTotalP();
                    document.getElementById('datoTc50').style.display = "none";$("input[name='tc50']").val('');$('#tc50inicio').val('');$('#tc50fin').val('');$('#tc50inicio2').val('');$('#tc50fin2').val('');$('#tc50inicio3').val('');$('#tc50fin3').val('');
                    document.getElementById('datoTc50E').style.display = "none";$("input[name='tc50E']").val('');$('#tc50inicioE').val('');$('#tc50finE').val('');$('#tc50inicioE2').val('');$('#tc50finE2').val('');$('#tc50inicioE3').val('');$('#tc50finE3').val('');
                    document.getElementById('datoTc50P').style.display = "none";$("input[name='tc50P']").val('');$('#tc50inicioP').val('');$('#tc50finP').val('');$('#tc50inicioP2').val('');$('#tc50finP2').val('');$('#tc50inicioP3').val('');$('#tc50finP3').val('');
                }
            });
        }
    }
}

function getTc100(){
    if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
    if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
    if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}
    for(var i= 0; i < filas.length; i++){
        var celdas = $(filas[i]).find("td");
        if($($(celdas[1])).text() == "TC100" || $($(celdas[1])).text() == "TIM100" || $($(celdas[1])).text() == "TE100"){
            document.getElementById('datoTc100').style.display = "";
            document.getElementById('datoTc100E').style.display = "";
            document.getElementById('datoTc100P').style.display = "";
            var user = $('#rol_user').val();
            var codigo = $($(celdas[0])).text();
            var nombre = $($(celdas[1])).text();
            var cantidad = $($(celdas[2])).text();
            // if (codigo == 24 || codigo == 43){codigo = 33; nombre = 'TC100';}
            $.ajax({
                type: "POST",
                url: "/consultaTimbres",
                data: {user, codigo, nombre, cantidad},
                dataType: 'json',
                success: function(response){
                    if (Number(response.numeroInicio1) == Number(response.numeroFinal1)){
                        var mensaje = ('Timbre entregado: ' + response.numeroInicio1);
                        $('#tc100').val(mensaje);
                        $('#cantidadDatosTc100').val(response.cantidadDatos);
                        $('#tc100inicio').val(response.numeroInicio1);
                        $('#tc100fin').val(response.numeroFinal1);
                        $('#tc100E').val(mensaje);
                        $('#tc100inicioE').val(response.numeroInicio1);
                        $('#tc100finE').val(response.numeroFinal1);
                        $('#tc100P').val(mensaje);
                        $('#tc100inicioP').val(response.numeroInicio1);
                        $('#tc100finP').val(response.numeroFinal1);
                    } else {
                        var inicio1 = response.numeroInicio1;
                        var fin1 = response.numeroFinal1;
                        var inicio2 = response.numeroInicio2;
                        var fin2 = response.numeroFinal2;
                        var inicio3 = response.numeroInicio3;
                        var fin3 = response.numeroFinal3;
                        if (response.cantidadDatos == '1') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1);
                            $('#tc100').val(mensaje);
                            $('#cantidadDatosTc100').val(response.cantidadDatos);
                            $('#tc100inicio').val(response.numeroInicio1);$('#tc100fin').val(response.numeroFinal1);
                            $('#tc100E').val(mensaje);
                            $('#tc100inicioE').val(response.numeroInicio1);$('#tc100finE').val(response.numeroFinal1);
                            $('#tc100P').val(mensaje);
                            $('#tc100inicioP').val(response.numeroInicio1);$('#tc100finP').val(response.numeroFinal1);
                        }
                        if (response.cantidadDatos == '2') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1 + ' y ' + inicio2 + ' al ' + fin2);
                            $('#tc100').val(mensaje);
                            $('#cantidadDatosTc100').val(response.cantidadDatos);
                            $('#tc100inicio').val(response.numeroInicio1);$('#tc100fin').val(response.numeroFinal1);
                            $('#tc100inicio2').val(response.numeroInicio2);$('#tc100fin2').val(response.numeroFinal2);
                            $('#tc100E').val(mensaje);
                            $('#tc100inicioE').val(response.numeroInicio1);$('#tc100finE').val(response.numeroFinal1);
                            $('#tc100inicioE2').val(response.numeroInicio2);$('#tc100finE2').val(response.numeroFinal2);
                            $('#tc100P').val(mensaje);
                            $('#tc100inicioP').val(response.numeroInicio1);$('#tc100finP').val(response.numeroFinal1);
                            $('#tc100inicioP2').val(response.numeroInicio2);$('#tc100finP2').val(response.numeroFinal2);
                        }
                        if (response.cantidadDatos == '3') {
                            var mensaje = ('Timbres de: ' + inicio1 + ' al ' + fin1 + ', ' + inicio2 + ' al ' + fin2 + ' y ' + inicio3 + ' al ' + fin3);
                            $('#tc100').val(mensaje);
                            $('#cantidadDatosTc100').val(response.cantidadDatos);
                            $('#tc100inicio').val(response.numeroInicio1);$('#tc100fin').val(response.numeroFinal1);
                            $('#tc100inicio2').val(response.numeroInicio2);$('#tc100fin2').val(response.numeroFinal2);
                            $('#tc100inicio3').val(response.numeroInicio3);$('#tc100fin3').val(response.numeroFinal3);
                            $('#tc100E').val(mensaje);
                            $('#tc100inicioE').val(response.numeroInicio1);$('#tc100finE').val(response.numeroFinal1);
                            $('#tc100inicioE2').val(response.numeroInicio2);$('#tc100finE2').val(response.numeroFinal2);
                            $('#tc100inicioE3').val(response.numeroInicio3);$('#tc100finE3').val(response.numeroFinal3);
                            $('#tc100P').val(mensaje);
                            $('#tc100inicioP').val(response.numeroInicio1);$('#tc100finP').val(response.numeroFinal1);
                            $('#tc100inicioP2').val(response.numeroInicio2);$('#tc100finP2').val(response.numeroFinal2);
                            $('#tc100inicioP3').val(response.numeroInicio3);$('#tc100finP3').val(response.numeroFinal3);
                        }
                    }
                },
                error: function(response){
                    var mensaje = response.responseJSON;
                    alertify.set('notifier','position', 'top-center');
                    alertify.warning(mensaje);

                    var filas = $("#tablaDetalle").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM100') || ($($(celdas[1])).text() == 'TC100') || ($($(celdas[1])).text() == 'TE100')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleE").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM100') || ($($(celdas[1])).text() == 'TC100') || ($($(celdas[1])).text() == 'TE100')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleP").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM100') || ($($(celdas[1])).text() == 'TC100') || ($($(celdas[1])).text() == 'TE100')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }

                    getTotal(); getTotalE(); getTotalP();
                    document.getElementById('datoTc100').style.display = "none";$("input[name='tc100']").val('');$('#tc100inicio').val('');$('#tc100fin').val('');$('#tc100inicio2').val('');$('#tc100fin2').val('');$('#tc100inicio3').val('');$('#tc100fin3').val('');
                    document.getElementById('datoTc100E').style.display = "none";$("input[name='tc100E']").val('');$('#tc100inicioE').val('');$('#tc100finE').val('');$('#tc100inicioE2').val('');$('#tc100finE2').val('');$('#tc100inicioE3').val('');$('#tc100finE3').val('');
                    document.getElementById('datoTc100P').style.display = "none";$("input[name='tc100P']").val('');$('#tc100inicioP').val('');$('#tc100finP').val('');$('#tc100inicioP2').val('');$('#tc100finP2').val('');$('#tc100inicioP3').val('');$('#tc100finP3').val('');
                }
            });
        }
    }
}

function getTc200(){
    if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
    if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
    if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}
    for(var i= 0; i < filas.length; i++){
        var celdas = $(filas[i]).find("td");
        if($($(celdas[1])).text() == "TC200" || $($(celdas[1])).text() == "TIM200" || $($(celdas[1])).text() == "TE200"){
            document.getElementById('datoTc200').style.display = "";
            document.getElementById('datoTc200E').style.display = "";
            document.getElementById('datoTc200P').style.display = "";
            var user = $('#rol_user').val();
            var codigo = $($(celdas[0])).text();
            var nombre = $($(celdas[1])).text();
            var cantidad = $($(celdas[2])).text();
            // if (codigo == 26 || codigo == 44){codigo = 35; nombre = 'TC200';}
            $.ajax({
                type: "POST",
                url: "/consultaTimbres",
                data: {user, codigo, nombre, cantidad},
                dataType: 'json',
                success: function(response){
                    if (Number(response.numeroInicio1) == Number(response.numeroFinal1)){
                        var mensaje = ('Timbre entregado: ' + response.numeroInicio1);
                        $('#tc200').val(mensaje);
                        $('#cantidadDatosTc200').val(response.cantidadDatos);
                        $('#tc200inicio').val(response.numeroInicio1);
                        $('#tc200fin').val(response.numeroFinal1);
                        $('#tc200E').val(mensaje);
                        $('#tc200inicioE').val(response.numeroInicio1);
                        $('#tc200finE').val(response.numeroFinal1);
                        $('#tc200P').val(mensaje);
                        $('#tc200inicioP').val(response.numeroInicio1);
                        $('#tc200finP').val(response.numeroFinal1);
                    } else {
                        var inicio1 = response.numeroInicio1;
                        var fin1 = response.numeroFinal1;
                        var inicio2 = response.numeroInicio2;
                        var fin2 = response.numeroFinal2;
                        var inicio3 = response.numeroInicio3;
                        var fin3 = response.numeroFinal3;
                        if (response.cantidadDatos == '1') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1);
                            $('#tc200').val(mensaje);
                            $('#cantidadDatosTc200').val(response.cantidadDatos);
                            $('#tc200inicio').val(response.numeroInicio1);$('#tc200fin').val(response.numeroFinal1);
                            $('#tc200E').val(mensaje);
                            $('#tc200inicioE').val(response.numeroInicio1);$('#tc200finE').val(response.numeroFinal1);
                            $('#tc200P').val(mensaje);
                            $('#tc200inicioP').val(response.numeroInicio1);$('#tc200finP').val(response.numeroFinal1);
                        }
                        if (response.cantidadDatos == '2') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1 + ' y ' + inicio2 + ' al ' + fin2);
                            $('#tc200').val(mensaje);
                            $('#cantidadDatosTc200').val(response.cantidadDatos);
                            $('#tc200inicio').val(response.numeroInicio1);$('#tc200fin').val(response.numeroFinal1);
                            $('#tc200inici2').val(response.numeroInicio2);$('#tc200fin2').val(response.numeroFinal2);
                            $('#tc200E').val(mensaje);
                            $('#tc200inicioE').val(response.numeroInicio1);$('#tc200finE').val(response.numeroFinal1);
                            $('#tc200inicioE2').val(response.numeroInicio2);$('#tc200finE2').val(response.numeroFinal2);
                            $('#tc200P').val(mensaje);
                            $('#tc200inicioP').val(response.numeroInicio1);$('#tc200finP').val(response.numeroFinal1);
                            $('#tc200inicioP2').val(response.numeroInicio2);$('#tc200finP2').val(response.numeroFinal2);
                        }
                        if (response.cantidadDatos == '3') {
                            var mensaje = ('Timbres de: ' + inicio1 + ' al ' + fin1 + ', ' + inicio2 + ' al ' + fin2 + ' y ' + inicio3 + ' al ' + fin3);
                            $('#tc200').val(mensaje);
                            $('#cantidadDatosTc200').val(response.cantidadDatos);
                            $('#tc200inicio').val(response.numeroInicio1);$('#tc200fin').val(response.numeroFinal1);
                            $('#tc200inicio2').val(response.numeroInicio2);$('#tc200fin2').val(response.numeroFinal2);
                            $('#tc200inicio3').val(response.numeroInicio3);$('#tc200fin3').val(response.numeroFinal3);
                            $('#tc200E').val(mensaje);
                            $('#tc200inicioE').val(response.numeroInicio1);$('#tc200finE').val(response.numeroFinal1);
                            $('#tc200inicioE2').val(response.numeroInicio2);$('#tc200finE2').val(response.numeroFinal2);
                            $('#tc200inicioE3').val(response.numeroInicio3);$('#tc200finE3').val(response.numeroFinal3);
                            $('#tc200P').val(mensaje);
                            $('#tc200inicioP').val(response.numeroInicio1);$('#tc200finP').val(response.numeroFinal1);
                            $('#tc200inicioP2').val(response.numeroInicio2);$('#tc200finP2').val(response.numeroFinal2);
                            $('#tc200inicioP3').val(response.numeroInicio3);$('#tc200finP3').val(response.numeroFinal3);
                        }
                    }
                },
                error: function(response){
                    var mensaje = response.responseJSON;
                    alertify.set('notifier','position', 'top-center');
                    alertify.warning(mensaje);

                    var filas = $("#tablaDetalle").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM200') || ($($(celdas[1])).text() == 'TC200') || ($($(celdas[1])).text() == 'TE200')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleE").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM200') || ($($(celdas[1])).text() == 'TC200') || ($($(celdas[1])).text() == 'TE200')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleP").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM200') || ($($(celdas[1])).text() == 'TC200') || ($($(celdas[1])).text() == 'TE200')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }

                    getTotal(); getTotalE(); getTotalP();
                    document.getElementById('datoTc200').style.display = "none";$("input[name='tc200']").val('');$('#tc200inicio').val('');$('#tc200fin').val('');$('#tc200inicio2').val('');$('#tc200fin2').val('');$('#tc200inicio3').val('');$('#tc200fin3').val('');
                    document.getElementById('datoTc200E').style.display = "none";$("input[name='tc200E']").val('');$('#tc200inicioE').val('');$('#tc200finE').val('');$('#tc200inicioE2').val('');$('#tc200finE2').val('');$('#tc200inicioE3').val('');$('#tc200finE3').val('');
                    document.getElementById('datoTc200P').style.display = "none";$("input[name='tc200P']").val('');$('#tc200inicioP').val('');$('#tc200finP').val('');$('#tc200inicioP2').val('');$('#tc200finP2').val('');$('#tc200inicioP3').val('');$('#tc200finP3').val('');
                }
            });
        }
    }
}

function getTc500(){
    if ($("#tablaDetalle").find("tr").length > 1){var filas = $("#tablaDetalle").find("tr");}
    if ($("#tablaDetalleE").find("tr").length > 1){var filas = $("#tablaDetalleE").find("tr");}
    if ($("#tablaDetalleP").find("tr").length > 1){var filas = $("#tablaDetalleP").find("tr");}
    for(var i= 0; i < filas.length; i++){
        var celdas = $(filas[i]).find("td");
        if($($(celdas[1])).text() == "TC500" || $($(celdas[1])).text() == "TIM500" || $($(celdas[1])).text() == "TE500"){
            document.getElementById('datoTc500').style.display = "";
            document.getElementById('datoTc500E').style.display = "";
            document.getElementById('datoTc500P').style.display = "";
            var user = $('#rol_user').val();
            var codigo = $($(celdas[0])).text();
            var nombre = $($(celdas[1])).text();
            var cantidad = $($(celdas[2])).text();
            // if (codigo == 29 || codigo == 45){codigo = 37; nombre = 'TC500';}
            $.ajax({
                type: "POST",
                url: "/consultaTimbres",
                data: {user, codigo, nombre, cantidad},
                dataType: 'json',
                success: function(response){
                    if (Number(response.numeroInicio1) == Number(response.numeroFinal1)){
                        var mensaje = ('Timbre entregado: ' + response.numeroInicio1);
                        $('#tc500').val(mensaje);
                        $('#cantidadDatosTc500').val(response.cantidadDatos);
                        $('#tc500inicio').val(response.numeroInicio1);
                        $('#tc500fin').val(response.numeroFinal1);
                        $('#tc500E').val(mensaje);
                        $('#tc500inicioE').val(response.numeroInicio1);
                        $('#tc500finE').val(response.numeroFinal1);
                        $('#tc500P').val(mensaje);
                        $('#tc500inicioP').val(response.numeroInicio1);
                        $('#tc500finP').val(response.numeroFinal1);
                    } else {
                        var inicio1 = response.numeroInicio1;
                        var fin1 = response.numeroFinal1;
                        var inicio2 = response.numeroInicio2;
                        var fin2 = response.numeroFinal2;
                        var inicio3 = response.numeroInicio3;
                        var fin3 = response.numeroFinal3;
                        if (response.cantidadDatos == '1') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1);
                            $('#tc500').val(mensaje);
                            $('#cantidadDatosTc500').val(response.cantidadDatos);
                            $('#tc500inicio').val(response.numeroInicio1);$('#tc500fin').val(response.numeroFinal1);
                            $('#tc500E').val(mensaje);
                            $('#tc500inicioE').val(response.numeroInicio1);$('#tc500finE').val(response.numeroFinal1);
                            $('#tc500P').val(mensaje);
                            $('#tc500inicioP').val(response.numeroInicio1);$('#tc500finP').val(response.numeroFinal1);
                        }
                        if (response.cantidadDatos == '2') {
                            var mensaje = ('Timbres entregados: ' + inicio1 + ' al ' + fin1 + ' y ' + inicio2 + ' al ' + fin2);
                            $('#tc500').val(mensaje);
                            $('#cantidadDatosTc500').val(response.cantidadDatos);
                            $('#tc500inicio').val(response.numeroInicio1);$('#tc500fin').val(response.numeroFinal1);
                            $('#tc500inicio2').val(response.numeroInicio2);$('#tc500fin2').val(response.numeroFinal2);
                            $('#tc500E').val(mensaje);
                            $('#tc500inicioE').val(response.numeroInicio1);$('#tc500finE').val(response.numeroFinal1);
                            $('#tc500inicioE2').val(response.numeroInicio2);$('#tc500finE2').val(response.numeroFinal2);
                            $('#tc500P').val(mensaje);
                            $('#tc500inicioP').val(response.numeroInicio1);$('#tc500finP').val(response.numeroFinal1);
                            $('#tc500inicioP2').val(response.numeroInicio2);$('#tc500finP2').val(response.numeroFinal2);
                        }
                        if (response.cantidadDatos == '3') {
                            var mensaje = ('Timbres de: ' + inicio1 + ' al ' + fin1 + ', ' + inicio2 + ' al ' + fin2 + ' y ' + inicio3 + ' al ' + fin3);
                            $('#tc500').val(mensaje);
                            $('#cantidadDatosTc500').val(response.cantidadDatos);
                            $('#tc500inicio').val(response.numeroInicio1);$('#tc500fin').val(response.numeroFinal1);
                            $('#tc500inicio2').val(response.numeroInicio2);$('#tc500fin2').val(response.numeroFinal2);
                            $('#tc500inicio3').val(response.numeroInicio3);$('#tc500fin3').val(response.numeroFinal3);
                            $('#tc500E').val(mensaje);
                            $('#tc500inicioE').val(response.numeroInicio1);$('#tc500finE').val(response.numeroFinal1);
                            $('#tc500inicioE2').val(response.numeroInicio2);$('#tc500finE2').val(response.numeroFinal2);
                            $('#tc500inicioE3').val(response.numeroInicio3);$('#tc500finE3').val(response.numeroFinal3);
                            $('#tc500P').val(mensaje);
                            $('#tc500inicioP').val(response.numeroInicio1);$('#tc500finP').val(response.numeroFinal1);
                            $('#tc500inicioP2').val(response.numeroInicio2);$('#tc500finP2').val(response.numeroFinal2);
                            $('#tc500inicioP3').val(response.numeroInicio3);$('#tc500finP3').val(response.numeroFinal3);
                        }
                    }
                },
                error: function(response){
                    var mensaje = response.responseJSON;
                    alertify.set('notifier','position', 'top-center');
                    alertify.warning(mensaje);

                    var filas = $("#tablaDetalle").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM500') || ($($(celdas[1])).text() == 'TC500') || ($($(celdas[1])).text() == 'TE500')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleE").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM500') || ($($(celdas[1])).text() == 'TC500') || ($($(celdas[1])).text() == 'TE500')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }
                    var filas = $("#tablaDetalleP").find("tr");
                    if (filas.length > 1){
                        for(var i= 0; i < filas.length; i++){
                            var celdas = $(filas[i]).find("td");
                            if(($($(celdas[1])).text() == 'TIM500') || ($($(celdas[1])).text() == 'TC500') || ($($(celdas[1])).text() == 'TE500')){
                                $(celdas).closest('tr').remove();
                            }
                        }
                    }

                    getTotal(); getTotalE(); getTotalP();
                    document.getElementById('datoTc500').style.display = "none";$("input[name='tc500']").val('');$('#tc500inicio').val('');$('#tc500fin').val('');$('#tc500inicio2').val('');$('#tc500fin2').val('');$('#tc500inicio3').val('');$('#tc500fin3').val('');
                    document.getElementById('datoTc500E').style.display = "none";$("input[name='tc500E']").val('');$('#tc500inicioE').val('');$('#tc500finE').val('');$('#tc500inicioE2').val('');$('#tc500finE2').val('');$('#tc500inicioE3').val('');$('#tc500finE3').val('');
                    document.getElementById('datoTc500P').style.display = "none";$("input[name='tc500P']").val('');$('#tc500inicioP').val('');$('#tc500finP').val('');$('#tc500inicioP2').val('');$('#tc500finP2').val('');$('#tc500inicioP3').val('');$('#tc500finP3').val('');
                }
            });
        }
    }
}


function getTimbres(selected){
    if(selected == "TC01" || selected == "TIM1" || selected == "TE01"){
        getTc01();
    }else if(selected == "TC05" || selected == "TIM5" || selected == "TE05"){
        getTc05();
    }else if(selected == "TC10" || selected == "TIM10" || selected == "TE10"){
        getTc10();
    }else if(selected == "TC20" || selected == "TIM20" || selected == "TE20"){
        getTc20();
    }else if(selected == "TC50" || selected == "TIM50" || selected == "TE50"){
        getTc50();
    }else if(selected == "TC100" || selected == "TIM100" || selected == "TE100"){
        getTc100();
    }else if(selected == "TC200" || selected == "TIM200" || selected == "TE200"){
        getTc200();
    }else if(selected == "TC500" || selected == "TIM500" || selected == "TE500"){
        getTc500();
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
                        for (i = 0; i < data.length; i++)
                        {
                            $('#codigo').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+'</option>' );
                        }
                    }else if ($('input[name=tipoCliente]:checked').val() == 'e') {
                        $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                        $('#codigoE').append( '<option value="">-- Escoja --</option>' );
                        for (i = 0; i < data.length; i++)
                        {
                            $('#codigoE').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+'</option>' );
                        }
                    }else if ($('input[name=tipoCliente]:checked').val() == 'e') {
                        $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                        $('#codigoP').append( '<option value="">-- Escoja --</option>' );
                        for (i = 0; i < data.length; i++)
                        {
                            $('#codigoP').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+'</option>' );
                        }
                    }
                }
            });
        }else if(document.getElementById("serieReciboB").checked) {
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
                        for (i = 0; i < data.length; i++)
                        {
                            $('#codigo').append($('<option>', {
                                value: data[i]["id"],
                                text: data[i]["codigo"]
                            }));
                        }
                    }else if ($('input[name=tipoCliente]:checked').val() == 'e') {
                        $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                        $('#codigoE').append( '<option value="">-- Escoja --</option>' );
                        for (i = 0; i < data.length; i++)
                        {
                            $('#codigoE').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+'</option>' );
                        }
                    }else if ($('input[name=tipoCliente]:checked').val() == 'p') {
                        $("select[name='codigo']").empty();$("select[name='codigoE']").empty();$("select[name='codigoP']").empty();
                        $('#codigoP').append( '<option value="">-- Escoja --</option>' );
                        for (i = 0; i < data.length; i++)
                        {
                            $('#codigoP').append( '<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+'</option>' );
                        }
                    }
                }
            });
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
                                    'colegiado': $("#c_cliente").val(),
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
                                    'colegiado': $("#c_cliente").val(),
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
    var combo = document.getElementById("codigo");
    var selected = combo.options[combo.selectedIndex].text;
    if (selected == '-- Escoja --'){var combo = document.getElementById("codigoE");var selected = combo.options[combo.selectedIndex].text;}
    if (selected == '-- Escoja --'){var combo = document.getElementById("codigoP");var selected = combo.options[combo.selectedIndex].text;}
    if (selected.substring(0,2) == 'TC' || selected.substring(0,2) == 'TE' || selected.substring(0,3) == 'TIM'){
        var user = $('#rol_user').val();
        var codigo = $('#codigo').val();
        if (codigo == ''){codigo = $('#codigoE').val();}
        if (codigo == ''){codigo = $('#codigoP').val();}
        var nombre = selected;
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
    $('#tc01').val('');$('#tc05').val('');$('#tc10').val('');$('#tc20').val('');$('#tc50').val('');$('#tc100').val('');$('#tc200').val('');$('#tc500').val('');
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
            for(var i=0; i < data.length; i++){
                if (data[i]["codigo"] == "TC01"){
                            if ($('#cantidadDatosTc01').val() == ''){
                                var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                    document.getElementById('datoTc01').style.display = "";$('#tmCantTc01').val(data[i]["cantidad"]);
                                    $('#tc01').val(mensaje);$('#cantidadDatosTc01').val('1');$('#tc01inicio').val(data[i]["numeracion_inicial"]);$('#tc01fin').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                    document.getElementById('datoTc01').style.display = "";$('#tmCantTc01').val(data[i]["cantidad"]);
                                    $('#tc01').val(mensaje);$('#cantidadDatosTc01').val('1');$('#tc01inicio').val(data[i]["numeracion_inicial"]);$('#tc01fin').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc01').val() == '1'){
                                var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                    document.getElementById('datoTc01').style.display = "";$('#tmCantTc01_2').val(data[i]["cantidad"]);
                                    $('#tc01').val(mensaje);$('#cantidadDatosTc01').val('2');$('#tc01inicio2').val(data[i]["numeracion_inicial"]);$('#tc01fin2').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                    document.getElementById('datoTc01').style.display = "";$('#tmCantTc01_2').val(data[i]["cantidad"]);
                                    $('#tc01').val(mensaje);$('#cantidadDatosTc01').val('2');$('#tc01inicio2').val(data[i]["numeracion_inicial"]);$('#tc01fin2').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc01').val() == '2'){
                                var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                    document.getElementById('datoTc01').style.display = "";$('#tmCantTc01_3').val(data[i]["cantidad"]);
                                    $('#tc01').val(mensaje);$('#cantidadDatosTc01').val('3');$('#tc01inicio3').val(data[i]["numeracion_inicial"]);$('#tc01fin3').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                    document.getElementById('datoTc01').style.display = "";$('#tmCantTc01_3').val(data[i]["cantidad"]);
                                    $('#tc01').val(mensaje);$('#cantidadDatosTc01').val('3');$('#tc01inicio3').val(data[i]["numeracion_inicial"]);$('#tc01fin3').val(data[i]["numeracion_final"]);
                                }
                            }
                }
                if (data[i]["codigo"] == "TC05"){
                            if ($('#cantidadDatosTc05').val() == ''){
                                var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                    document.getElementById('datoTc05').style.display = "";$('#tmCantTc05').val(data[i]["cantidad"]);
                                    $('#tc05').val(mensaje);$('#cantidadDatosTc05').val('1');$('#tc05inicio').val(data[i]["numeracion_inicial"]);$('#tc05fin').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                    document.getElementById('datoTc05').style.display = "";$('#tmCantTc05').val(data[i]["cantidad"]);
                                    $('#tc05').val(mensaje);$('#cantidadDatosTc05').val('1');$('#tc05inicio').val(data[i]["numeracion_inicial"]);$('#tc05fin').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc05').val() == '1'){
                                var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                    document.getElementById('datoTc05').style.display = "";$('#tmCantTc05_2').val(data[i]["cantidad"]);
                                    $('#tc05').val(mensaje);$('#cantidadDatosTc05').val('2');$('#tc05inicio2').val(data[i]["numeracion_inicial"]);$('#tc05fin2').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                    document.getElementById('datoTc05').style.display = "";$('#tmCantTc05_2').val(data[i]["cantidad"]);
                                    $('#tc05').val(mensaje);$('#cantidadDatosTc05').val('2');$('#tc05inicio2').val(data[i]["numeracion_inicial"]);$('#tc05fin2').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc05').val() == '2'){
                                var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                    document.getElementById('datoTc05').style.display = "";$('#tmCantTc05_3').val(data[i]["cantidad"]);
                                    $('#tc05').val(mensaje);$('#cantidadDatosTc05').val('3');$('#tc05inicio3').val(data[i]["numeracion_inicial"]);$('#tc05fin3').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                    document.getElementById('datoTc05').style.display = "";$('#tmCantTc05_3').val(data[i]["cantidad"]);
                                    $('#tc05').val(mensaje);$('#cantidadDatosTc05').val('3');$('#tc05inicio3').val(data[i]["numeracion_inicial"]);$('#tc05fin3').val(data[i]["numeracion_final"]);
                                }
                            }
                }
                if (data[i]["codigo"] == "TC10"){
                            if ($('#cantidadDatosTc10').val() == ''){
                                var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                    document.getElementById('datoTc10').style.display = "";$('#tmCantTc10').val(data[i]["cantidad"]);
                                    $('#tc10').val(mensaje);$('#cantidadDatosTc10').val('1');$('#tc10inicio').val(data[i]["numeracion_inicial"]);$('#tc10fin').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                    document.getElementById('datoTc10').style.display = "";$('#tmCantTc10').val(data[i]["cantidad"]);
                                    $('#tc10').val(mensaje);$('#cantidadDatosTc10').val('1');$('#tc10inicio').val(data[i]["numeracion_inicial"]);$('#tc10fin').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc10').val() == '1'){
                                var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                    document.getElementById('datoTc10').style.display = "";$('#tmCantTc10_2').val(data[i]["cantidad"]);
                                    $('#tc10').val(mensaje);$('#cantidadDatosTc10').val('2');$('#tc10inicio2').val(data[i]["numeracion_inicial"]);$('#tc10fin2').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                    document.getElementById('datoTc10').style.display = "";$('#tmCantTc10_2').val(data[i]["cantidad"]);
                                    $('#tc10').val(mensaje);$('#cantidadDatosTc10').val('2');$('#tc10inicio2').val(data[i]["numeracion_inicial"]);$('#tc10fin2').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc10').val() == '2'){
                                var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                    document.getElementById('datoTc10').style.display = "";$('#tmCantTc10_3').val(data[i]["cantidad"]);
                                    $('#tc10').val(mensaje);$('#cantidadDatosTc10').val('3');$('#tc10inicio3').val(data[i]["numeracion_inicial"]);$('#tc10fin3').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                    document.getElementById('datoTc10').style.display = "";$('#tmCantTc10_3').val(data[i]["cantidad"]);
                                    $('#tc10').val(mensaje);$('#cantidadDatosTc10').val('3');$('#tc10inicio3').val(data[i]["numeracion_inicial"]);$('#tc10fin3').val(data[i]["numeracion_final"]);
                                }
                            }
                }
                if (data[i]["codigo"] == "TC20"){
                            if ($('#cantidadDatosTc20').val() == ''){
                                var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                    document.getElementById('datoTc20').style.display = "";$('#tmCantTc20').val(data[i]["cantidad"]);
                                    $('#tc20').val(mensaje);$('#cantidadDatosTc20').val('1');$('#tc20inicio').val(data[i]["numeracion_inicial"]);$('#tc20fin').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                    document.getElementById('datoTc20').style.display = "";$('#tmCantTc20').val(data[i]["cantidad"]);
                                    $('#tc20').val(mensaje);$('#cantidadDatosTc20').val('1');$('#tc20inicio').val(data[i]["numeracion_inicial"]);$('#tc20fin').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc20').val() == '1'){
                                var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                    document.getElementById('datoTc20').style.display = "";$('#tmCantTc20_2').val(data[i]["cantidad"]);
                                    $('#tc20').val(mensaje);$('#cantidadDatosTc20').val('2');$('#tc20inicio2').val(data[i]["numeracion_inicial"]);$('#tc20fin2').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                    document.getElementById('datoTc20').style.display = "";$('#tmCantTc20_2').val(data[i]["cantidad"]);
                                    $('#tc20').val(mensaje);$('#cantidadDatosTc20').val('2');$('#tc20inicio2').val(data[i]["numeracion_inicial"]);$('#tc20fin2').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc20').val() == '2'){
                                var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                    document.getElementById('datoTc20').style.display = "";$('#tmCantTc20_3').val(data[i]["cantidad"]);
                                    $('#tc20').val(mensaje);$('#cantidadDatosTc20').val('3');$('#tc20inicio3').val(data[i]["numeracion_inicial"]);$('#tc20fin3').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                    document.getElementById('datoTc20').style.display = "";$('#tmCantTc20_3').val(data[i]["cantidad"]);
                                    $('#tc20').val(mensaje);$('#cantidadDatosTc20').val('3');$('#tc20inicio3').val(data[i]["numeracion_inicial"]);$('#tc20fin3').val(data[i]["numeracion_final"]);
                                }
                            }
                }
                if (data[i]["codigo"] == "TC50"){
                            if ($('#cantidadDatosTc50').val() == ''){
                                var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                    document.getElementById('datoTc50').style.display = "";$('#tmCantTc50').val(data[i]["cantidad"]);
                                    $('#tc50').val(mensaje);$('#cantidadDatosTc50').val('1');$('#tc50inicio').val(data[i]["numeracion_inicial"]);$('#tc50fin').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                    document.getElementById('datoTc50').style.display = "";$('#tmCantTc50').val(data[i]["cantidad"]);
                                    $('#tc50').val(mensaje);$('#cantidadDatosTc50').val('1');$('#tc50inicio').val(data[i]["numeracion_inicial"]);$('#tc50fin').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc50').val() == '1'){
                                var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                    document.getElementById('datoTc50').style.display = "";$('#tmCantTc50_2').val(data[i]["cantidad"]);
                                    $('#tc50').val(mensaje);$('#cantidadDatosTc50').val('2');$('#tc50inicio2').val(data[i]["numeracion_inicial"]);$('#tc50fin2').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                    document.getElementById('datoTc50').style.display = "";$('#tmCantTc50_2').val(data[i]["cantidad"]);
                                    $('#tc50').val(mensaje);$('#cantidadDatosTc50').val('2');$('#tc50inicio2').val(data[i]["numeracion_inicial"]);$('#tc50fin2').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc50').val() == '2'){
                                var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                    document.getElementById('datoTc50').style.display = "";$('#tmCantTc50_3').val(data[i]["cantidad"]);
                                    $('#tc50').val(mensaje);$('#cantidadDatosTc50').val('3');$('#tc50inicio3').val(data[i]["numeracion_inicial"]);$('#tc50fin3').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                    document.getElementById('datoTc50').style.display = "";$('#tmCantTc50_3').val(data[i]["cantidad"]);
                                    $('#tc50').val(mensaje);$('#cantidadDatosTc50').val('3');$('#tc50inicio3').val(data[i]["numeracion_inicial"]);$('#tc50fin3').val(data[i]["numeracion_final"]);
                                }
                            }
                }
                if (data[i]["codigo"] == "TC100"){
                            if ($('#cantidadDatosTc100').val() == ''){
                                var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                    document.getElementById('datoTc100').style.display = "";$('#tmCantTc100').val(data[i]["cantidad"]);
                                    $('#tc100').val(mensaje);$('#cantidadDatosTc100').val('1');$('#tc100inicio').val(data[i]["numeracion_inicial"]);$('#tc100fin').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                    document.getElementById('datoTc100').style.display = "";$('#tmCantTc100').val(data[i]["cantidad"]);
                                    $('#tc100').val(mensaje);$('#cantidadDatosTc100').val('1');$('#tc100inicio').val(data[i]["numeracion_inicial"]);$('#tc100fin').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc100').val() == '1'){
                                var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                    document.getElementById('datoTc100').style.display = "";$('#tmCantTc100_2').val(data[i]["cantidad"]);
                                    $('#tc100').val(mensaje);$('#cantidadDatosTc100').val('2');$('#tc100inicio2').val(data[i]["numeracion_inicial"]);$('#tc100fin2').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                    document.getElementById('datoTc100').style.display = "";$('#tmCantTc100_2').val(data[i]["cantidad"]);
                                    $('#tc100').val(mensaje);$('#cantidadDatosTc100').val('2');$('#tc100inicio2').val(data[i]["numeracion_inicial"]);$('#tc100fin2').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc100').val() == '2'){
                                var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                    document.getElementById('datoTc100').style.display = "";$('#tmCantTc100_3').val(data[i]["cantidad"]);
                                    $('#tc100').val(mensaje);$('#cantidadDatosTc100').val('3');$('#tc100inicio3').val(data[i]["numeracion_inicial"]);$('#tc100fin3').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                    document.getElementById('datoTc100').style.display = "";$('#tmCantTc100_3').val(data[i]["cantidad"]);
                                    $('#tc100').val(mensaje);$('#cantidadDatosTc100').val('3');$('#tc100inicio3').val(data[i]["numeracion_inicial"]);$('#tc100fin3').val(data[i]["numeracion_final"]);
                                }
                            }
                }
                if (data[i]["codigo"] == "TC200"){
                            if ($('#cantidadDatosTc200').val() == ''){
                                var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                    document.getElementById('datoTc200').style.display = "";$('#tmCantTc200').val(data[i]["cantidad"]);
                                    $('#tc200').val(mensaje);$('#cantidadDatosTc200').val('1');$('#tc200inicio').val(data[i]["numeracion_inicial"]);$('#tc200fin').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                    document.getElementById('datoTc200').style.display = "";$('#tmCantTc200').val(data[i]["cantidad"]);
                                    $('#tc200').val(mensaje);$('#cantidadDatosTc200').val('1');$('#tc200inicio').val(data[i]["numeracion_inicial"]);$('#tc200fin').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc200').val() == '1'){
                                var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                    document.getElementById('datoTc200').style.display = "";$('#tmCantTc200_2').val(data[i]["cantidad"]);
                                    $('#tc200').val(mensaje);$('#cantidadDatosTc200').val('2');$('#tc200inicio2').val(data[i]["numeracion_inicial"]);$('#tc200fin2').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                    document.getElementById('datoTc200').style.display = "";$('#tmCantTc200_2').val(data[i]["cantidad"]);
                                    $('#tc200').val(mensaje);$('#cantidadDatosTc200').val('2');$('#tc200inicio2').val(data[i]["numeracion_inicial"]);$('#tc200fin2').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc200').val() == '2'){
                                var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                    document.getElementById('datoTc200').style.display = "";$('#tmCantTc200_3').val(data[i]["cantidad"]);
                                    $('#tc200').val(mensaje);$('#cantidadDatosTc200').val('3');$('#tc200inicio3').val(data[i]["numeracion_inicial"]);$('#tc200fin3').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                    document.getElementById('datoTc200').style.display = "";$('#tmCantTc200_3').val(data[i]["cantidad"]);
                                    $('#tc200').val(mensaje);$('#cantidadDatosTc200').val('3');$('#tc200inicio3').val(data[i]["numeracion_inicial"]);$('#tc200fin3').val(data[i]["numeracion_final"]);
                                }
                            }
                }
                if (data[i]["codigo"] == "TC500"){
                            if ($('#cantidadDatosTc500').val() == ''){
                                var i1 = data[i]["numeracion_inicial"];var f1 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbre entregado: ' + data[i]["numeracion_inicial"]);
                                    document.getElementById('datoTc500').style.display = "";$('#tmCantTc500').val(data[i]["cantidad"]);
                                    $('#tc500').val(mensaje);$('#cantidadDatosTc500').val('1');$('#tc500inicio').val(data[i]["numeracion_inicial"]);$('#tc500fin').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + data[i]["numeracion_inicial"] + ' al ' + data[i]["numeracion_final"]);
                                    document.getElementById('datoTc500').style.display = "";$('#tmCantTc500').val(data[i]["cantidad"]);
                                    $('#tc500').val(mensaje);$('#cantidadDatosTc500').val('1');$('#tc500inicio').val(data[i]["numeracion_inicial"]);$('#tc500fin').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc500').val() == '1'){
                                var i2 = data[i]["numeracion_inicial"];var f2 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2);
                                    document.getElementById('datoTc500').style.display = "";$('#tmCantTc500_2').val(data[i]["cantidad"]);
                                    $('#tc500').val(mensaje);$('#cantidadDatosTc500').val('2');$('#tc500inicio2').val(data[i]["numeracion_inicial"]);$('#tc500fin2').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2);
                                    document.getElementById('datoTc500').style.display = "";$('#tmCantTc500_2').val(data[i]["cantidad"]);
                                    $('#tc500').val(mensaje);$('#cantidadDatosTc500').val('2');$('#tc500inicio2').val(data[i]["numeracion_inicial"]);$('#tc500fin2').val(data[i]["numeracion_final"]);
                                }
                            }
                            else if ($('#cantidadDatosTc500').val() == '2'){
                                var i3 = data[i]["numeracion_inicial"];var f3 = data[i]["numeracion_final"];
                                if (Number(data[i]["numeracion_inicial"]) == Number(data[i]["numeracion_final"])){
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3);
                                    document.getElementById('datoTc500').style.display = "";$('#tmCantTc500_3').val(data[i]["cantidad"]);
                                    $('#tc500').val(mensaje);$('#cantidadDatosTc500').val('3');$('#tc500inicio3').val(data[i]["numeracion_inicial"]);$('#tc500fin3').val(data[i]["numeracion_final"]);
                                } else {
                                    var mensaje = ('Timbres entregados: ' + i1 + ' - ' + f1 + ', ' + i2 + ' - ' + f2 + ', ' + i3 + ' - ' + f3);
                                    document.getElementById('datoTc500').style.display = "";$('#tmCantTc500_3').val(data[i]["cantidad"]);
                                    $('#tc500').val(mensaje);$('#cantidadDatosTc500').val('3');$('#tc500inicio3').val(data[i]["numeracion_inicial"]);$('#tc500fin3').val(data[i]["numeracion_final"]);
                                }
                            }
                }
            }
            getTotal();
        }
    });
}

function agregarproductof() {
    $("#codigo").change();

    $("#cantidad").change();
    if($.isNumeric($("#cantidad").val()) && $("#subtotal").val().substring(2) != 0) {

        validateRow();
      limpiarFilaDetalle();
    }
  }

function validateRow(){
    $('#tablaDetalle').each(function(index, tr) {
        var combo = document.getElementById("codigo");
        var selected = combo.options[combo.selectedIndex].text;
        var nFilas = $("#tablaDetalle tr").length;
        if((nFilas == 1) && ($('#codigo').val() != "") && ($('#precioU').val().substring(2) != "")){
            if ($('#codigo').val() == 62){
                var indicador = $('#subtotal').val().substring(2);
                mensualidadTimbre(indicador);
                addnewrow();
            }else {
                addnewrow();
                getTimbres(selected);
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

                        if(codigoAnt == $('#codigo').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = 'Q.'+nuevoSubTotal.toFixed(2);

                            if (codigoAnt == 62) {

                                var indicador = nuevoSubTotal;
                                mensualidadTimbre(indicador);

                            }

                                getTotal();
                                getTimbres(selected);
                                limpiarFilaDetalle();
                                document.getElementById('existencia').style.display = "none";$('#existencia').val('');
                                document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
                                document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
                                finish();


                        }
                    }
                addnewrow();
                getTimbres(selected);
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
                        }else if(($('#codigo').val() != "") && ($('#precioU').val().substring(2) != "")){
                            addnewrow();
                            getTimbres(selected);
                            limpiarFilaDetalle();
                            finish();
                        }
                }
            }
        }
    });
}

  function addnewrow() {

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
	resultado += $('#codigo option:selected').text();
	resultado += '</td>';

	resultado += '<td class="cantidad" id="cantidad">';
	resultado += $("#cantidad").val();
	resultado += '</td>';

	resultado += '<td class="precioU" id="precioU">';
	resultado += $("#precioU").val();
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
    $("select[name='codigo']").val('');
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
        var valor = $("#codigoE").val();
        if(document.getElementById("serieReciboA").checked == true){
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoA/' + valor,
                success: function(response){
                    if($("#codigoE").val() != ""){
                        $("input[name='precioUE']").val('Q.'+response.precio_particular.toFixed(2));
                        $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                        $("input[name='subtotalE']").val('Q.'+response.precio_particular.toFixed(2));
                        $("input[name='categoria_idE']").val(response.categoria_id);

                        $("#cantidadE").val(1);
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
                        $("input[name='precioUE']").val('Q.'+response.precio_particular.toFixed(2));
                        $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                        $("input[name='subtotalE']").val('Q.'+response.precio_particular.toFixed(2));
                        $("input[name='categoria_idE']").val(response.categoria_id);
                        consultaTimbre();

                        $("#cantidadE").val(1);
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

        var subTotalE = 0;

        var precioUE = $("#precioUE").val().substring(2); // Convertir el valor a un entero (número).
        var cantidadE = $("#cantidadE").val();

            subTotalE = cantidadE * precioUE;

            $("#subtotalE").val('Q.'+subTotalE);
    });
});

  function agregarproductofE() {
    $("#codigoE").change();

    $("#cantidadE").change();
    if($.isNumeric($("#cantidadE").val()) && $("#subtotalE").val().substring(2) != 0) {

        validateRowE();
      limpiarFilaDetalleE();
    }
  }

  function validateRowE(){
    $('#tablaDetalleE').each(function(index, tr) {
        var combo = document.getElementById("codigoE");
        var selected = combo.options[combo.selectedIndex].text;
        var nFilas = $("#tablaDetalleE tr").length;
        if((nFilas == 1) && ($('#codigoE').val() != "") && ($('#precioUE').val().substring(2) != "")){
            addnewrowE();
            getTimbres(selected);
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

                        if(codigoAnt == $('#codigoE').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = 'Q.'+nuevoSubTotal.toFixed(2);

                            getTotalE();
                            getTimbres(selected);
                            limpiarFilaDetalleE();
                            document.getElementById('existencia').style.display = "none";$('#existencia').val('');
                            document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
                            document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
                            finish();
                        }
                    }
                addnewrowE();
                getTimbres(selected);
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
                        }else if(($('#codigoE').val() != "") && ($('#precioUE').val().substring(2) != "")){
                            addnewrowE();
                            getTimbres(selected);
                            limpiarFilaDetalleE();
                            finish();
                        }
                }
            }
        }
    });
}

  function addnewrowE() {

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
	resultado += $('#codigoE option:selected').text();
	resultado += '</td>';

	resultado += '<td class="cantidadE" id="cantidadE">';
	resultado += $("#cantidadE").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += $("#precioUE").val();
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
    $("select[name='codigoE']").val('');
    $("input[name='cantidadE']").val(1);
    $("input[name='precioUE']").val('');
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

$(document).ready(function () {
    $("#codigoP").change (function () {
        var valor = $("#codigoP").val();
        if(document.getElementById("serieReciboA").checked == true){
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoA/' + valor,
                success: function(response){
                    if($("#codigoP").val() != ""){
                        $("input[name='precioUP']").val('Q.'+response.precio_particular.toFixed(2));
                        $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                        $("input[name='subtotalP']").val('Q.'+response.precio_particular.toFixed(2));
                        $("input[name='categoria_idP']").val(response.categoria_id);

                        $("#cantidadP").val(1);
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
                        $("input[name='precioUP']").val('Q.'+response.precio_particular.toFixed(2));
                        $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                        $("input[name='subtotalP']").val('Q.'+response.precio_particular.toFixed(2));
                        $("input[name='categoria_idP']").val(response.categoria_id);
                        consultaTimbre();

                        $("#cantidadP").val(1);
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

        var subTotal = 0;

        var precioU = $("#precioUP").val().substring(2); // Convertir el valor a un entero (número).
        var cantidad = $("#cantidadP").val();

            subTotal = cantidad * precioU;

            $("#subtotalP").val('Q.'+subTotal);
    });
});

function agregarproductofP() {
    $("#codigoP").change();

    $("#cantidadP").change();
    if($.isNumeric($("#cantidadP").val()) && $("#subtotalP").val().substring(2) != 0) {

        validateRowP();
      limpiarFilaDetalleP();
    }
  }

  function validateRowP(){
    $('#tablaDetalleP').each(function(index, tr) {
        var combo = document.getElementById("codigoP");
        var selected = combo.options[combo.selectedIndex].text;
        var nFilas = $("#tablaDetalleP tr").length;
        if((nFilas == 1) && ($('#codigoP').val() != "") && ($('#precioUP').val().substring(2) != "")){
            addnewrowP();
            getTimbres(selected);
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

                        if(codigoAnt == $('#codigoP').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = 'Q.'+nuevoSubTotal.toFixed(2);

                            getTotalP();
                            getTimbres(selected);
                            limpiarFilaDetalleP();
                            document.getElementById('existencia').style.display = "none";$('#existencia').val('');
                            document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
                            document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
                            finish();
                        }
                    }
                addnewrowP();
                getTimbres(selected);
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
                        }else if(($('#codigoP').val() != "") && ($('#precioUP').val().substring(2) != "")){
                            addnewrowP();
                            getTimbres(selected);
                            limpiarFilaDetalleP();
                            finish();
                        }
                }
            }
        }
    });
}

  function addnewrowP() {

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
	resultado += $('#codigoP option:selected').text();
	resultado += '</td>';

	resultado += '<td class="cantidadP" id="cantidadP">';
	resultado += $("#cantidadP").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += $("#precioUP").val();
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
    $("select[name='codigoP']").val('');
    $("input[name='cantidadP']").val(1);
    $("input[name='precioUP']").val('');
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
    }else if (efectivoCorrecto == 1 && chequeCorrecto == 1 && tarjetaCorrecta == 1){
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

                let datos = [].map.call(document.getElementById('tablaDetalleP').rows,
                tr => [tr.cells[0].textContent, tr.cells[1].textContent, tr.cells[2].textContent, tr.cells[3].textContent, tr.cells[4].textContent, tr.cells[5].textContent, tr.cells[6].textContent]);

            $('.loader').fadeIn();
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
                url: "/creacionRecibo/save/particular",
                data: {config, datos, pos, banco, bancoDepositoP},
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
