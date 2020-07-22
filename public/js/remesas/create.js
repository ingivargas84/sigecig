// Timbres de Q.1.00
$(document).ready(function(){
    $('#planchasTc01').change(function() { calculoTc01() });
    $('#unidadPlanchaTc01').change(function() { calculoTc01() });
});

function calculoTc01()
{
    var cantidad = 0;
    cantidad = Number($("#planchasTc01").val()) * Number($("#unidadPlanchaTc01").val());
    $("#cantidadTc01").val(cantidad);

    var total = 0;
    total = cantidad * 1;
    $("#totalTc01").val('Q.'+ total +".00");

    var inicio = $("#numeroInicialTc01").val();
    var cant = $("#cantidadTc01").val();
    var final = Number(inicio) + Number(cant) - 1;
    $('#numeroFinalTc01').val(final);
}

// Timbres de Q.5.00
$(document).ready(function(){
    $('#planchasTc05').change(function() { calculoTc05(); });
    $('#unidadPlanchaTc05').change(function() { calculoTc05(); });
});

function calculoTc05()
{
    var cantidad = 0;
    cantidad = Number($("#planchasTc05").val()) * Number($("#unidadPlanchaTc05").val());
    $("#cantidadTc05").val(cantidad);

    var total = 0;
    total = cantidad * 5;
    $("#totalTc05").val('Q.'+total+'.00');

    var inicio = $("#numeroInicialTc05").val();
    var cant = $("#cantidadTc05").val();
    var final = Number(inicio) + Number(cant) - 1;
    $('#numeroFinalTc05').val(final);
}

// Timbres de Q.10.00
$(document).ready(function(){
    $('#planchasTc10').change(function() { calculoTc10(); });
    $('#unidadPlanchaTc10').change(function() { calculoTc10(); });
});

function calculoTc10()
{
    var cantidad = 0;
    cantidad = Number($("#planchasTc10").val()) * Number($("#unidadPlanchaTc10").val());
    $("#cantidadTc10").val(cantidad);

    var total = 0;
    total = cantidad * 10;
    $("#totalTc10").val('Q.'+total+'.00');

    var inicio = $("#numeroInicialTc10").val();
    var cant = $("#cantidadTc10").val();
    var final = Number(inicio) + Number(cant) - 1;
    $('#numeroFinalTc10').val(final);
}

// Timbres de Q.20.00
$(document).ready(function(){
    $('#planchasTc20').change(function() { calculoTc20(); });
    $('#unidadPlanchaTc20').change(function() { calculoTc20(); });
});

function calculoTc20()
{
    var cantidad = 0;
    cantidad = Number($("#planchasTc20").val()) * Number($("#unidadPlanchaTc20").val());
    $("#cantidadTc20").val(cantidad);

    var total = 0;
    total = cantidad * 20;
    $("#totalTc20").val('Q.'+total+'.00');

    var inicio = $("#numeroInicialTc20").val();
    var cant = $("#cantidadTc20").val();
    var final = Number(inicio) + Number(cant) - 1;
    $('#numeroFinalTc20').val(final);
}

// Timbres de Q.50.00
$(document).ready(function(){
    $('#planchasTc50').change(function() { calculoTc50(); });
    $('#unidadPlanchaTc50').change(function() { calculoTc50(); });
});

function calculoTc50()
{
    var cantidad = 0;
    cantidad = Number($("#planchasTc50").val()) * Number($("#unidadPlanchaTc50").val());
    $("#cantidadTc50").val(cantidad);

    var total = 0;
    total = cantidad * 50;
    $("#totalTc50").val('Q.'+total+'.00');

    var inicio = $("#numeroInicialTc50").val();
    var cant = $("#cantidadTc50").val();
    var final = Number(inicio) + Number(cant) - 1;
    $('#numeroFinalTc50').val(final);
}

// Timbres de Q.100.00
$(document).ready(function(){
    $('#planchasTc100').change(function() { calculoTc100(); });
    $('#unidadPlanchaTc100').change(function() { calculoTc100(); });
});

