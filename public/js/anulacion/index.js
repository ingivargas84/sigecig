var anulacion_table = $('#anulacion-table').DataTable({
    //"ajax": "/boletas/getJson",
    "responsive": true,
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
    'csvHtml5'
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
        "title": "Recibo",
        "data": "recibo",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Colegiado",
        "data": "colegiado",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Nombre Colegiado",
        "data": "nombre",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Cajero",
        "data": "cajero",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Fecha De Anulación",
        "data": "fecha_respuesta",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Estado",
        "data": "estado",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Acciones",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if(rol_user == 'Super-Administrador' || rol_user == 'Administrador' || rol_user == 'Contabilidad'){
                if (full.estado == 'En Revisión') {
                    return  "<div id='" + full.id + "' class='text-center'>" +
                            "   <div class='float-left col-lg-3'>" +
                            "       <a href='/detalleRecibo/"+full.recibo+"'>" +
                            "           <i class='fa fa-btn fa-edit' title='Ver Detalle del Recibo'></i>" +
                            "       </a>" +
                            "   </div>" +
                            "   <div class='float-right col-lg-3'>" +
                            "       <a href='/anulacion/detalle/"+full.id+"'>" +
                            "           <i class='fa fa-list' title='Detalles de Anulación'></i>" +
                            "       </a>" +
                            "   </div>" +
                            "   <div class='float-right col-lg-3'>" +
                            "       <a href='/tracking/anulacion/"+full.id+"'>" +
                            "           <i class='fa fa-exchange' style='color:orange;' title='Traking de Anulación'></i>" +
                            "       </a>" +
                            "   </div>" +
                            "   <div class='float-right col-lg-3'>" +
                            "       <a href='/respuestaSolicitudAnulacion?id="+full.id+"'>" +
                            "           <i class='fa fa-cog fa-spin' style='color:red;' title='Respuesta de Anulación'></i>" +
                            "       </a>" +
                            "   </div>" +
                            "</div>";
                } else {
                    return  "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-4'>" +
                            "<a href='/detalleRecibo/"+full.recibo+"'>" +
                            "<i class='fa fa-btn fa-edit' title='Ver Detalle del Recibo'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-4'>" +
                            "<a href='/anulacion/detalle/"+full.id+"'>" +
                            "<i class='fa fa-list' title='Detalles de Anulación'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-4'>" +
                            "<a href='/tracking/anulacion/"+full.id+"'>" +
                            "<i class='fa fa-exchange' style='color:orange;' title='Traking de Anulación'></i>" +
                            "</a>" + "</div>";
                }
            } else {
                return  "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-left col-lg-4'>" +
                        "<a href='/detalleRecibo/"+full.recibo+"'>" +
                        "<i class='fa fa-btn fa-edit' title='Ver Detalle del Recibo'></i>" +
                        "</a>" + "</div>" +
                        "<div class='float-right col-lg-4'>" +
                        "<a href='/anulacion/detalle/"+full.id+"'>" +
                        "<i class='fa fa-list' title='Detalles de Anulación'></i>" +
                        "</a>" + "</div>" +
                        "<div class='float-right col-lg-4'>" +
                        "<a href='/tracking/anulacion/"+full.id+"'>" +
                        "<i class='fa fa-exchange' style='color:orange;' title='Traking de Anulación'></i>" +
                        "</a>" + "</div>";
            }
        },
        "responsivePriority": 5
    }]

});

