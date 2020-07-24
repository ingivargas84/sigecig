
$(document).ready(function(){
    $('#bodega1').change(function() {
        var bodega1 = $('#bodega1').val();
        $.ajax({
            type: 'GET',
            url: '/getBodega/' + bodega1,
            success: function(response){
                if (response.tc01 == null){ response.tc01 = 0 }
                if (response.tc05 == null){ response.tc05 = 0 }
                if (response.tc10 == null){ response.tc10 = 0 }
                if (response.tc20 == null){ response.tc20 = 0 }
                if (response.tc50 == null){ response.tc50 = 0 }
                if (response.tc100 == null){ response.tc100 = 0 }
                if (response.tc200 == null){ response.tc200 = 0 }
                if (response.tc500 == null){ response.tc500 = 0 }

                $('#existenciaTc01B1').val(response.tc01);
                $('#existenciaTc05B1').val(response.tc05);
                $('#existenciaTc10B1').val(response.tc10);
                $('#existenciaTc20B1').val(response.tc20);
                $('#existenciaTc50B1').val(response.tc50);
                $('#existenciaTc100B1').val(response.tc100);
                $('#existenciaTc200B1').val(response.tc200);
                $('#existenciaTc500B1').val(response.tc500);

                limpiarCantidaYExistencia();
            },
        });
    });
    $('#bodega2').change(function() {
        var bodega2 = $('#bodega2').val();
        $.ajax({
            type: 'GET',
            url: '/getBodega/' + bodega2,
            success: function(response){
                if (response.tc01 == null){ response.tc01 = 0 }
                if (response.tc05 == null){ response.tc05 = 0 }
                if (response.tc10 == null){ response.tc10 = 0 }
                if (response.tc20 == null){ response.tc20 = 0 }
                if (response.tc50 == null){ response.tc50 = 0 }
                if (response.tc100 == null){ response.tc100 = 0 }
                if (response.tc200 == null){ response.tc200 = 0 }
                if (response.tc500 == null){ response.tc500 = 0 }

                $('#existenciaTc01B2').val(response.tc01);
                $('#existenciaTc05B2').val(response.tc05);
                $('#existenciaTc10B2').val(response.tc10);
                $('#existenciaTc20B2').val(response.tc20);
                $('#existenciaTc50B2').val(response.tc50);
                $('#existenciaTc100B2').val(response.tc100);
                $('#existenciaTc200B2').val(response.tc200);
                $('#existenciaTc500B2').val(response.tc500);

                limpiarCantidaYExistencia();
            },
        });
    });
});

$(document).ready(function(){
    $('#cantidadTraspasoTc01B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc01B1').val()) + Number($('#existenciaTc01B2').val());
        $('#nuevaCantidadTc01B2').val(total);
        if ($('#cantidadTraspasoTc01B1').val() == 0){
            $('#nuevaCantidadTc01B2').val(0);
        }
    });
    $('#cantidadTraspasoTc05B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc05B1').val()) + Number($('#existenciaTc05B2').val());
        $('#nuevaCantidadTc05B2').val(total);
        if ($('#cantidadTraspasoTc05B1').val() == 0){
            $('#nuevaCantidadTc05B2').val(0);
        }
    });
    $('#cantidadTraspasoTc10B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc10B1').val()) + Number($('#existenciaTc10B2').val());
        $('#nuevaCantidadTc10B2').val(total);
        if ($('#cantidadTraspasoTc10B1').val() == 0){
            $('#nuevaCantidadTc10B2').val(0);
        }
    });
    $('#cantidadTraspasoTc20B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc20B1').val()) + Number($('#existenciaTc20B2').val());
        $('#nuevaCantidadTc20B2').val(total);
        if ($('#cantidadTraspasoTc20B1').val() == 0){
            $('#nuevaCantidadTc20B2').val(0);
        }
    });
    $('#cantidadTraspasoTc50B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc50B1').val()) + Number($('#existenciaTc50B2').val());
        $('#nuevaCantidadTc50B2').val(total);
        if ($('#cantidadTraspasoTc50B1').val() == 0){
            $('#nuevaCantidadTc50B2').val(0);
        }
    });
    $('#cantidadTraspasoTc100B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc100B1').val()) + Number($('#existenciaTc100B2').val());
        $('#nuevaCantidadTc100B2').val(total);
        if ($('#cantidadTraspasoTc100B1').val() == 0){
            $('#nuevaCantidadTc100B2').val(0);
        }
    });
    $('#cantidadTraspasoTc200B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc200B1').val()) + Number($('#existenciaTc200B2').val());
        $('#nuevaCantidadTc200B2').val(total);
        if ($('#cantidadTraspasoTc200B1').val() == 0){
            $('#nuevaCantidadTc200B2').val(0);
        }
    });
    $('#cantidadTraspasoTc500B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc500B1').val()) + Number($('#existenciaTc500B2').val());
        $('#nuevaCantidadTc500B2').val(total);
        if ($('#cantidadTraspasoTc500B1').val() == 0){
            $('#nuevaCantidadTc500B2').val(0);
        }
    });

});

