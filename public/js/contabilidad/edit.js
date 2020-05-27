

    $('#modalConfiguraFecha3').on('shown.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var codigo = button.data('codigo');
        var tipo_de_pago = button.data('tipo_de_pago');
        var Nombre1 = button.data('Nombre1');
        var precio_particular = button.data('precio_particular');
        var categoria_id = button.data('categoria_id');

        var modal = $(this);
        modal.find(".modal-body input[name='test']").val(id);
        modal.find(".modal-body input[name='codigo']").val(codigo);
        modal.find(".modal-body input[name='tipo_de_pago']").val(tipo_de_pago);
        modal.find(".modal-body input[name='Nombre1']").val(Nombre1);
        modal.find(".modal-body input[name='precio_particular']").val(precio_particular);
        modal.find(".modal-body #categoria_id").val(categoria_id);

     });

    function BorrarFormularioUpdate() {
        $("#FormTipoPagoUpdate :input").each(function () {
            $(this).val('');
        });
    };

    $("#ButtonTipoModalUpdate").click(function(event) {
        event.preventDefault();
        if ($('#FormTipoPagoUpdate').valid()) {
            updateModal();
        } else {
            validator.focusInvalid();
        }
    });

    function updateModal(button) {
        var formData = $("#FormTipoPagoUpdate").serialize();
        var id = $("input[name='test']").val();
        var urlActual =  $("input[name='urlActual']").val();
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('#tipopagoToken').val()},
            url: "/tipoDePago/"+id+"/update",
            data: formData,
            dataType: "json",
            success: function(data) {
                BorrarFormularioUpdate();
                $('#editUpdateModal').modal("hide");
                tipodepago_table.ajax.reload();
                alertify.set('notifier','position', 'top-center');
                alertify.success('Tipo de pago Editado con Éxito!!');
            },
        });
    }

    if(window.location.hash === '#edit')
            {
                $('#editUpdateModal').modal('show');
            }

            $('#editUpdateModal').on('hide.bs.modal', function(){
                $("#FormTipoPagoUpdate").validate().resetForm();
                document.getElementById("FormTipoPagoUpdate").reset();
                window.location.hash = '#';
            });

            $('#editUpdateModal').on('shown.bs.modal', function(){
                window.location.hash = '#edit';

        });

    $.validator.addMethod("nombreunicoedit", function(value, element){
        var valid = false;
        var urlActual = $("input[name='urlActual']").val();
        $.ajax({
            type: "GET",
            async: false,
            url: "/tipoDePago/nombreDisponibleEdit/",
            data:"codigo=" + value,
            dataType: "json",
            success: function (msg) {
                valid=!msg;
            }
        });
        return valid;
        }, "El código ya esta registrado en el sistema");

