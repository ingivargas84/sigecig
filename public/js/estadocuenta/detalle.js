var resolucion_table = $('#resolucion-table').DataTable({
    "ajax": "/estadocuenta/getDetalle/$id",
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
            "data": "estado_cuenta_maestro_id",
            "width" : "0%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
            },



            {
                "title": "Cantidad",
                "data": "cantidad",
                "width" : "10%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
                },

                    {
                        "title": "Tipo de Pago",
                        "data": "tipo_de_pago",
                        "width" : "20%",
                        "responsivePriority": 1,
                        "render": function( data, type, full, meta ) {
                            return (data);},
                        },

                        {
                            "title": "No recibo",
                            "data": "recibo_id",
                            "width" : "10%",
                            "responsivePriority": 2,
                            "render": function( data, type, full, meta ) {
                                return (data);},
                            },
                            {
                                "title": "Cargos",
                                "data": "cargo",
                                "width" : "10%",
                                "responsivePriority": 2,
                                "render": function( data, type, full, meta ) {

                                        return "<div class='text-right' >" +
                                        "<div class='float-left col-lg-4'>Q." + "</div>" +
                                        "<div class='float-right col-lg-6' style='color:black; float:right;'>" + (data)+
                                        "</div>";


                                },
                                },
                                {
                                    "title": "Abonos",
                                    "data": "abono",
                                    "width" : "10%",
                                    "responsivePriority": 2,
                                    "render": function( data, type, full, meta ) {

                                            return "<div class='text-right' >" +
                                            "<div class='float-left col-lg-4'>Q." + "</div>" +
                                            "<div class='float-right col-lg-6' style='color:black; float:right;'>" + (data)+
                                            "</div>";


                                    },
                                    },


                            {
                                "title": "Acciones",
                                "data": "estado_solicitud_ap",
                                "orderable": false,
                                "width" : "15%",
                                "render": function(data, type, full, meta) {
                                    var urlActual = $("input[name='urlActual']").val();
                                    var rol = $("input[name='rol_user']").val();


                return "<div id='" + full.id + "' class='text-center'>" +
                "<div class='float-center'>" +
                "<a href='/creacionRecibo/pdf/"+full.recibo_id+ "/'target=''>" +
                "<i class='fa fa-info-circle' title='Ver Detalles'></i>" +
                "</a>" + "</div>"




        },
        "responsivePriority": 4
    }

                            ]
});







