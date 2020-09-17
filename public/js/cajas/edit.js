var validator = $("#FormcajasUpdate").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_caja:{
			required: true,
			nombreunicoedit : true
		},
		subsede: {
			required : true
		},
		cajero: {
			required : true
		},
		bodega: {
			required : true
		}
	},
	messages: {
		nombre_caja: {
			required: "Por favor, ingrese el numero de caja"
		},
		subsede: {
			required: "Por favor, ingrese su nombre de subsede"
		},
		cajero: {
			required: "por favor, ingrese el cajero"
		},
		bodega: {
			required: "Por favor, ingrese la bodega"
		}
	}
});



$('#editUpdateModal1').on('shown.bs.modal', function(event){
	$(".modal-body select[name='cajero']").empty();
	$(".modal-body select[name='bodega']").empty();

	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre_caja = button.data('nombre_caja');
	var subsede = button.data('subsede');
	var cajero = button.data('cajero');
	var bodega = button.data('bodega');

	var modal = $(this);
	modal.find(".modal-body input[name='test']").val(id);
	modal.find(".modal-body input[name='nombre_caja']").val(nombre_caja);
	modal.find(".modal-body select[name='subsede']").val(subsede);
	modal.find(".modal-body select[name='cajero']").val(cajero);
	modal.find(".modal-body select[name='bodega']").val(bodega);
	cambioSerie (id, cajero, bodega);
 });


 function cambioSerie (id, cajero, bodega) {
	$.ajax({
			type: 'GET',
			url:  '/edit/bodega/' + id,
			success: function(response){
				for (i = 0; i < response[0].length; i++){
						if(response[0][i].id == bodega){
							$(".modal-body select[name='bodega']").append( '<option selected="true" value="'+response[0][i].id+'">'+response[0][i].nombre_bodega+'</option>' );

						} else {
						$(".modal-body select[name='bodega']").append( '<option value="'+response[0][i].id+'">'+response[0][i].nombre_bodega+'</option>' );
						}
					}
				for (i = 0; i < response[1].length; i++){
						if(response[1][i].id == cajero){
							$(".modal-body select[name='cajero']").append( '<option selected="true" value="'+response[1][i].id+'">'+response[1][i].name+'</option>' );
						} else {
							$(".modal-body select[name='cajero']").append( '<option value="'+response[1][i].id+'">'+response[1][i].name+'</option>' );
						}
				}
			}
	});
}

 function BorrarFormularioUpdate() {
	$("#FormcajasUpdate :input").each(function () {
		$(this).val('');
	});
};
 
$("#ButtonBoletaUpdate").click(function(event) {
	if ($('#FormcajasUpdate').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
}); 


$("#ButtonTipoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#FormcajasUpdate').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	var formData = $("#FormcajasUpdate").serialize();
	var id = $("input[name='test']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#cajasToken').val()},
		url: "/cajas/"+id+"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			BorrarFormularioUpdate();
			$('#editUpdateModal1').modal("hide");
			cajas_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Caja editada con Éxito!!');
		},
	});
}

if(window.location.hash === '#edit')
		{
			$('#editUpdateModal1').modal('show');
		}

		$('#editUpdateModal1').on('hide.bs.modal', function(){
			$("#FormcajasUpdate").validate().resetForm();
			document.getElementById("FormcajasUpdate").reset();
			window.location.hash = '#';
		});

		$('#editUpdateModal1').on('shown.bs.modal', function(){
			window.location.hash = '#edit';
	});

	$.validator.addMethod("nombreunicoedit", function(value, element){
        var valid = false;
        var id = $("input[name='test']").val();
        var urlActual = $("input[name='urlActual']").val();
        $.ajax({
            type: "GET",
            async: false,
            url: "/cajas/nombreDisponibleEdit/",
            data: {value, id},
            dataType: "json",
            success: function (msg) {
                valid=!msg;
            }
        });
        return valid;
		}, "La caja ya está registrada en el sistema");
		
	