function calculoTc100()
{
    var cantidad = 0;
    cantidad = Number($("#planchasTc100").val()) * Number($("#unidadPlanchaTc100").val());
    $("#cantidadTc100").val(cantidad);

    var total = 0;
    total = cantidad * 100;
    $("#totalTc100").val('Q.'+total+'.00');

    var inicio = $("#numeroInicialTc100").val();
    var cant = $("#cantidadTc100").val();
    var final = Number(inicio) + Number(cant) - 1;
    $('#numeroFinalTc100').val(final);
}

// Timbres de Q.200.00
$(document).ready(function(){
    $('#planchasTc200').change(function() { calculoTc200(); });
    $('#unidadPlanchaTc200').change(function() { calculoTc200(); });
});

function calculoTc200()
{
    var cantidad = 0;
    cantidad = Number($("#planchasTc200").val()) * Number($("#unidadPlanchaTc200").val());
    $("#cantidadTc200").val(cantidad);

    var total = 0;
    total = cantidad * 200;
    $("#totalTc200").val('Q.'+total+'.00');

    var inicio = $("#numeroInicialTc200").val();
    var cant = $("#cantidadTc200").val();
    var final = Number(inicio) + Number(cant) - 1;
    $('#numeroFinalTc200').val(final);
}


// Timbres de Q.500.00
$(document).ready(function(){
    $('#planchasTc500').change(function() { calculoTc500(); });
    $('#unidadPlanchaTc500').change(function() { calculoTc500(); });
});

function calculoTc500()
{
    var cantidad = 0;
    cantidad = Number($("#planchasTc500").val()) * Number($("#unidadPlanchaTc500").val());
    $("#cantidadTc500").val(cantidad);

    var total = 0;
    total = cantidad * 500;
    $("#totalTc500").val('Q.'+total+'.00');

    var inicio = $("#numeroInicialTc500").val();
    var cant = $("#cantidadTc500").val();
    var final = Number(inicio) + Number(cant) - 1;
    $('#numeroFinalTc500').val(final);
}

$(document).ready(function(){
    let datos = [].map.call(document.getElementById('tablaRegistro').rows,
    tr => [tr.cells[0].textContent]);

    $.ajax({
        type: "POST",
        dataType:'JSON',
        url: "/getUltimoDato/"+datos,
        success: function(data){
            $('#numeroInicialTc01').val(data.tc01);
            $('#numeroInicialTc05').val(data.tc05);
            $('#numeroInicialTc10').val(data.tc10);
            $('#numeroInicialTc20').val(data.tc20);
            $('#numeroInicialTc50').val(data.tc50);
            $('#numeroInicialTc100').val(data.tc100);
            $('#numeroInicialTc200').val(data.tc200);
            $('#numeroInicialTc500').val(data.tc500);
        },
    });
});

var validator = $("#RemesaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		bodega:{
			required: true
		}
	},
	messages: {
		bodega: {
			required: "Por favor, seleccione una bodega"
		}
	}
});

$("#guardar").click(function(event) {
	if ($('#RemesaForm').valid()) {

        var combo = document.getElementById("bodega");
        var selected = combo.options[combo.selectedIndex].text;

        if($('#cantidadTc01').val() == 0 && $('#cantidadTc05').val() == 0 && $('#cantidadTc10').val() == 0 && $('#cantidadTc20').val() == 0 && $('#cantidadTc50').val() == 0 && $('#cantidadTc100').val() == 0 && $('#cantidadTc200').val() == 0 && $('#cantidadTc500').val() == 0){
            alertify.warning('no se puede almacenar si no ingresa ningún timbre a bodega');
        }else{
            alertify.confirm('Almacenamiento Bodega', 'Este proceso es irreversible, Esta seguro de ingresar los siguientes datos a la bodega: <strong>' + selected + "</strong>",
            function(){
                var config = {};
                $('input').each(function () {
                config[this.name] = this.value;
                });

                var bodega = $('#bodega').val();

                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
                    url: "/remesa/save",
                    data: {config, bodega},
                    datatype: "json",
                    success: function() {
                        $('.loader').fadeOut(1000);
                        window.location = "/remesa";
                        alertify.set('notifier','position', 'top-center');
                        alertify.success('Datos almacenados con Éxito!!');
                    },
                    error: function(){
                        $('.loader').fadeOut(1000);
                    }
                });
            }
            , function(){
                alertify.set('notifier','position', 'top-center');
            });
        }
	} else {
		validator.focusInvalid();
	}
});

