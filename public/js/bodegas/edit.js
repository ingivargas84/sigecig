var validator = $("#BodegaUpdate").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_bodega:{
			required: true
        },
        descripcion: {
			required : true
		}
	},
	messages: {
		nombre_bodega: {
			required: "Por favor, ingrese el nombre de la bodega"
        },
        descripcion: {
			required: "Por favor, ingrese la descripción"
		}
	}
});



$('#editUpdateModal1').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre_bodega = button.data('nombre_bodega');
	var descripcion = button.data('descripcion');
	

	var modal = $(this);
	modal.find(".modal-body input[name='test']").val(id);
	modal.find(".modal-body input[name='nombre_bodega']").val(nombre_bodega);
	modal.find(".modal-body select[name='descripcion']").val(descripcion);
	
 });

 function BorrarFormularioUpdate() {
	$("#BodegaUpdate :input").each(function () {
		$(this).val('');
	});
};

$("#ButtonBoletaUpdate").click(function(event) {
	if ($('#BodegaUpdate').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});


$("#ButtonTipoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#BodegaUpdate').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	var formData = $("#BodegaUpdate").serialize();
	var id = $("input[name='test']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#bodegasToken').val()},
		url: "/bodegas/"+id+"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			BorrarFormularioUpdate();
			$('#editUpdateModal1').modal("hide");
			bodegas_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Bodega editada con Éxito!!');
		},
	});
}

if(window.location.hash === '#edit')
		{
			$('#editUpdateModal1').modal('show');
		}

		$('#editUpdateModal1').on('hide.bs.modal', function(){
			$("#BodegaUpdate").validate().resetForm();
			document.getElementById("BodegaUpdate").reset();
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