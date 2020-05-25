
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
    if($.isNumeric($("#cantidad").val()) && $.isNumeric($("#cantidad").val()) && $.isNumeric($("#subtotal").val())) {
      addnewrow();
      $("#codigo").val('');
      $("#cantidad").val('');
        $("#precioU").val('');
        $("#descTipoPagoColegiado").val('');
        $("#subtotalColegiado").val('');
      limpiarFilaDetalle();
    }
  }

  function addnewrow() {

	if(!$('#tablaDetalle').length) {
		var resultado = '<table class="table table-striped table-hover" id="tablaDetalle"><thead><tr><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th>Eliminar</th></tr></thead><tbody>';
		resultado += '</tbody></table>';
		$("#detalle").html(resultado);
	}
	var resultado = "";
	resultado += '<tr class="filaDetalleVal">';


	resultado += '<td class="codigo">';
	resultado += $("#codigo").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += $("#cantidad").val();
	resultado += '</td>';

	resultado += '<td>';
	resultado += $("#precioU").val();
	resultado += '</td>';

	resultado += '<td class="descTipoPagoColegiado">';
	resultado += $("#descTipoPagoColegiado").val();
	resultado += '</td>';

	resultado += '<td align="right" class="subtotalColegiado">';
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
    $("#tablaDetalle .subtotalVal").each(function (index, element) {
      total += parseFloat($(this).html(),10);
    });

    $("#totalAPagar").val(total.toFixed(2));
    //$("#efectivo").val(total);
    $("#sueldo").val(total);
}


function llenarDatos() {
    //alert($.trim($('#codigo').val()).toUpperCase());
    $("#codigo").val(($("#codigo").val()).toUpperCase());
    if($.trim($('#codigo').val()).toUpperCase() === 'INT' || $('#codigo').val() === 'int') {
      if($("#tipo").val() == "02") {
        //getInteresTimbre();
      } else {
        errorCategoria();
      }
    } else {
      console.log("morir1");
      getPrecios();
    }
  }

  function limpiarFilaDetalle() {
    $("#codigo").val('');
    $("#cantidad").val('');
      $("#preciou").val('');
      $("#leyendad").val('');
      $("#subtotal").val('');
    $("#codigo").focus();
  }
