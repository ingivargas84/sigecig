var validator = $("#RespuestaAnulacionForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		respuesta:{
            required: true,
		},
		tipoRespuesta:{
            required: true,
		},
	},
	messages: {
		respuesta: {
			required: "Por favor, ingrese la respuesta para la Anulación"
		},
		tipoRespuesta: {
			required: "Por favor, ingrese la respuesta para la Anulación"
		},
	}
});

$("#guardar").click(function(event) {
    var selected = $('#numeroRecibo').val();
	if ($('#RespuestaAnulacionForm').valid()) {
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
                    window.location.href = "{{URL::to('/admin')}}"
                },
            });
         }, function(){});
        // $('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});
