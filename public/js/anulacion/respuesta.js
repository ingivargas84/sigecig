var validator = $("#RespuestaAnulacionForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cuadroRespuesta:{
            required: true,
		},
		// tipoRespuesta:{
        //     required: true,
		// },
	},
	messages: {
		cuadroRespuesta: {
			required: "Por favor, ingrese la respuesta para la Anulación"
		},
		// tipoRespuesta: {
		// 	required: "Por favor, ingrese la respuesta para la Anulación"
		// },
	}
});

$("#guardar").click(function(event) {
    var selected = $('#numeroRecibo').val();
	if ($('#RespuestaAnulacionForm').valid()) {
        if (document.getElementById("tipoRespuestaA").checked && !document.getElementById("tipoRespuestaR").checked) {
            $("#tipoRespuesta").val(2);
            $("#respuesta").val($("#cuadroRespuesta").val());
            guardar();
        } else if (document.getElementById("tipoRespuestaR").checked && !document.getElementById("tipoRespuestaA").checked) {
            $("#tipoRespuesta").val(3);
            $("#respuesta").val($("#cuadroRespuesta").val());
            guardar();
        } else if((document.getElementById("tipoRespuestaA").checked && document.getElementById("tipoRespuestaR").checked) || (!document.getElementById("tipoRespuestaA").checked) || (!document.getElementById("tipoRespuestaR").checked)){
            alertify.set('notifier','position', 'top-center');
            alertify.error('debe de seleccionar una opción de respuesta...');
        }
	} else {
		validator.focusInvalid();
	}
});

function guardar(){
    var selected = $('#numeroRecibo').val();
    alertify.confirm('Confirmación de Proceso de Anulación', 'Este proceso es irreversible, Esta seguro que desea realizarlo en el recibo: <strong>' + selected + "</strong>",
        function(){
            var config = {};
                $('input').each(function () {
                config[this.name] = this.value;
                });
            $('.loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: "/anulacionRespuesta/save",
                data: config,
                success: function() {
                    $('.loader').fadeOut(1000);
                    window.location.href = "/admin"
                },
            });
        }, function(){});
    // $('.loader').addClass("is-active");
}
