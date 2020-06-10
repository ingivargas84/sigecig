
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

            if(response.estado == 'I'){
                response.estado = 'Inactivo';
            }else if(response.estado == 'A'){
                response.estado = 'Activo';
            }

            var monto_timbre = parseFloat(response.monto_timbre);

            $("input[name='n_cliente']").val(response.n_cliente);
            $("input[name='estado']").val(response.estado);
            $("input[name='f_ult_timbre']").val(response.f_ult_timbre);
            $("input[name='f_ult_pago']").val(response.f_ult_pago);
            $("input[name='monto_timbre']").val(monto_timbre.toFixed(2));
        }else {
            alertify.warning('Numero de colegiado no exite');
            $("#ReciboForm")[0].reset();
        }
    }
  });
    $('select[name="codigo"]').val('');
    $('input[type="text"]').val('');
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
}

function limpiarPantallaColegiado()
{
    $('select[name="codigo"]').val('');
    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
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
    });
});


$(document).ready(function () {
    $("#codigo").change (function () {
        var valor = $("#codigo").val();
        if(document.getElementById("serieReciboA").checked == true){
            //limpiarFilaDetalle();
            $.ajax({
                type: 'GET',
                url: '/tipoPagoColegiadoA/' + valor,
                success: function(response){
                    if($("#codigo").val() != ""){
                        $("input[name='precioU']").val(response.precio_colegiado);
                        $("input[name='descTipoPago']").val(response.tipo_de_pago);
                        $("input[name='subtotal']").val(response.precio_colegiado);
                        $("input[name='categoria_id']").val(response.categoria_id);

                        $("#cantidad").val(1);
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
                        $("input[name='precioU']").val(response.precio_colegiado);
                        $("input[name='descTipoPago']").val(response.tipo_de_pago);
                        $("input[name='subtotal']").val(response.precio_colegiado);
                        $("input[name='categoria_id']").val(response.categoria_id);

                        $("#cantidad").val(1);
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
    });
});


$(document).ready(function(){
    $("#cantidad").change(function() {

        var subTotal = 0;

        var precioU = $("#precioU").val(); // Convertir el valor a un entero (número).
        var cantidad = $("#cantidad").val();

            subTotal = cantidad * precioU;

            $("#subtotal").val(subTotal);
    });
});

function agregarproductof() {
    $("#codigo").change();

    //llenarDatos();
    $("#cantidad").change();
    if($.isNumeric($("#cantidad").val()) && $.isNumeric($("#cantidad").val()) && $.isNumeric($("#subtotal").val())) {

        validateRow();
      limpiarFilaDetalle();
    }
  }

function validateRow(){
    $('#tablaDetalle').each(function(index, tr) {
        var nFilas = $("#tablaDetalle tr").length;
        if((nFilas == 1) && ($('#codigo').val() != "") && ($('#precioU').val() != "")){
            addnewrow();
        }else if (nFilas > 1){
            var filas = $("#tablaDetalle").find("tr");

            for(var i= 0; i < filas.length; i++){
                if(($('#categoria_id').val() == 1) || ($('#categoria_id').val() == 3)){
                    for(var i= 0; i < filas.length; i++){

                        var celdas = $(filas[i]).find("td");

                        var nuevoSubTotal = 0;
                        var subTotalColeNue = $('#subtotal').val();
                        var subTotalColeAnt = $($(celdas[5])).text();

                        var codigoAnt = $($(celdas[0])).text();

                        var totalCant = 0;
                        var cantidadA = $($(celdas[2])).text();
                        var cantidadN = $('#cantidad').val();

                        if(codigoAnt == $('#codigo').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = nuevoSubTotal;

                            getTotal();
                            limpiarFilaDetalle();
                            finish();
                        }
                    }
                addnewrow();
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
                        }else if(($('#codigo').val() != "") && ($('#precioU').val() != "")){
                            addnewrow();
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
}



function getTotal() {
    var total = 0;
    $("#tablaDetalle .subtotal").each(function (index, element) {
      total += parseFloat($(this).html(),10);
    });

    $("#total").val(total.toFixed(2));
}

  function limpiarFilaDetalle() {
    $("select[name='codigo']").val('');
    $("input[name='cantidad']").val(1);
    $("input[name='precioU']").val('');
    $("input[name='descTipoPago']").val('');
    $("input[name='subtotal']").val('');
    $("#codigo").focus();
  }

  function eliminardetalle(e) {
	if (confirm("Confirma que desea eliminar este producto") == false) {
		return;
	}
	$(e).closest('tr').remove();
  getTotal();
  limpiarFilaDetalle();
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
    }
    else{
        document.getElementById('montoCheque').readOnly = true;
        document.getElementById('cheque').style.display = "none";
        $('input[name="cheque"]').val('');
        $('input[name="montoCheque"]').val('');
    }
}

function comprobarCheckTarjeta()
{
    if (document.getElementById("tipoDePagoTarjeta").checked){
        document.getElementById('montoTarjeta').readOnly = false;
        document.getElementById('tarjeta').style.display = "";
    }
    else{
        document.getElementById('montoTarjeta').readOnly = true;
        document.getElementById('tarjeta').style.display = "none";
        $('input[name="tarjeta"]').val('');
        $('input[name="montoTarjeta"]').val('');
    }
}

$("#guardarRecibo").click(function(e){

    var efectivoCorrecto = 0;
    var chequeCorrecto = 0;
    var tarjetaCorrecta = 0;

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
        } else {chequeCorrecto = 1; $('#pagoCheque').val("si");}
    } else {chequeCorrecto = 1; $('#pagoCheque').val("no");}
    if (document.getElementById("tipoDePagoTarjeta").checked){
        if ($('#tarjeta').val() == 0){
            alertify.warning('los datos de tarjeta no pueden ir vacios...');
        } else {tarjetaCorrecta = 1;}
        if ($('#montoTarjeta').val() == 0){
            alertify.warning('el monto de tarjeta no puede ser 0...');
            tarjetaCorrecta = 0;
        } else {tarjetaCorrecta = 1; $('#pagoTarjeta').val("si");}
    } else {tarjetaCorrecta = 1; $('#pagoTarjeta').val("no");}

    if ((document.getElementById("tipoDePagoEfectivo").checked != true)  && (document.getElementById("tipoDePagoCheque").checked != true) && (document.getElementById("tipoDePagoTarjeta").checked != true)){
        alertify.warning('Seleccione un tipo de pago');
    }else if (efectivoCorrecto == 1 && chequeCorrecto == 1 && tarjetaCorrecta == 1){
        var totalEfectivo = $('#montoefectivo').val();
        var totalCheque = $('#montoCheque').val();
        var totalTarjeta = $('#montoTarjeta').val();
        var totalPago = Number(totalEfectivo) + Number(totalCheque) + Number(totalTarjeta);
        if(totalPago == $("#total").val()){

                if(document.getElementById("serieReciboA").checked == true){
                    $('#tipoSerieRecibo').val('a');
                }else if(document.getElementById("serieReciboB").checked == true){
                    $('#tipoSerieRecibo').val('b');
                }

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
                data: {config, datos},
                datatype: "json",
                success: function() {
                    $('.loader').fadeOut(1000);
                    limpiarPantallaColegiado();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Recibo almacenado con Éxito!!');
                },
                error: function(){
                    $('.loader').fadeOut(1000);
                    alertify.warning('Dato aun no almacenado');
                }
            });
        }else if(totalPago > $("#total").val()){
            alertify.warning('monto de pago es mayor al total');
        }
        else if(totalPago < $("#total").val()){
            alertify.warning('monto de pago es menor al total');
        }
    }
})

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
                        $("input[name='precioUE']").val(response.precio_colegiado);
                        $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                        $("input[name='subtotalE']").val(response.precio_colegiado);
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
                        $("input[name='precioUE']").val(response.precio_colegiado);
                        $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                        $("input[name='subtotalE']").val(response.precio_colegiado);
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
        }
    });
});

