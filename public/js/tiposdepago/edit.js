$('#FormTipoPagoUpdate').on('shown.bs.modal', function (event) {
    $('#editUpdateModal').modal('show');
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var codigo = button.data('codigo');
    var tipo_de_pago = button.data('tipo_de_pago');
    var precio_colegiado = button.data('precio_colegiado');
    var precio_particular = button.data('precio_particular');
    var categoria_id = button.data('categoria_id');
    var modal = $(this);
    modal.find(".modal-body input[name='id']").val(id);
    modal.find(".modal-body input[name='codigo']").val(codigo);
    modal.find(".modal-body input[name='tipo_de_pago']").val(tipo_de_pago);
    modal.find(".modal-body input[name='precio_colegiado']").val(precio_colegiado);
    modal.find(".modal-body input[name='precio_particular']").val(precio_particular);
    modal.find(".modal-body input[name='categoria_id']").val(categoria_id);

});

var validator = $("#FormTipoPagoUpdate").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        codigo: {
            required: true,
        }
    },
    messages: {
        codigo: {
            required: "Por favor, ingrese la forma de pago"
        }
    }
});
//Actualizar
function updateModal(button) {
    var formData = $("#FormTipoPagoUpdate").serialize();
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#tipopagoToken').val() },
        url: urlActual + "/" + id + "/update",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioUpdate();
            $('#FormTipoPagoUpdate').modal("hide");
            formaPago.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Forma de Pago editada con Éxito!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.email != null) {
                $("#FormTipoPagoUpdate input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>" + errors.email + "</label>");
            }
            else {
                $("#ErrorNombreedit").remove();
            }
        }
    });
}
//Guardar
$("#ButtonTipoModalUpdate").click(function (event) {
    event.preventDefault();
    if ($('#FormTipoPagoUpdate').valid()) {
        updateModal();
    } else {
        validator.focusInvalid();
    }
});
//Eliminar data de form
function BorrarFormularioUpdate() {
    $("#FormTipoPagoUpdate :input").each(function () {
        $(this).val('');
    });
};
//Cambio de url para editar
if (window.location.hash === '#edit') {
    $('#FormTipoPagoUpdate').modal('show');
}
$('#FormTipoPagoUpdate').on('hide.bs.modal', function () {
    $("#FormTipoPagoUpdate").validate().resetForm();
    document.getElementById("FormTipoPagoUpdate").reset();
    window.location.hash = '#';
});
$('#FormTipoPagoUpdate').on('shown.bs.modal', function () {
    window.location.hash = '#edit';
});
