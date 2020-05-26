
$('#modalConfiguraFecha').on('shown.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var n_colegiado = button.data('n_colegiado');
    var Nombre1 = button.data('nombre1');
    var nombre_banco = button.data('nombre_banco');
    var tipo_cuenta = button.data('tipo_cuenta');
    var no_cuenta = button.data('no_cuenta');
    var id = button.data('id');

    
    var modal = $(this);
    modal.find(".modal-body input[name='n_colegiado']").val(n_colegiado);
    modal.find(".modal-body input[name='Nombre1']").val(Nombre1);
    modal.find(".modal-body input[name='nombre_banco']").val(nombre_banco);
    modal.find(".modal-body input[name='tipo_cuenta']").val(tipo_cuenta);
    modal.find(".modal-body input[name='no_cuenta']").val(no_cuenta);
    modal.find(".modal-body input[name='idSolicitud']").val(id);

 });

 
var validator = $("#FormFechaAp").validate({
    ignore: [],
    onkeyup:false,
    onclick: false,
    //onfocusout: false,
    rules: {
        fecha_pago_ap:{
            required: true,
               },
    },
    messages: {
        fecha_pago_ap: {
            required: "Por favor, ingrese la fecha",
        },
    }
});
    $("#ButtonFechaPagoAp").click(function(event) {
        event.preventDefault();
        if ($('#FormFechaAp').valid()) {
            updateModal();
        } else {
            validator.focusInvalid();
        }
    });

    function updateModal(button) {
        var formData = $("#FormFechaAp").serialize();
        var id = $("input[name='idSolicitud']").val();
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('#tipopagoToken').val()},
            url: "/resolucion/"+id+"/fecha",
            data: formData,
            dataType: "json",
            success: function(data) {
                BorrarFormularioUpdate();
                $('#FormFechaAp').modal("hide");
                resolucion_table.ajax.reload();
                alertify.set('notifier','position', 'top-center');
                alertify.success('Datos agregados con Éxito!!');
            },
        });
    }