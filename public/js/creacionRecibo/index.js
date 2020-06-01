
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
                //if(valor != null){
                    $("input[name='precioU']").val(response.precio_colegiado);
                    $("input[name='descTipoPagoColegiado']").val(response.tipo_de_pago);
                    $("input[name='subtotalColegiado']").val(response.precio_colegiado);

                    $("#cantidad").val(1);
                    //$("inpu[name='cantidad']").val(1);
                //}else {
            },
            error: function() {
                    $("input[name='precioU']").val('');
                    $("input[name='descTipoPagoColegiado']").val('');
                    $("input[name='subtotalColegiado']").val('');
                    $("input[name='monto_timbre']").val('');
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

            $("#subtotalColegiado").val(subTotal);
    });
});

function agregarproductof() {
    $("#codigo").change();

    //llenarDatos();
    $("#cantidad").change();
    if($.isNumeric($("#cantidad").val()) && $.isNumeric($("#cantidad").val()) && $.isNumeric($("#subtotalColegiado").val())) {

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

                var celdas = $(filas[i]).find("td");

                var nuevoSubTotal = 0;
                var subTotalColeNue = $('#subtotalColegiado').val();
                var subTotalColeAnt = $($(celdas[4])).text();

                var codigoAnt = $($(celdas[0])).text();

                var totalCant = 0;
                var cantidadA = $($(celdas[1])).text();
                var cantidadN = $('#cantidad').val();

                if(codigoAnt == $('#codigo').val()){

                        totalCant = Number(cantidadA) + Number(cantidadN);
                        nuevoSubTotal = Number(subTotalColeAnt) + Number(subTotalColeNue);

                        celdas[1].innerHTML = totalCant;
                        celdas[4].innerHTML = nuevoSubTotal;

                        getTotal();
                        finish();
                }
            }
            addnewrow();
        }
    });
}

  function addnewrow() {

	if(!$('#tablaDetalle').length) {
		var resultado = '<table class="table table-striped table-hover" id="tablaDetalle"><thead><tr><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th>Eliminar</th></tr></thead><tbody>';
		resultado += '</tbody></table>';
		$("#detalle").html(resultado);
	}
	var resultado = "";
	resultado += '<tr class="filaDetalleVal">';


	resultado += '<td class="codigo" id="codigo">';
	resultado += $("#codigo").val();
	resultado += '</td>';

	resultado += '<td class="cantidad" id="cantidad">';
	resultado += $("#cantidad").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += $("#precioU").val();
	resultado += '</td>';

	resultado += '<td class="descTipoPagoColegiado">';
	resultado += $("#descTipoPagoColegiado").val();
	resultado += '</td>';

	resultado += '<td align="center" class="subtotalColegiado">';
	resultado += $("#subtotalColegiado").val();
	resultado += '</td>';


	resultado += '<td>';
	resultado += '<button class="form-button btn btn-danger" onclick="eliminardetalle(this)" type="button">X</button>';
	resultado += '</td>';
	resultado += '</tr>';

	$(resultado).prependTo("#tablaDetalle > tbody");
   getTotal();
//   rellenarLeyenda();
//   mostrarConstancia();
}



function getTotal() {
    var total = 0;
    $("#tablaDetalle .subtotalColegiado").each(function (index, element) {
      total += parseFloat($(this).html(),10);
    });

    $("#total").val(total.toFixed(2));
    //$("#efectivo").val(total);
    //$("#sueldo").val(total);
}

  function limpiarFilaDetalle() {
    //$("input[name='codigo']").val('');
    $("input[name='canitdad']").val(1);
    $("input[name='precioU']").val('');
    $("input[name='descTipoPagoColegiado']").val('');
    $("input[name='subtotalColegiado']").val('');
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
  //rellenarLeyenda();
  //mostrarConstancia();
}


$(document).ready(function(){
    	$("#buttonAgregar").click(function(){
        	$("#buttonAgregar").attr(

                "value","OTRO TEXTO"

            );
    	});
});

//Funcionamiento sobre EMPRESA

$(document).ready(function () {
    $("#codigoE").change (function () {
        var valor = $("#codigoE").val();
        $.ajax({
            type: 'GET',
            url: '/tipoPagoColegiado/' + valor,
            success: function(response){
                //if(valor != null){
                    $("input[name='precioUE']").val(response.precio_colegiado);
                    $("input[name='descTipoPagoE']").val(response.tipo_de_pago);
                    $("input[name='subtotalE']").val(response.precio_colegiado);

                    $("#cantidadE").val(1);
                    //$("inpu[name='cantidad']").val(1);
                //}else {
            },
            error: function() {
                    $("input[name='precioUE']").val('');
                    $("input[name='descTipoPagoE']").val('');
                    $("input[name='subtotalE']").val('');
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

    //llenarDatos();
    $("#cantidadE").change();
    if($.isNumeric($("#cantidadE").val()) && $.isNumeric($("#cantidadE").val()) && $.isNumeric($("#subtotalColegiadoE").val())) {

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

                var celdas = $(filas[i]).find("td");

                var nuevoSubTotal = 0;
                var subTotalENue = $('#subtotalE').val();
                var subTotalEAnt = $($(celdas[4])).text();

                var codigoAnt = $($(celdas[0])).text();

                var totalCant = 0;
                var cantidadA = $($(celdas[1])).text();
                var cantidadN = $('#cantidadE').val();

                if(codigoAnt == $('#codigoE').val()){

                        totalCant = Number(cantidadA) + Number(cantidadN);
                        nuevoSubTotal = Number(subTotalEAnt) + Number(subTotalENue);

                        celdas[1].innerHTML = totalCant;
                        celdas[4].innerHTML = nuevoSubTotal;

                        getTotalE();
                        finish();
                }
            }
            addnewrowE();
        }
    });
}

  function addnewrowE() {

	if(!$('#tablaDetalleE').length) {
		var resultado = '<table class="table table-striped table-hover" id="tablaDetalleE"><thead><tr><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th>Eliminar</th></tr></thead><tbody>';
		resultado += '</tbody></table>';
		$("#detalleE").html(resultado);
	}
	var resultado = "";
	resultado += '<tr class="filaDetalleVal">';


	resultado += '<td class="codigo">';
	resultado += $("#codigoE").val();
	resultado += '</td>';

	resultado += '<td>';
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