$(document).ready(function(){
    $("#cantidadE").change(function() {

        var subTotalE = 0;

        var precioUE = $("#precioUE").val(); // Convertir el valor a un entero (número).
        var cantidadE = $("#cantidadE").val();

            subTotalE = cantidadE * precioUE;

            $("#subtotalE").val(subTotalE);
    });
});

  function agregarproductofE() {
    $("#codigoE").change();

    $("#cantidadE").change();
    if($.isNumeric($("#cantidadE").val()) && $.isNumeric($("#cantidadE").val()) && $.isNumeric($("#subtotalE").val())) {

        validateRowE();
      limpiarFilaDetalleE();
    }
  }

  function validateRowE(){
    $('#tablaDetalleE').each(function(index, tr) {
        var nFilas = $("#tablaDetalleE tr").length;
        if((nFilas == 1) && ($('#codigoE').val() != "") && ($('#precioUE').val() != "")){
            addnewrowE();
        }else if (nFilas > 1){
            var filas = $("#tablaDetalleE").find("tr");

            for(var i= 0; i < filas.length; i++){
                if(($('#categoria_idE').val() == 1) || ($('#categoria_idE').val() == 3)){
                    for(var i= 0; i < filas.length; i++){

                        var celdas = $(filas[i]).find("td");

                        var nuevoSubTotal = 0;
                        var subTotalColeNue = $('#subtotalE').val();
                        var subTotalColeAnt = $($(celdas[5])).text();

                        var codigoAnt = $($(celdas[0])).text();

                        var totalCant = 0;
                        var cantidadA = $($(celdas[2])).text();
                        var cantidadN = $('#cantidadE').val();

                        if(codigoAnt == $('#codigoE').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = nuevoSubTotal;

                            getTotalE();
                            limpiarFilaDetalleE();
                            finish();
                        }
                    }
                addnewrowE();
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
                        }else if(($('#codigoE').val() != "") && ($('#precioUE').val() != "")){
                            addnewrowE();
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
}

function getTotalE() {
    var totalE = 0;
    $("#tablaDetalleE .subtotalE").each(function (index, element) {
      totalE += parseFloat($(this).html(),10);
    });

    $("#totalE").val(totalE.toFixed(2));
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
    }
    else{
        document.getElementById('montoChequeE').readOnly = true;
        document.getElementById('chequeE').style.display = "none";
        $('input[name="chequeE"]').val('');
        $('input[name="montoChequeE"]').val('');
    }
}

function comprobarCheckTarjetaE()
{
    if (document.getElementById("tipoDePagoTarjetaE").checked){
        document.getElementById('montoTarjetaE').readOnly = false;
        document.getElementById('tarjetaE').style.display = "";
    }
    else{
        document.getElementById('montoTarjetaE').readOnly = true;
        document.getElementById('tarjetaE').style.display = "none";
        $('input[name="tarjetaE"]').val('');
        $('input[name="montoTarjetaE"]').val('');
    }
}

$("#guardarReciboE").click(function(e){
    // ValidarElementos();
    var efectivoCorrecto = 0;
    var chequeCorrecto = 0;
    var tarjetaCorrecta = 0;

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
        } else {chequeCorrecto = 1; $('#pagoChequeE').val("si");}
    } else {chequeCorrecto = 1; $('#pagoChequeE').val("no");}
    if (document.getElementById("tipoDePagoTarjetaE").checked){
        if ($('#tarjetaE').val() == 0){
            alertify.warning('los datos de tarjeta no pueden ir vacios...');
        } else {tarjetaCorrecta = 1;}
        if ($('#montoTarjetaE').val() == 0){
            alertify.warning('el monto de tarjeta no puede ser 0...');
            tarjetaCorrecta = 0;
        } else {tarjetaCorrecta = 1; $('#pagoTarjetaE').val("si");}
    } else {tarjetaCorrecta = 1; $('#pagoTarjetaE').val("no");}

    if ((document.getElementById("tipoDePagoEfectivoE").checked != true)  && (document.getElementById("tipoDePagoChequeE").checked != true) && (document.getElementById("tipoDePagoTarjetaE").checked != true)){
        alertify.warning('Seleccione un tipo de pago');
    }else if (efectivoCorrecto == 1 && chequeCorrecto == 1 && tarjetaCorrecta == 1){
        var totalEfectivo = $('#montoefectivoE').val();
        var totalCheque = $('#montoChequeE').val();
        var totalTarjeta = $('#montoTarjetaE').val();
        var totalPago = Number(totalEfectivo) + Number(totalCheque) + Number(totalTarjeta);
        if(totalPago == $("#totalE").val()){

                if(document.getElementById("serieReciboA").checked == true){
                    $('#tipoSerieReciboE').val('a');
                }else if(document.getElementById("serieReciboB").checked == true){
                    $('#tipoSerieReciboE').val('b');
                }

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
                data: {config, datos},
                datatype: "json",
                success: function() {
                    $('.loader').fadeOut(1000);
                    limpiarPantallaE();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Recibo almacenado con Éxito!!');
                },
                error: function(){
                    $('.loader').fadeOut(1000);
                    alertify.warning('Dato aun no almacenado');
                }
            });
        }else if(totalPago > $("#totalE").val()){
            alertify.warning('monto de pago es mayor al total');
        }
        else if(totalPago < $("#totalE").val()){
            alertify.warning('monto de pago es menor al total');
        }
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
                        $("input[name='precioUP']").val(response.precio_colegiado);
                        $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                        $("input[name='subtotalP']").val(response.precio_colegiado);
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
                        $("input[name='precioUP']").val(response.precio_colegiado);
                        $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                        $("input[name='subtotalP']").val(response.precio_colegiado);
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
        }
    });
});


