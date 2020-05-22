var contabilidad_table = $('#contabilidad-table').DataTable({
    "ajax": "/resolucion/getJson",
    "responsive": true,
    "retrieve": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
    ],

    "buttons": [
    'pageLength',
    'excelHtml5',
    'csvHtml5',
    'pdfHtml5'
    ],

    "paging": true,
    "language": {
        "sdecimal":        ".",
        "sthousands":      ",",
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],
    "columns": [ {
        "visible": false,
        "title": "No.",
        "data": "id",
        "width" : "0%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "visible": false,
        "title": "id",
        "data": "id",
        "width" : "0%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "visible": false,
        "title": "No. Solicitud",
        "data": "no_solicitud",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
     
    {
        "title": "No. Colegiado",
        "data": "n_colegiado",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Nombre",
        "data": "Nombre1",
        "width" : "40%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Estado Solicitud",
        "data": "estado_solicitud_ap",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Acciones",
        "data": "estado_solicitud_ap",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {
            var urlActual = $("input[name='urlActual']").val();
            if(data == 'Documentos Enviados'){  //Estado 2 de la solicitud

                return "<div class='text-center'>" + 
                "<div class='float-center'>" + 
                "<a href='/resolucion/asap/" + full.id + "' class='asap' >" + 
                "<i class='fas fa-check-square' title='Autoriza Solicitud AP'></i>" + 
                "</a>" + "</div>";
            }
            else if(data == 'Ingreso de acta'){  //Estado 7 de la solicitud

                return "<div class='text-center'>" + 
                "<div class='float-center'>" + 
                "<a href='/pdf/"+full.id+ " 'target='_blank'>" +
                "<i class='fas fa-print' title='Imprimir'></i>" + 
                "</a>" + "</div>" +
                "<div class='text-center'>" + 
                "<div class='float-center'>" + 
                "<a href='resolucion/"+full.id+"/cambio' class='cambiar-estado' "+ "data-method='post' data-id='"+full.id+"'>" +
                "<i class='fas fa-sync-alt' title='Cambiar estado'></i>" + 
                "</a>" + "</div>";
            }   
            else if(data == 'Aprobado por Junta'){    //Estado 5 de la solicitud

                return "<div class='text-center'>" + 
                "<div class='float-center'>" + 
                "<a href='resolucion/"+full.id+"/cambio' class='edit-user' data-toggle='modal' data-target='#modalIngresoActa' data-id='"+full.id+"'>" +                 
                "<i class='fas fa-address-card' title='Ingreso de Acta'></i>" + 
                "</a>" + "</div>";
            }
            else if(data == 'Resolución Firmada'){   //Estado 8 de la solicitud

                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-center'>" + 
                "<a href='contabilidad/"+full.id+"/fecha' class='edit-user' data-toggle='modal' data-target='#modalConfiguraFecha' data-id='"+full.id+"' data-email='"+full.email+"' data-username='"+full.username+"' data-rol='"+full.rol+"' data-name_user='"+full.name+"'>" + 
                "<i class='fas fa-flag' title='Configurar fecha de pago'></i>" + 
                "</a>" + "</div>";
            }
            else return "";
        },
        "responsivePriority": 4
    }]
});

    $('#modalConfiguraFecha').on('shown.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        

        var modal = $(this);
        modal.find(".modal-body input[name='idSolicitud']").val(id);

     });

    var validator = $("#ActaForm").validate({
        ignore: [],
        onkeyup:false,
        onclick: false,
        //onfocusout: false,
        rules: {
            no_acta:{
                required: true,
            },
            no_punto_acta: {
                required : true
            }
        },
        messages: {
            no_acta: {
                required: "Por favor, ingrese el No. de Acta",
            },
            no_punto_acta: {
                required: "Por favor, ingrese el No. de Punto de Acta"
            }
        }
    });

    $("#ButtonActaModal").click(function(event) {
        event.preventDefault();
        if ($('#ActaForm').valid()) {
            updateModal();
        } else {
            validator.focusInvalid();
        }
    });

    function updateModal(button) {
        var formData = $("#ActaForm").serialize();
        var id = $("input[name='idSolicitud']").val();
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('#tipopagoToken').val()},
            url: "contabilidad/"+id+"/fecha",
            data: formData,
            dataType: "json",
            success: function(data) {
                BorrarFormularioUpdate();
                $('#modalConfiguraFecha').modal("hide");
                contabilidad_table.ajax.reload();
                alertify.set('notifier','position', 'top-center');
                alertify.success('Datos de Acta agregados con Éxito!!');
            },
        });
    }

    function BorrarFormularioUpdate() {
        $("#ActaForm :input").each(function () {
            $(this).val('');
        });
    };

/*function confirmar() {
    var txt;
    if (confirm("Press a button!")) {
      txt = "You pressed OK!";
    } else {
      txt = "You pressed Cancel!";
    }
    document.getElementById("demo").innerHTML = txt;
  }*/