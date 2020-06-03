
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
            alertify.error('Numero de colegiado no exite');
            $("#ReciboForm")[0].reset();
        }
    }
  });
  $("tbody").children().remove()
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
            $('input[type="text"]').val('');
            $('input[type="number"]').val('');
        }

    }
  });
  $("tbody").children().remove()
}

//Funcionamiento sobre colegiado

$(document).ready(function () {
    $("#codigo").change (function () {
        var valor = $("#codigo").val();
        $.ajax({
            type: 'GET',
            url: '/tipoPagoColegiado/' + valor,
            success: function(response){
                    $("input[name='precioU']").val(response.precio_colegiado);
                    $("input[name='descTipoPago']").val(response.tipo_de_pago);
                    $("input[name='subtotal']").val(response.precio_colegiado);
                    $("input[name='categoria_id']").val(response.categoria_id);

                    $("#cantidad").val(1);
            },
            error: function() {
                    $("input[name='precioU']").val('');
                    $("input[name='descTipoPago']").val('');
                    $("input[name='subtotal']").val('');
                    $("input[name='monto_timbre']").val('');
                    $("input[name='categoria_id']").val('');
                }
        });
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
        if((nFilas == 1) && ($('#codigo').val() != "")){
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
                            alertify.error('/.tipo de pago ya ha sido ingresado./');
                            finish();
                        }else if($('#codigo').val() != ""){
                            addnewrow();
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

	resultado += '<td>';
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
    //$("input[name='codigo']").val('');
    $("input[name='canitdad']").val(1);
    $("input[name='precioU']").val('');
    $("input[name='descTipoPago']").val('');
    $("input[name='subtotal']").val('');
    $("input[name='monto_timbre']").val('');
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



//Funcionamiento sobre EMPRESA

$(document).ready(function () {
    $("#codigoE").change (function () {
        var valor = $("#codigoE").val();
        $.ajax({
            type: 'GET',
            url: '/tipoPagoColegiado/' + valor,
            success: function(response){
                    $("input[name='precioUE']").val(response.precio_colegiado);
                    $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                    $("input[name='subtotalE']").val(response.precio_colegiado);
                    $("input[name='categoria_idE']").val(response.categoria_id);

                    $("#cantidadE").val(1);
            },
            error: function() {
                    $("input[name='precioUE']").val('');
                    $("input[name='descTipoPagoE']").val('');
                    $("input[name='subtotalE']").val('');
                    $("input[name='categoria_idE']").val('');
                }
        });
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
        if((nFilas == 1) && ($('#codigoE').val() != "")){
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
                            alertify.error('/.tipo de pago ya ha sido ingresado./');
                            finish();
                        }else if($('#codigoE').val() != ""){
                            addnewrowE();
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
    //$("input[name='codigo']").val('');
    $("input[name='canitdadE']").val(1);
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

//Funcionamiento sobre Particular

$(document).ready(function () {
    $("#codigoP").change (function () {
        var valor = $("#codigoP").val();
        $.ajax({
            type: 'GET',
            url: '/tipoPagoColegiado/' + valor,
            success: function(response){
                    $("input[name='precioUP']").val(response.precio_colegiado);
                    $("input[name='descTipoPagoP']").val(response.tipo_de_pago);
                    $("input[name='subtotalP']").val(response.precio_colegiado);
                    $("input[name='categoria_idP']").val(response.categoria_id);

                    $("#cantidadP").val(1);
            },
            error: function() {
                    $("input[name='precioUP']").val('');
                    $("input[name='descTipoPagoP']").val('');
                    $("input[name='subtotalP']").val('');
                    $("input[name='monto_timbreP']").val('');
                    $("input[name='categoria_idP']").val('');
                }
        });
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
        if((nFilas == 1) && ($('#codigoP').val() != "")){
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
                            alertify.error('/.tipo de pago ya ha sido ingresado./');
                            finish();
                        }else if($('#codigoP').val() != ""){
                            addnewrowP();
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
    //$("input[name='codigo']").val('');
    $("input[name='canitdadP']").val(1);
    $("input[name='precioUP']").val('');
    $("input[name='descTipoPagoP']").val('');
    $("input[name='subtotalP']").val('');
    $("input[name='monto_timbreP']").val('');
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