$(document).ready(function(){
    $("#cantidadP").change(function() {

        var subTotal = 0;

        var precioU = $("#precioUP").val(); // Convertir el valor a un entero (número).
        var cantidad = $("#cantidadP").val();

            subTotal = cantidad * precioU;

            $("#subtotalP").val(subTotal);
    });
});

function agregarproductofP() {
    $("#codigoP").change();

    $("#cantidadP").change();
    if($.isNumeric($("#cantidadP").val()) && $.isNumeric($("#cantidadP").val()) && $.isNumeric($("#subtotalP").val())) {

        validateRowP();
      limpiarFilaDetalleP();
    }
  }

  function validateRowP(){
    $('#tablaDetalleP').each(function(index, tr) {
        var nFilas = $("#tablaDetalleP tr").length;
        if((nFilas == 1) && ($('#codigoP').val() != "") && ($('#precioUP').val() != "")){
            addnewrowP();
        }else if (nFilas > 1){
            var filas = $("#tablaDetalleP").find("tr");

            for(var i= 0; i < filas.length; i++){
                if(($('#categoria_idP').val() == 1) || ($('#categoria_idP').val() == 3)){
                    for(var i= 0; i < filas.length; i++){

                        var celdas = $(filas[i]).find("td");

                        var nuevoSubTotal = 0;
                        var subTotalColeNue = $('#subtotalP').val();
                        var subTotalColeAnt = $($(celdas[5])).text();

                        var codigoAnt = $($(celdas[0])).text();

                        var totalCant = 0;
                        var cantidadA = $($(celdas[2])).text();
                        var cantidadN = $('#cantidadP').val();

                        if(codigoAnt == $('#codigoP').val()){
                            totalCant = Number(cantidadA) + Number(cantidadN);
                            nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                            celdas[2].innerHTML = totalCant;
                            celdas[5].innerHTML = nuevoSubTotal;

                            getTotalP();
                            limpiarFilaDetalleP();
                            finish();
                        }
                    }
                addnewrowP();
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
                        }else if(($('#codigoP').val() != "") && ($('#precioUP').val() != "")){
                            addnewrowP();
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
}



function getTotalP() {
    var total = 0;
    $("#tablaDetalleP .subtotalP").each(function (index, element) {
      total += parseFloat($(this).html(),10);
    });

    $("#totalP").val(total.toFixed(2));
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
    }
    else{
        document.getElementById('montoChequeP').readOnly = true;
        document.getElementById('chequeP').style.display = "none";
        $('input[name="chequeP"]').val('');
        $('input[name="montoChequeP"]').val('');
    }
}

function comprobarCheckTarjetaP()
{
    if (document.getElementById("tipoDePagoTarjetaP").checked){
        document.getElementById('montoTarjetaP').readOnly = false;
        document.getElementById('tarjetaP').style.display = "";
    }
    else{
        document.getElementById('montoTarjetaP').readOnly = true;
        document.getElementById('tarjetaP').style.display = "none";
        $('input[name="tarjetaP"]').val('');
        $('input[name="montoTarjetaP"]').val('');
    }
}

$("#guardarReciboP").click(function(e){
    // ValidarElementos();
    var efectivoCorrecto = 0;
    var chequeCorrecto = 0;
    var tarjetaCorrecta = 0;

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
        } else {chequeCorrecto = 1; $('#pagoChequeP').val("si");}
    } else {chequeCorrecto = 1; $('#pagoChequeP').val("no");}
    if (document.getElementById("tipoDePagoTarjetaP").checked){
        if ($('#tarjetaP').val() == 0){
            alertify.warning('los datos de tarjeta no pueden ir vacios...');
        } else {tarjetaCorrecta = 1;}
        if ($('#montoTarjetaP').val() == 0){
            alertify.warning('el monto de tarjeta no puede ser 0...');
            tarjetaCorrecta = 0;
        } else {tarjetaCorrecta = 1; $('#pagoTarjetaP').val("si");}
    } else {tarjetaCorrecta = 1; $('#pagoTarjetaP').val("no");}

    if ((document.getElementById("tipoDePagoEfectivoP").checked != true)  && (document.getElementById("tipoDePagoChequeP").checked != true) && (document.getElementById("tipoDePagoTarjetaP").checked != true)){
        alertify.warning('Seleccione un tipo de pago');
    }else if (efectivoCorrecto == 1 && chequeCorrecto == 1 && tarjetaCorrecta == 1){
        var totalEfectivo = $('#montoefectivoP').val();
        var totalCheque = $('#montoChequeP').val();
        var totalTarjeta = $('#montoTarjetaP').val();
        var totalPago = Number(totalEfectivo) + Number(totalCheque) + Number(totalTarjeta);
        if(totalPago == $("#totalP").val()){

                if(document.getElementById("serieReciboA").checked == true){
                    $('#tipoSerieReciboP').val('a');
                }else if(document.getElementById("serieReciboB").checked == true){
                    $('#tipoSerieReciboP').val('b');
                }

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
                data: {config, datos},
                datatype: "json",
                success: function() {
                    $('.loader').fadeOut(1000);
                    limpiarPantallaP();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Recibo almacenado con Éxito!!');
                },
                error: function(){
                    $('.loader').fadeOut(1000);
                    alertify.warning('Dato aun no almacenado');
                }
            });
        }else if(totalPago > $("#totalP").val()){
            alertify.warning('monto de pago es mayor al total');
        }
        else if(totalPago < $("#totalP").val()){
            alertify.warning('monto de pago es menor al total');
        }
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
}