function limpiarCantidaYExistencia() {
    $('#cantidadTraspasoTc01B1').val(0);
    $('#cantidadTraspasoTc05B1').val(0);
    $('#cantidadTraspasoTc10B1').val(0);
    $('#cantidadTraspasoTc20B1').val(0);
    $('#cantidadTraspasoTc50B1').val(0);
    $('#cantidadTraspasoTc100B1').val(0);
    $('#cantidadTraspasoTc200B1').val(0);
    $('#cantidadTraspasoTc500B1').val(0);
    $('#nuevaCantidadTc01B2').val(0);
    $('#nuevaCantidadTc05B2').val(0);
    $('#nuevaCantidadTc10B2').val(0);
    $('#nuevaCantidadTc20B2').val(0);
    $('#nuevaCantidadTc50B2').val(0);
    $('#nuevaCantidadTc100B2').val(0);
    $('#nuevaCantidadTc200B2').val(0);
    $('#nuevaCantidadTc500B2').val(0);
}

var validator = $("#TrasladoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		bodega1:{
			required: true
		},
		bodega2:{
			required: true
		}
	},
	messages: {
		bodega1: {
			required: "Por favor, seleccione una bodega de Origen"
		},
		bodega2: {
			required: "Por favor, seleccione una bodega Destino"
		}
	}
});

$("#guardar").click(function(event) {
	if ($('#TrasladoForm').valid()) {

        if($('#nuevaCantidadTc01B2').val() == 0 && $('#nuevaCantidadTc05B2').val() == 0 && $('#nuevaCantidadTc10B2').val() == 0 && $('#nuevaCantidadTc20B2').val() == 0 && $('#nuevaCantidadTc50B2').val() == 0 && $('#nuevaCantidadTc100B2').val() == 0 && $('#nuevaCantidadTc200B2').val() == 0 && $('#nuevaCantidadTc500B2').val() == 0){
            alertify.warning('no se puede almacenar si no realiza ningun traspaso de timbre');
        }else {
            if (Number($('#cantidadTraspasoTc01B1').val()) > Number($('#existenciaTc01B1').val())){ alertify.set('notifier','position', 'top-center'); alertify.error('la cantidad de timbres a traspasar TC01 excede su existencia');
            } else if (Number($('#cantidadTraspasoTc05B1').val()) > Number($('#existenciaTc05B1').val())){ alertify.set('notifier','position', 'top-center'); alertify.error('la cantidad de timbres a traspasar TC05 excede su existencia');
            } else if (Number($('#cantidadTraspasoTc10B1').val()) > Number($('#existenciaTc10B1').val())){ alertify.set('notifier','position', 'top-center'); alertify.error('la cantidad de timbres a traspasar TC10 excede su existencia');
            } else if (Number($('#cantidadTraspasoTc20B1').val()) > Number($('#existenciaTc20B1').val())){ alertify.set('notifier','position', 'top-center'); alertify.error('la cantidad de timbres a traspasar TC20 excede su existencia');
            } else if (Number($('#cantidadTraspasoTc50B1').val()) > Number($('#existenciaTc50B1').val())){ alertify.set('notifier','position', 'top-center'); alertify.error('la cantidad de timbres a traspasar TC50 excede su existencia');
            } else if (Number($('#cantidadTraspasoTc100B1').val()) > Number($('#existenciaTc100B1').val())){ alertify.set('notifier','position', 'top-center'); alertify.error('la cantidad de timbres a traspasar TC100 excede su existencia');
            } else if (Number($('#cantidadTraspasoTc200B1').val()) > Number($('#existenciaTc200B1').val())){ alertify.set('notifier','position', 'top-center'); alertify.error('la cantidad de timbres a traspasar TC200 excede su existencia');
            } else if (Number($('#cantidadTraspasoTc500B1').val()) > Number($('#existenciaTc500B1').val())){ alertify.set('notifier','position', 'top-center'); alertify.error('la cantidad de timbres a traspasar TC500 excede su existencia');
            } else {
                if (Number($('#bodega1').val()) == Number($('#bodega2').val())){
                    alertify.set('notifier','position', 'top-center'); alertify.error('Esta introduciendo la misma bodega en Origen y Destino');
                }else {
                    $('.loader').addClass("is-active");
                    var config = {};
                    $('input').each(function () {
                    config[this.name] = this.value;
                    });

                    var bodegaOrigen = $('#bodega1').val();
                    var bodegaDestino = $('#bodega2').val();

                    $.ajax({
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('#tokenUser').val()},
                        url: "/traspaso/save",
                        data: {config, bodegaOrigen, bodegaDestino},
                        datatype: "json",
                        success: function() {
                            window.location = "/traspaso";
                            $('.loader').fadeOut(1000);
                            alertify.set('notifier','position', 'top-center');
                            alertify.success('Datos almacenados con Éxito!!');
                        },
                        error: function(){
                            alertify.warning('error');
                            $('.loader').fadeOut(1000);
                        }
                    });
                }
            }
        }
	} else {
		validator.focusInvalid();
	}
});


