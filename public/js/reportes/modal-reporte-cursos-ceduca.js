$( document ).ready(function() {
    jQuery.validator.addMethod("greaterThan", function(value, element, params) {
        if ($(params[0]).val() != '') {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) >= new Date($(params[0]).val());
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        };
        return true;
    },'Must be greater than {1}.');

    var validator = $("#form-cursos-ceduca").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            cursos:{
                required: true

            }
        },
        messages: {
            cursos: {
                required: "Elija un Curso"
            }
        },

    });
});

$('#modal-reporte-cursos-ceduca').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "get",
        url: "/cursos/getTiposDePago/",
        success: function (data) {
            $("#cursos").empty();
            console.log(data);
            $("#cursos").selectpicker('refresh').append('<option value="">Nothing selected</option>').selectpicker('refresh').trigger('change');
            $("#cursos").selectpicker('refresh').append('<option value="100000">-- TODOS --</option>').selectpicker('refresh').trigger('change');

            for (let i=0; i<data.length;i++)
            {
                $("#cursos").selectpicker('refresh').append('<option value="'+data[i]["id"]+'">'+data[i]["codigo"]+' - '+data[i]["descripcion"]+'</option>').selectpicker('refresh').trigger('change');
            }
        },
        error: function (jqXHR, estado, error){
            console.log(estado)
            console.log(error)
        }
    });
});

