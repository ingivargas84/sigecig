
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
    });
    $('#cantidadTraspasoTc05B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc05B1').val()) + Number($('#existenciaTc05B2').val());
        $('#nuevaCantidadTc05B2').val(total);
    });
    $('#cantidadTraspasoTc10B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc10B1').val()) + Number($('#existenciaTc10B2').val());
        $('#nuevaCantidadTc10B2').val(total);
    });
    $('#cantidadTraspasoTc20B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc20B1').val()) + Number($('#existenciaTc20B2').val());
        $('#nuevaCantidadTc20B2').val(total);
    });
    $('#cantidadTraspasoTc50B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc50B1').val()) + Number($('#existenciaTc50B2').val());
        $('#nuevaCantidadTc50B2').val(total);
    });
    $('#cantidadTraspasoTc100B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc100B1').val()) + Number($('#existenciaTc100B2').val());
        $('#nuevaCantidadTc100B2').val(total);
    });
    $('#cantidadTraspasoTc200B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc200B1').val()) + Number($('#existenciaTc200B2').val());
        $('#nuevaCantidadTc200B2').val(total);
    });
    $('#cantidadTraspasoTc500B1').change(function() {
        var total = 0;
        total = Number($('#cantidadTraspasoTc500B1').val()) + Number($('#existenciaTc500B2').val());
        $('#nuevaCantidadTc500B2').val(total);
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
