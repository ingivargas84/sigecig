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
		}
	}
});



$('#editUpdateModal1').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre_caja = button.data('nombre_caja');
	var subsede = button.data('subsede');
	var cajero = button.data('cajero');
	

	var modal = $(this);
	modal.find(".modal-body input[name='test']").val(id);
	modal.find(".modal-body input[name='nombre_caja']").val(nombre_caja);
	modal.find(".modal-body select[name='subsede']").val(subsede);
	modal.find(".modal-body select[name='cajero']").val(cajero);
	
 });

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